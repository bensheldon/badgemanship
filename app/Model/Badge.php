<?php

class Badge extends AppModel {
  var $name = 'Badge';
  var $order = array("Badge.modified" => "DESC");
  var $actsAs = array('Containable');
  
  var $belongsTo =  array(
    'User' => array(            
      'className'    => 'User',            
      'foreignKey'   => 'user_id',
      'counterCache' => true,
    ),
    'Measure' =>array(
      'className'    => 'Measure',
      'foreignKey'   => 'measure_id',
      'counterCache' => true,
    ),
    'Project' =>array(
      'className'    => 'Project',
      'foreignKey'   => 'project_id',
      'counterCache' => true,
    ),
  );
  
  function beforeSave() {
    // Associate Badge[measure_id] and unset Badge[measure] 
    if (empty($this->data['Badge']['measure_id'])) {
      $measure = $this->Measure->saveMeasure($this->data['Badge']['measure'], $this->data['Badge']['quantity_goal']);
      $this->data['Badge']['measure_id'] = $measure['Measure']['id'];
      unset($this->data['Badge']['measure']); // the Measure's text isn't saved
    }
  
    return TRUE;
  }
}
