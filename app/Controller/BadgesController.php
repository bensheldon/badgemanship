<?php
class BadgesController extends AppController {
	var $name = 'Badges';
	var $helpers = array('Html', 'Html', 'Form', 'Ajax', 'Markdown', 'Time'); 
	var $components = array('RequestHandler');
	var $actsAs = array('Containable');
	var $uses = array('Badge', 'User', 'Activity', 'Project', 'Measure');


	function index($username = '') {
	  // if logged in show the user's
	  // otherwise show all
	  if ($user_id = $this->Auth->user('id')) {
	    
	    // bind the User's Awarded badge to the model, so it's joined on Find()
	    $this->Badge->bindModel(
	      array('hasOne' => array(
	        'AwardedBadge' => array(
	          'className' => 'AwardedBadge',
	          'foreignKey' => 'badge_id',
	          'conditions' => array('AwardedBadge.user_id' => $user_id), 
	        ),
	      )
	    ));
	    
	    //Bind measure's sum (User, then Project) so we know progress
	    $this->Badge->bindModel(
	      array('hasOne' => array(
	        'MeasuresSumUser' => array(
	          'className' => 'MeasuresSum',
	          'foreignKey' => FALSE, 
	          'conditions' => array(
	            'MeasuresSumUser.parent_type' => 'user',
	            'MeasuresSumUser.parent_id' => $user_id,
	            'MeasuresSumUser.measure_id = Badge.measure_id', 
	        ),
	      )
	    )));
	    $this->Badge->bindModel(
	      array('hasOne' => array(
	        'MeasuresSumProject' => array(
	          'className' => 'MeasuresSum',
	          'foreignKey' => FALSE, 
	          'conditions' => array(
	            'MeasuresSumProject.parent_type' => 'project',
	            'MeasuresSumProject.parent_id = Badge.project_id',
	            'MeasuresSumProject.measure_id = Badge.measure_id', 
	        ),
	      )
	    ))); 
	     
	  
	    $this->set('badges', $this->Badge->find(
	      'all', array(
	        'conditions' => array(
            'OR' => array(
              'Badge.user_id' => $user_id,
              'AwardedBadge.user_id' => $user_id,
            ),
          ),
          'order' => array(
            'AwardedBadge.created DESC'
          )
	    )));
	  }
	  else {
	  	$this->set('badges', $this->Badge->find('all'));
	  }
	}
	
	
	function progress() {
	  if ($user_id = $this->Auth->user('id')) {
	    $this->set('badges', $this->Badge->findUserProgress($user_id));
	    $this->render('index');
	  }
	}
	
	function add() {
	  $this->set('page_title', 'Add Badge');
	  $user_id = $this->Auth->user('id');
	
	  // Process POST
	  if ( (!empty($this->data)) && ($user_id) ) {
	    $this->Badge->create();
	    $this->Badge->set(array(
	        'user_id' => $user_id,
	        'title' => $this->data['Badge']['title'],
	        'description' => $this->data['Badge']['description'],
	        'measure' => $this->data['Badge']['measure'], //this is converted before save to measure_id
	        'quantity_goal' => $this->data['Badge']['quantity_goal'],    
	    ));
	    
	    if( isset($this->data['Badge']['project_id']) 
	          && ($this->data['Badge']['project_id'] != 0) ) {
	      $this->Badge->set('project_id', $this->data['Badge']['project_id']);
	    }
	    
	    if ($this->Badge->save()) {
	    	$this->Session->setFlash('Your badge has been saved.');
	    	$this->redirect(array('action' => 'index'));
	    }
	  }
	  
	  // Set the Projects
	  $this->set('projects', $this->Project->find(
	    'all', array(
	      'conditions' => array(
	        'User.id' => $user_id,
	      )
	    )
	  ));
	 
	   // render 
	}

	function delete($id) {
		$this->Badge->delete($id);
		$this->Session->setFlash('The badge with id: '.$id.' has been deleted.');
		$this->redirect(array('action'=>'index'));
	}
	
}
?>