<?php
App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class TwitterAuthenticate extends BaseAuthenticate {

    public function authenticate(CakeRequest $request, CakeResponse $response) {
      debug($request); exit(99);
      $userModel = $this->settings['userModel'];
      list($plugin, $model) = pluginSplit($userModel);
  
      $fields = $this->settings['fields'];
      if (empty($request->data[$model])) {
        return false;
      }
      if (
        empty($request->data[$model][$fields['username']])
      ) {
        return false;
      }
      return $this->_findUser(
        $request->data[$model][$fields['username']],
        'EMPTY' // Nothing here
      );
    }
    
    // $password is unused
    protected function _findUser($username, $password) {
      $userModel = $this->settings['userModel'];
      list($plugin, $model) = pluginSplit($userModel);
      $fields = $this->settings['fields'];
  
      $conditions = array(
        $model . '.' . $fields['username'] => $username,
      );
      
      if (!empty($this->settings['scope'])) {
        $conditions = array_merge($conditions, $this->settings['scope']);
      }
      $result = ClassRegistry::init($userModel)->find('first', array(
        'conditions' => $conditions,
        'recursive' => 0
      ));
      if (empty($result) || empty($result[$model])) {
        return false;
      }
      return $result[$model];
    }

}