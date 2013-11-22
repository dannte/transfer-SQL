<?php

namespace App\Models;

use Silex;
use Silex\Provider\DoctrineServiceProvider;

class Report
{
  const SECTION_FLAG = -1;
  const SPLIT_INDEX  = 25; //position that divides the array to EXPORT DATA and EXPORT PEOPLE

  protected $app = null;



  public function __construct($app)
  {
    $this->app = new Silex\Application();
  }

  public function addNewConnect($arrData)
  {
      $data = $arrData;
      $arr  = array
      (
          $data['db_name'] => array
          (
              'driver'   => 'pdo_mysql',
              'host'     => $data['connect_host'],
              'dbname'   => $data['db_name'],
              'user'     => $data['connect_user'],
              'password' => $data['connect_password'],
              'charset'  => 'utf8'
          )
      );


//$this->app->register(new Silex\Provider\DoctrineServiceProvider(), array(
//    'dbs.options' => $arr
//));

$this->app['db']->fetchAssoc('SELECT * FROM some');
   var_dump($this->app['db']->fetchAssoc('SELECT * FROM some'));
  }
  public function buildReport()
  {
    $schema = $this->app['report_schema'];
    $report = array();

    $i = 1;
    foreach ($schema as $k => $q) {
      if (!$q['use_in_report']) {
        continue;
      }

      $type = null;

      if (isset($q['type'])) {
        $type = $q['type'];
      }

      $tableField = null;

      if (isset($q['table_field'])) {
        $tableField = $q['table_field'];
      }

      $values = array();

      if ($q['values'] && is_array($q['values'])) {
        $values = $q['values'];
      }

      $values = $this->getValues($type, $tableField, $values);


      if ($values) {
        $surveyQuestion = array(
          'no'     => $i,
          'title'  => isset($q['title']) ? $q['title'] : '',
          'values' => $values
        );

        $report[] = $surveyQuestion;
        $i++;
      }
    }

    return $report;
  }

  public  function getListOfFields()
  {
      $arrTemp  = array();
      $schema = $this->app['report_schema'];

      if (!$schema){
          return;
      }

      foreach ($schema as  $val) {
          switch ($val['type']) {
              case 'list' :
                  $arrTemp[]  =  array($val['title'],$val['table_field']);
                  break;
              case 'multi' :
                  foreach($val['values'] as $item){
                      $arrTemp[]  =  array($item['label'],$item['table_field']);
                  }
                  break;
              case 'binary':
                  $arrTemp[]  =  array($val['title'],$val['table_field']);
                  break;
              case 'single':
                  $arrTemp[]  =  array($val['title'],$val['table_field']);
                  break;
              case 'text' :
                  $arrTemp[]  =  array($val['title'],$val['table_field']);
                  break;
          }
      }

     if (count($arrTemp) == 0){
         return false;
     }

     return  array_chunk($arrTemp,self::SPLIT_INDEX);
  }

  public function getListKeyFields($paramSelect = null) {

      $tempArray = $this->getListOfFields();
      $result = array();
      $k = $paramSelect == null ? 1 : 0;

      if (count($tempArray) > 0) {

          foreach($tempArray as $v) {
              $result[] = $v[$k];
          }
      }
      return $result;
  }
  // Tets method
  protected function getValues($type, $field, $schema)
  {
    $values = array();

    switch ($type) {
      case 'list' :
     
        foreach ($schema as $k => $v) {        
          // Case 1: values separated by sections
          if (is_array($v)) {
            $values[$k] = self::SECTION_FLAG;
           
            foreach ($v as $val) {
              // var_dump($val);
              $values[$val] = 0;
            }

          } else {
            $values[$v]  = 0;
          }
        }

        if (!$field) {
          return $values;
        }

        $fieldsSet = array_filter($values, function($v)  { return $v != -1; });
        $fieldsSet = array_keys($fieldsSet);

        $groupedValues = $this->getAnswersCount($fieldsSet, $field);
        foreach ($groupedValues as $row) {
          $values[$row['val']] = $row['count_answers'];
        }

        break;

      case 'single' :

        $fieldsSet = array();
        foreach ($schema as $k => $v) {
          $fieldsSet[] = $v;
        }

        $groupedValues = $this->getAnswersCount($fieldsSet, $field);
        foreach ($groupedValues as $row) {
          $values[$row['val']] = $row['count_answers'];
        }

        break;

      case 'multi' :

        foreach ($schema as $k => $f) {

          if (!isset($f['range'])) {
            continue;
          }

          $groupedValues = $this->getAnswersCount($f['range'], $f['table_field']);
          foreach ($groupedValues as $row) {
            $swap[$row['val']] = $row['count_answers'];
          }

          foreach ($f['range'] as $rangeItem) {
            if (!isset($swap[$rangeItem])) {
              $swap[$rangeItem] = 0;
            }
          }

          ksort($swap);

          $values[$f['label']] = $swap;
        }

        break;

      case 'binary' :

        foreach ($schema as $k => $v) {
          $fieldsSet[] = $k; // because it's binary
        }

        $groupedValues = $this->getAnswersCount($fieldsSet, $field);
        foreach ($groupedValues as $row) {
          $key = $schema[$row['val']];
          $values[$key] = $row['count_answers'];
        }

        break;

      case 'text' :
        return false;
        break;
    }

    return $values;
  }

  protected function getAnswersCount($fieldsSet, $field)
  {
    $query[] = "SELECT val, COUNT(*) AS count_answers \n FROM \n( \n";
    $swap    = array();

    foreach ($fieldsSet as $elValue) {
      $elValue = str_replace("'", '', $elValue);
      $swap[]  = "SELECT '{$elValue}' AS val";
    }

    $query[] = implode("\n UNION ALL \n", $swap);
    $query[] = "\n) v \n JOIN `survey` s ON FIND_IN_SET(v.val, s.{$field}) \n";
    $query[] = "GROUP BY v.val \n";

    $sqlQuery = implode('', $query);

    $dbr = $this->app['db']->query($sqlQuery);

    if ($dbr) {
      return  $dbr->fetchAll(\PDO::FETCH_ASSOC);
    }

    return array();
  }
}
