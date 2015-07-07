<table class="table">
	<!-- role -->
	<tr>
		<th><?php echo $this -> Html -> tag('span', __('Admin Role')); ?></th>
		<td><?php echo $this -> Form -> input('role', array('label' => False, 'type' => 'select', 'options' => Configure::read('User.admin'))); ?></td>
	</tr>
	<!-- email -->
	<tr>
		<th><?php echo $this -> Html -> tag('span', __('Email')); ?></th>
		<td><?php echo $this -> Form -> input('email', array('label' => FALSE)); ?></td>
	</tr>
	<!-- name -->
	<tr>
		<th><?php echo $this -> Html -> tag('span', __('Name')); ?></th>
		<td><?php echo $this -> Form -> input('name', array('label' => FALSE)); ?></td>
	</tr>
	<!-- password -->
	<tr>
		<th><?php echo $this -> Html -> tag('span', __('Password')); ?></th>
		<td><?php echo $this -> Form -> input('password', array('label' => FALSE, 'type' => 'text')); ?></td>
	</tr>
</table>