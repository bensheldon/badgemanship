<?php echo $this->element('loginout'); ?>

<h1>Site Users</h1>
<table>
	<tr>
		<th>Image</th>
		<th>Id</th>
		<th>Twitter ID</th>
		<th>Screen Name</th>
		<th>Created</th>
	</tr>

	<!-- Here is where we loop through our $posts array, printing out post info -->

	<?php foreach ($users as $user): ?>
	<tr>
		<td><img src="<?php echo $user['User']['image'] ?>" alt="<?php echo $user['User']['username'] ?>"</td>
		<td><?php echo $user['User']['id']; ?></td>
		<td><?php echo $user['User']['twitter_id']; ?></td>
		<td>
			<?php echo $this->Html->link($user['User']['username'], 
array('controller' => 'users', 'action' => 'view', $user['User']['id'], $user['User']['username'])); ?>
		</td>
		<td><?php echo $user['User']['created']; ?></td>
	</tr>
	<?php endforeach; ?>

</table>