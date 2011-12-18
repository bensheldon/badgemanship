<header>
  <div class="container">
    <div id="header-content">
      <h1><a href="/">Badgemanship</a></h1>
      <a href="/activities/add" id="add-activity">+</a>
      <ul id="primary-nav">
        <li data-dropdown="dropdown">
          <a href="#" class="dropdown-toggle">
           <?php if ($this->Session->check('Auth.User')) : ?>
             <?php echo $this->Session->Read('Auth.User.username') ?>
           <?php else : ?>
             Navigation
           <?php endif; ?>
          </a>
          <ul class="dropdown-menu">
            <?php
              /* Logged in */ 
              if ($this->Session->check('Auth.User')) : 
                echo '<li>' . $this->Html->link('Your Activity', array('controller' => 'activities', 'action' => 'index')) . '</li>';
                echo '<li>' . $this->Html->link('Your Badges', array('controller' => 'badges', 'action' => 'index')) . '</li>';
                echo '<li>' . $this->Html->link('Your Data', array('controller' => 'activities', 'action' => 'sum', $this->Session->Read('Auth.User.username'))) . '</li>';
                echo '<li>' . $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')) . '</li>'; 
              else :
                echo '<li>' . $this->Html->link('Login/Register', array('controller' => 'users', 'action' => 'login')) . '</li>';
              endif;  
            ?>
          </ul>
        </li>
      </ul> <!-- /#navigation -->
    </div> <!-- end of /#header-content -->
  </div> <!-- end of  /.container -->
</header>
