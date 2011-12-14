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
    'Project' => array(            
      'className'    => 'Project',            
      'foreignKey'   => 'project_id',
    ),
  );
  
}
