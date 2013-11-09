<?php 

// Types:
//  - list
//  - multi
//  - binary
//  - single
//  - text

return array(
  // Question 1
  array(
    'title'  => 'Sind Sie Verwender einer oder mehrerer der folgenden Marken?',
    'type'   => 'list',
    'values' => array(
        'Dr. Hauschka', 
        'Dr. Hauschka Med',
        'WALA Arzneimittel'
    ),
    'table_field'   => 'brands',
    'use_in_report' => true
  ),
  // Question 2
  array(
    'title'  => 'Wie groß ist Ihr Interesse an',
    'type'   => 'multi',
    'values' => array(
        array(
          'label'       => 'Dr. Hauschka Kosmetik',
          'type'        => 'range',
          'range'       => array(0, 1, 2, 3, 4, 5),
          'table_field' => 'rating_dr_hauschka_kosmetik'
        ),
        array(
          'label'       => 'Dr.Hauschka Med',
          'type'        => 'range',
          'range'       => array(0, 1, 2, 3, 4, 5),
          'table_field' => 'rating_dr_hauschka_med'
        ),
        array(
          'label'       => 'WALA Arzneimittel',
          'type'        => 'range',
          'range'       => array(0, 1, 2, 3, 4, 5),
          'table_field' => 'rating_wala_arzneimittel'
        ),
        array(
          'label'       => 'WALA Heilmittel GmbH',
          'type'        => 'range',
          'range'       => array(0, 1, 2, 3, 4, 5),
          'table_field' => 'rating_wala_heilmittel_gmbh'
        ),
        array(
          'label'       => 'Heilpflanzen',
          'type'        => 'range',
          'range'       => array(0, 1, 2, 3, 4, 5),
          'table_field' => 'rating_heilpflanzen'
        )
     ),
    'use_in_report' => true
  ),
  // Question 3
  array(
    'title'  => 'Verwenden Sie Anthroposophische Arzneimittel?',
    'type'   => 'binary',
    'values' => array(
        0 => 'Nein',
        1 => 'Ja'
    ),  
    'table_field'   => 'anthroposophic_medicine',
    'use_in_report' => true
  ),
  // Question 4
//  array(
//    'title'  => 'In welchen Fällen greifen Sie auf Anthroposophische Medizin zurück?',
//    'type'   => 'list',
//    'values' => array(
//      'Körperliche Beschwerden' => array(
//        'Vorbeugung von Krankheiten',
//        'Erkältungen',
//        'Allergien',
//        'Augenbeschwerden',
//        'Schmerzbehandlung',
//        'Schwangerschaftsbeschwerden',
//        'Kinderkrankheiten',
//        'Sonstige und zwar'
//      ),
//      'Schnelle Hilfe' => array(
//        'Arzneimittel für unterwegs',
//        'Arzneimittel für die Erste Hilfe',
//        'Frauenbeschwerden',
//        'Hautverletzungen/-irritationen',
//        'Sport- und Bewegungsbeschwerden',
//        'Verdauungsprobleme',
//        'Sonstige und zwar'
//      ),
//      'Psychische Beschwerden' => array(
//        'Stress',
//        'Erschöpfung',
//        'Erschöpfung',
//        'Unruhe',
//        'Sonstige und zwarpf'
//      )
//    ),
//    'table_field'   => 'anthroposophic_medicine_cases',
//    'use_in_report' => true
//  ),
  // Question 5
  array(
    'title'  => 'Für wen wünschen Sie sich mehr Gesundheitstipps? Mehrfachnennung möglich',
    'type'   => 'list',
    'values' => array(
      'Senioren',
      'Berufstätige',
      'Männer',
      'Pflegebedürftige und Pflegende',
      'Sonstige und zwar',
      'Frauen',
      'Schwangere',
      'Kinder',
      'Säuglinge'
    ),
    'table_field'   => 'health_tips',
    'use_in_report' => true
  ),
  // Question 6
  array(
    'title'  => 'Lesen Sie regelmäßig den Tipp des Monats?',
    'type'   => 'binary',
    'values' => array(
        0 => 'Nein',
        1 => 'Ja'
    ),  
    'table_field'   => 'regularly_read_the_tip',
    'use_in_report' => true 

  ),
  // Question 7
  array(
    'title'  => 'Welche Inhalte wünschen Sie sich für den Tipp des Monats?',
    'type'   => 'list',
    'values' => array(
        'Anthroposophische Medizin' => array(
          'Tipps bei Krankheitssymptomen',
          'Tipps zur Vorbeugung von Krankheiten',
          'Veranstaltungstipps', 
          'Anwendungshinweise',
          'Buchtipp',
          'Sonstige und zwar'
        ),
        'Naturkosmetik' => array(
          'Schminktipps',
          'Anwendungshinweise',
          'Veranstaltungstipps', 
          'Buchtipp',
          'Sonstige und zwar'
        ),
        'Umweltschutz' => array(
          'Tipps für Zuhause',
          'Veranstaltungstipps',
          'Buchtipp',
          'Sonstige und zwar'
        )
    ),  
    'table_field'   => 'preferable_type_of_conttent',
    'use_in_report' => true 
  ),
  // Question 8
  array(
    'title'  => 'Haben Sie in letzter Zeit einen Newsletter-Text über die WALA Arzneimittel gelesen?',
    'type'   => 'binary',
    'values' => array(
        0 => 'Nein',
        1 => 'Ja'
    ),  
    'table_field' => 'read_newsletter_lately',
    'use_in_report' => true  
  ),
  // Question 9
  array(
    'title'  => 'Wie verständlich war dieser Text für Sie?',
    'type'   => 'multi',
    'values' => array(
        array(
          'label'       => 'Wie verständlich war dieser Text für Sie?',
          'type'        => 'range',
          'range'       => array(0, 1, 2, 3, 4, 5),
          'table_field' => 'rating_understandable_text'
        ),
    ),  
    'table_field' => 'read_newsletter_lately',
    'use_in_report' => true  
  ),
  // Question 10
//  array(
//    'title'  => 'Welche Inhalte wünschen Sie sich bei einem Text zum Thema Anthroposophische Arzneimittel?',
//    'type'   => 'list',
//    'values' => array(
//      'Expertenmeinungen und -interviews',
//      'Diagramme und Schaubilder',
//      'Statistiken',
//      'Tipps, die ich zu Hause umsetzen kann',
//      'Sonstige und zwar'
//    ),
//    'table_field' => 'expected_content',
//    'use_in_report' => true
//  ),
  // Question 11
  array(
    'title'  => 'Worüber möchten Sie im Newsletter informiert werden?',
    'type'   => 'list',
    'values' => array(
      'WALA Heilmittel GmbH' => array(
          'Nachrichten aus dem Unternehmen WALA',
          'Nachhaltigkeit und Umweltschutz',
          'Informationen zur Anthroposophie',
          'Heilfplanzen',
          'Mineralien',
          'Sonstige und zwar'
      ),
      'Anthroposophische Medizin' => array(
        'Informationen zur Anthroposophischen Medizin',
        'Anthroposophische Therapieformen wie z.B. Wickel, Auflagen, rhythmische Massagen oder Kunsttherapie',
        'Informationen über die Zusammensetzung und Herkunft der Ausgangsstoffe', 
        'Anwendungstipps', 
        'Sonstige und zwar'
      ),
      'Dr. Hauschka' => array(
        'Produktneuheiten', 
        'Anwendungstipps und Schminktipps', 
        'Sonstige und zwar'
      )
    ),  
    'table_field' => 'expected_information',
    'use_in_report' => true  
  ),
  // Question 12
  array(
    'title'  => 'Bewerten Sie bitte das Layout des Newsletters.',
    'type'   => 'multi',
    'values' => array(
        array(
          'label'       => 'Das Layout des Newsletters gefällt mir sehr gut.',
          'type'        => 'range',
          'range'       => array(0, 1, 2, 3, 4, 5),
          'table_field' => 'rating_layout'
        ),
        array(
          'label'       => 'Das Layout des Newsletters ist modern.',
          'type'        => 'range',
          'range'       => array(0, 1, 2, 3, 4, 5),
          'table_field' => 'rating_layout_modern'
        ),
        array(
          'label'       => 'Die Themen werden übersichtlich dargestellt.',
          'type'        => 'range',
          'range'       => array(0, 1, 2, 3, 4, 5),
          'table_field' => 'rating_layout_clear'
        )
     ),
    'use_in_report' => true
  ),
  // Question 13
  array(
    'title'  => 'Kennen Sie unsere Patientenbroschüren?',
    'type'   => 'binary',
    'values' => array(
        0 => 'Nein',
        1 => 'Ja'
    ),  
    'table_field' => 'patient_brochures',
    'use_in_report' => true  
  ),
  // Question 14
  // TODO
  array(
    'title'         => 'Wenn ja, welche kennen Sie?',
    'type'          => 'text',
    'table_field'   => 'know_our_patientbroschures',
    'use_in_report' => false  
  ),
  // Question 15
  array(
    'title'  => 'Welchen der folgenden Themen-Newsletter wünschen Sie sich?',
    'type'   => 'list',
    'values' => array(
      'Schwangerschaft',
      'Eltern und Kind',
      'Senioren',
      // array(
      //   'label' => 'weitere und zwar:', 
      //   'type' => 'text'
      // )
    ),  
    'table_field' => 'preferable_topics',
    'use_in_report' => true  
  ),
  // Question 16
  array(
    'title' => 'Haben Sie unsere Kundenzeitschrift viaWALA abonniert?',
    'type'  => 'binary',
    'values' => array(
      0 => 'Nein',
      1 => 'Ja'
    ),
    'table_field' => 'is_subscribed',
    'use_in_report' => true 
  ),
  // Question 17
//  array(
//    'title'  => 'Wie alt sind Sie?',
//    'type'   => 'single',
//    'values' => array(
//      'unter 25',
//      '25-34',
//      '35-44',
//      '45-54',
//      '55-67',
//      'über 67'
//    ),
//    'table_field' => 'age',
//    'use_in_report' => true
//  ),
  // Question 18
//  array(
//    'title'  => 'Sind Sie männlich oder weiblich?',
//    'type'   => 'single',
//    'values' => array(
//      'weiblich',
//      'männlich'
//    ),
//    'table_field' => 'sex',
//    'use_in_report' => true
//  ),
//  // Question 19
//  array(
//    'title' => 'Haben Sie Kinder?',
//    'type'  => 'binary',
//    'values' => array(
//      0 => 'Nein',
//      1 => 'Ja'
//    ),
//    'table_field' => 'have_childs',
//    'use_in_report' => true
//  ),
  // Additional fields
  array(
    'title'         => 'Name',
    'type'          => 'text',
    'table_field'   => 'name',
    'use_in_report' => false
  ),
  array(
    'title'         => 'Vorname',
    'type'          => 'text',
    'table_field'   => 'lastname',
    'use_in_report' => false
  ),
  array(
    'title'         => 'Straße und Hausnummer',
    'type'          => 'text',
    'table_field'   => 'street_and_house_nr',
    'use_in_report' => false
  ),
  array(
    'title'         => 'PLZ',
    'type'          => 'text',
    'table_field'   => 'zip',
    'use_in_report' => false
  ),
  array(
    'title'         => 'Ort',
    'type'          => 'text',
    'table_field'   => 'city',
    'use_in_report' => false
  ),
  array(
    'title'         => 'Ich möchte die kostenlose Kundenzeitschrift viaWALA abonnieren.',
    'type'          => 'signle',
    'table_field'   => 'subscribe_for_viawala_magazine',
    'use_in_report' => false
  ),
   array(
     'title'         => 'Vollständig gefüllt',
     'type'          => 'text',
     'table_field'   => 'full_complete',
     'use_in_report' => false
   ),
);
