<?php
class ProjectsController extends AppController {
	var $name = 'Projects';
	var $helpers = array('Html', 'Html', 'Form', 'Ajax', 'Markdown', 'Time'); 
	var $components = array('RequestHandler');
	var $actsAs = array('Containable');
	var $uses = array('Project', 'Activity', 'User');


	function index() {
	  // if logged in show the user's
	  // otherwise show all
	  if ($user_id = $this->Auth->user('id')) {
	    $this->set('projects', $this->Project->find(
	      'all',
	      array('conditions' => array('User.id' => $user_id))
	    ));
	  }
	  else {
	  	$this->set('projects', $this->Project->find('all'));
	  }
	
	}

	function view($id) {
		$this->Project->id = $id;
		$project = $this->Project->read();
		$this->set('project', $project);
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

	function add() {
	  if ( ($user_id = $this->Auth->user('id')) && (!empty($this->data)) ) {
	    $this->Project->create();
	    $this->Project->set(array(
	        'user_id' => $user_id,
	        'title' => $this->data['Project']['title'],
	        'description' => $this->data['Project']['description'],
	    ));
	    
	    if ($this->Project->save()) {
	    	$this->Session->setFlash('Your project has been saved.');
	    	$this->redirect(array('action' => 'index'));
	    }
	  
	  }
	  
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