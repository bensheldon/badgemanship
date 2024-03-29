<?php

class User extends AppModel {
  var $name = 'User';
  var $hasMany =  array(
    'Activity' => array(            
      'className'    => 'Activity',            
      'foreignKey'    => 'user_id'
    ),
    'MeasuresSum' => array(            
      'className'   => 'MeasuresSum',            
      'foreignKey'  => 'parent_id',
      'conditions'  => array('MeasuresSum.parent_type' => 'user'),
    ),
  );  

  // Don't Hash Passwords because they aren't being used
  // http://stackoverflow.com/questions/1894203/turn-of-cakephp-auth-password-hashing
  function hashPasswords($data) {
       return $data;
  }
}