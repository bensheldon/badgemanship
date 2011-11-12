<?php

class Activity extends AppModel {
  var $name = 'Activity';
  
  var $order = array("Activity.created" => "DESC");
  
  var $actsAs = array('Containable');
  
  var $belongsTo =  array(
    'User' => array(            
      'className'    => 'User',            
      'foreignKey'   => 'user_id'
    ),
    'Measure' =>array(
      'className'    => 'Measure',
      'foreignKey'   => 'measure_id'
    )
  );

  function beforeSave() {
     //Add the User_id if not set
//    if (empty($this->data['Activity']['user_id'])) {
//      $this->data['Activity']['user_id'] =  $this->Auth->user('id');
//    }
     
    // Associate a Measure if not set
    if (empty($this->data['Activity']['measure_id'])) {
      App::uses('Model', 'Measure');
      $measure = $this->Measure->saveMeasure($this->data['Activity']['measure'], $this->data['Activity']['quantity']);
      $this->data['Activity']['measure_id'] = $measure['Measure']['id'];
    }
    return true;
  }
  
}
