<nav id="primary-nav">
  <?php
    /* Logged in */ 
    if ($this->Session->check('Auth.User')) : 
      echo $this->Html->link($this->Session->Read('Auth.User.screen_name') . "'s Activities", array('controller' => 'activities', 'action' => 'index'));
      echo $this->Html->link($this->Session->Read('Auth.User.screen_name') . "'s Data", array('controller' => 'activities', 'action' => 'sum'));
      echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); 
    else :
      echo $this->Html->link('Login/Register', array('controller' => 'users', 'action' => 'login'));
    
    endif;  
  ?>
</nav>