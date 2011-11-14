<?php
// http://code.42dh.com/oauth/
App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'oauth_consumer.php'));

class UsersController extends AppController {
  var $helpers = array ('Html','Form');
  var $name = 'Users';
  
  function beforeFilter() {
    parent::beforeFilter();

    // Does not require being logged in
    $this->Auth->allow('/', 'twitter_callback', 'index', 'view');    
  }
      
  function index() {
    $this->set('users', $this->User->find('all'));    
  }
  
  function view($id = null) {  
    if ($id) {
      $this->User->id = $id;
      if (isset($this->params['requested'])) {
        return $this->User->read();
      } else {
        $this->set('user', $this->User->read());
        $this->render('view');
      }
    }
    else {
      $this->index();
      $this->render('index');
    }
  }
  
  public function login() {
    $twitter_callback = Configure::read('Twitter.callback_domain') 
                        . '/users/twitter_callback';
    
    // Get a request token from twitter
    $consumer = $this->createConsumer();
    $requestToken = $consumer->getRequestToken('http://twitter.com/oauth/request_token', $twitter_callback);
    $this->Session->write('twitter_request_token', $requestToken);
    // Connect to Authenticate, not Authorize
    $this->redirect('http://twitter.com/oauth/authenticate?oauth_token=' . $requestToken->key);
  }
  
  public function twitter_callback() {
    $requestToken = $this->Session->read('twitter_request_token');
    $consumer = $this->createConsumer();
    $accessToken = $consumer->getAccessToken('http://twitter.com/oauth/access_token', $requestToken);
    if ($accessToken) {
      $accessTokenKey = $accessToken->key;
      $accessTokenSecret = $accessToken->secret;
      
      //get the User Data
      $user = $consumer->get($accessTokenKey, $accessTokenSecret, 'http://api.twitter.com/1/account/verify_credentials.json');  
      if ($user) {
        $user = json_decode($user, TRUE); // decode JSON into array
        $user_data = array(
          'twitter_id' => $user['id'],
          'screen_name' => $user['screen_name'],
          'password' => $user['screen_name'], // this is the same as name, but we need to verify it.
          'access_token' => $accessTokenKey,
          'access_token_secret' =>  $accessTokenSecret,
          'image' => $user['profile_image_url'],
          'location' => $user['location'] ? $user['location'] : '',
          'name' => $user['name'] ? $user['name'] : '',
          'description' => $user['description'] ? $user['description'] : '',
        );
          
        // Check if there is an existing User
        $existing_user = $this->User->find('first', array('conditions' => array('User.twitter_id' => $user_data['twitter_id'])));
        if ($existing_user) {
          $user_data['id'] = $existing_user['User']['id'];
        }
        $user = $this->User->save($user_data);
        
        $this->Session->destroy();
        // Log the user in
        if ($this->Auth->login($user_data)) {
          $this->Session->setFlash('You, <strong>' . $user['User']['screen_name'] ."</strong>, have been successfully logged in via Twitter.");
          $this->redirect(array('controller' => 'Users', 'action' => 'index'));
        }
        else {
          //$this->Session->setFlash('We were not able to log you in.');
        }
      }
    }
    
    debug($this->Auth->user());

    //$this->redirect(array('action' => 'index'));
  }

  function logout() {
    $this->Session->setFlash('You have been logged out');
    $this->redirect($this->Auth->logout());
  } 
  
  function rebuild() {
    $this->loadModel('Activity');
    $user_id = $this->Auth->user('id');
    
    $this->Activity->rebuildUser($user_id);
    
    $this->Session->setFlash('Your measure sums have been rebuilt.');
    $this->redirect(array('controller' => 'activities', 'action' => 'index'));
  }
}