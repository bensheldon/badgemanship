<?php

class AwardedBadge extends AppModel {
  var $name = 'AwardedBadge';
  var $order = array("AwardedBadge.awarded" => "DESC");
  var $actsAs = array('Containable');
  
  var $belongsTo =  array(
    'Badge' => array(            
      'className'    => 'Badge',            
      'foreignKey'   => 'badge_id',
      'counterCache' => true,
    ),
    'User' => array(            
      'className'    => 'User',            
      'foreignKey'   => 'user_id',
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
