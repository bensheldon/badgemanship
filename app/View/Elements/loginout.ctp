<ul>
<?php if(!$this->Session->check('Auth.User')) : ?>
		<li><?php echo $this->Html->link('Login with Twitter', array('controller' => 'users', 'action' => 'login')) ?></li> 
<?php else : ?>
   <li>Hi, <?php echo $this->Session->read('Auth.User.screen_name') ."&nbsp;(";
   echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')) ?>)</li>
<?php endif; ?>
</ul>