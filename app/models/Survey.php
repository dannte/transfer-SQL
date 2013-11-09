<?php 

namespace App\Models;



/**
 * Survey Model
 */
class Survey
{
  protected $app = null;

  public $formFields = [];

  protected $dbh = null;

  protected $_tableName = 'survey';

  /**
   * Constructor
   * @var $app
   */
  public function __construct($app)
  {
    $this->app = $app;
  }

  protected function isAllFilled($post, $keys)
  {
      //TODO: 9 and 14 questions
      $flag = 1;

      $count = count($keys);

      if($count > 0) {
         foreach($keys as $v) {

            if (!array_key_exists($v[1], $post) && ($v != 'subscribe_for_viawala_magazine' && $v != 'is_know_about_brocuhures' && $v != 'rating_understandable_text' && $v != 'know_our_patientbroschures')) {
                return 0;
            }
         }
      }

      if($post['read_newsletter_lately'] == 0) {
          $flag &= isset($post['rating_understandable_text']) ? 1 : 0;
      }
      if($post['patient_brochures'] == 0) {
         $flag &= isset($post['know_our_patientbroschures']) && $post['know_our_patientbroschures'] != '' ?  1 : 0;
      }
      return $flag;
  }

  public function loadPost($post, $keys)
  {

    foreach($post as $key => $item) {
      if(gettype($item) == 'array') {
          $post[$key] = $this->_prepareInsertArray($item);
      }
    }

    $post['full_complete'] = $this->isAllFilled($post,$keys);

    $this->_insert($post);
  }

  protected function _insert($data)
  {
      $this->app['db']->insert($this->_tableName, $data);
  }

  protected function _prepareInsertArray($data)
  {
      foreach ($data as $key => $val) {
        $data[$key] = str_replace(',', '', $val);
      }

      return implode(",", $data);
  }

  protected function _getAllCollection()
  {
    $sql = "SELECT * FROM `{$this->_tableName}` ";
    $result = $this->app['db']->prepare($sql);
    $result->execute();

    return $result->fetchAll();
  }

  public function filter()
  {
      $result     = array();
      $collection = $this->_getAllCollection();

      if(count($collection) > 0)
      {
          foreach($collection as $items)
          {
              foreach($items as $key => $item)
              {
                  if($key == 'anthroposophic_medicine' || $key == 'regularly_read_the_tip' || $key == 'read_newsletter_lately' || $key == 'patient_brochures' || $key == 'is_subscribed' || $key == 'have_childs')
                  {
                        $items[$key] = $item == 0 ? 'Ja' : 'Nein';
                  }
              }

              array_shift($items);
              array_push($result,$items);
          }
      }

      return $result;
  }

  public function getCollection($param)
  {
      $result = array();

      if($param && count($param['question']) > 0)
      {
          $item   = implode(',', $param['question']);
          $query  = "SELECT {$item} FROM {$this->_tableName}";
          $result = $this->app['db']->prepare($query);
          $result->execute();
      }

      return  count($result) > 0 ? $result->fetchAll(\PDO::FETCH_ASSOC) : null;
  }

  public function getTable($collection,$newName, $selectParam = 0)
  {

      $title = array();
      $newName[] = array('Volle komplette','full_complete');

      if(count($newName) > 0 && count($collection[0]) > 0) {

          foreach($newName[$selectParam] as $v) {
              if (isset($collection[0][$v[1]]))  {
                  $title[0][] = $v[0];
              }
          }

          $i = 1;

          foreach($collection as  $t) {
              foreach($t as $val) {
                  $title[$i][] = $val;
              }
              $i++;
          }
      }

      return $title;
  }
}

