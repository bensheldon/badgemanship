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
  );  
  
}