<?php
// For Twitter Oauth
// http://code.42dh.com/oauth/
App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'oauth_consumer.php'));

class AppController extends Controller {
  var $components = array('Auth', 'Session');
  var $helpers = array('Session', 'Html', 'Ajax', 'Markdown', 'Time'); 

  function beforeFilter() { 
    Security::setHash('md5');
    
    // Pass settings in
    $this->Auth->authenticate = array(
      'Twitter' => array('userModel' => 'Users.User'),
    );
    $this->Auth->allow(array('index', 'view'));
    $this->Auth->autoRedirect = false;
    // Don't automatically push to login page
    
    $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'plugin' => null); 
    //$this->Auth->loginRedirect = array('controller' => 'dashboard', 'action' => 'index');
    $this->Auth->loginError = 'No username and password was found with that combination.';
    $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'index');
    $this->Auth->user(); // BUG ?! Necessary to load the User data from session, otherwise it appears that you've never logged in
    
  }
  
  function createConsumer() {
    return new OAuth_Consumer(Configure::read('Twitter.consumer_key'), Configure::read('Twitter.consumer_secret'));
  }
} 
?>