<?php
class ActivitiesController extends AppController {
	var $name = 'Activities';
	var $helpers = array('Html', 'Html', 'Form', 'Ajax', 'Markdown', 'Time'); 
	var $components = array('RequestHandler');
	var $actsAs = array('Containable');
	var $uses = array('Activity', 'User', 'Project', 'MeasuresSum');


	function index() {
	  // if logged in show the user's
	  // otherwise show all
	  if ($user_id = $this->Auth->user('id')) {
	    $this->set('activities', $this->Activity->find(
	      'all',
	      array('conditions' => array('User.id' => $user_id))
	    ));
	  }
	  else {
	  	$this->set('activities', $this->Activity->find('all'));
	  }
	
	}

	function view($id) {
		$this->Activity->id = $id;
		$activity = $this->Activity->read();
		$this->set('activity', $activity);
	}
	
	function user($username) {
  	$this->Activity->id = $id;
  	$activity = $this->Activity->read();
  	$this->set('activity', $activity);
	}

	function delete($id) {
		$this->Comment->delete($id);
		$this->Session->setFlash('The comment with id: '.$id.' has been deleted.');
		$this->redirect(array('action'=>'index'));
	}
	
	function sum($username) {
	  $user_id = $this->Auth->user('id');
	  
	  $measures_sum = $this->MeasuresSum->find('all', 
	    array(
	      'conditions' => array(
	      	  'MeasuresSum.parent_type' => 'user',
	          'MeasuresSum.parent_id' => $user_id,
	      ),
	      'contain' => array('Measure'),
	    )
	  );
	  
	  $this->set('measures', $measures_sum);
	}

	function add() {
	  $this->set('page_title', 'Add Activity');
	  $user_id = $this->Auth->user('id');
	
	  // Process POST
	  if ( (!empty($this->data)) && ($user_id) ) {
	    $this->Activity->create();
	    $this->Activity->set(array(
	        'user_id' => $user_id,
	        'description' => $this->data['Activity']['description'],
	        'quantity' => $this->data['Activity']['quantity'],
	        'measure' => $this->data['Activity']['measure'],
	    ));
	    
	    if( isset($this->data['Activity']['project_id']) 
	          && ($this->data['Activity']['project_id'] != 0) ) {
	      $this->Activity->set('project_id', $this->data['Activity']['project_id']);
	    }
	    
	    if ($activity = $this->Activity->save()) {
	      $message = 'Your activity has been saved.';
	      
	      //Any badges awarded?
	      if ( (isset($activity['AwardedBadge'])) 
	            && ($badges_count = count($activity['AwardedBadge'])) ){
	        $message .= ' You earned ' . ($badges_count == 1 ? 'one badge': $badges_count . ' badges');
	      }
	      
	      $this->Session->setFlash($message);
	    	$this->redirect(array('action' => 'index'));
	    }
	  }
	  
	  // Set the Projects
	  $this->set('projects', $this->Project->find(
	    'all', array(
	      'conditions' => array(
	        'Project.user_id' => $user_id,
	      ),
	      'recursive' => -1,
	    )
	  ));
	 
	   // render 
	}

	function edit($id = null) {
		$this->Comment->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Comment->read();
		} else {
			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash('Your comment has been updated.');
				$this->redirect(array('action' => 'index'));
			}
		}
	}
}
?>