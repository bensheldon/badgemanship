<nav id="primary-nav">
  <ul>
  <?php
    /* Logged in */ 
    if ($this->Session->check('Auth.User')) : 
      echo '<li>' . $this->Html->link($this->Session->Read('Auth.User.username') . "'s activities", array('controller' => 'activities', 'action' => 'index')) . '</li>';
      echo '<li>' . $this->Html->link($this->Session->Read('Auth.User.username') . "'s data", array('controller' => 'activities', 'action' => 'sum')) . '</li>';
      echo '<li>' . $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')) . '</li>'; 
    else :
      echo '<li>' . $this->Html->link('Login/Register', array('controller' => 'users', 'action' => 'login')) . '</li>';
    endif;  
  ?>
  </ul>
</nav>