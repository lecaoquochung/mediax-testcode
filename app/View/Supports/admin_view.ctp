<div class="supports view">
<h2><?php  echo __('Support'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($support['Support']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Jobhunter'); ?></dt>
		<dd>
			<?php echo $this->Html->link($support['Jobhunter']['name'], array('controller' => 'jobhunters', 'action' => 'view', $support['Jobhunter']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($support['Support']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($support['Support']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo h($support['Support']['note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Action'); ?></dt>
		<dd>
			<?php echo h($support['Support']['action']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('View'); ?></dt>
		<dd>
			<?php echo h($support['Support']['view']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($support['Support']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($support['Support']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Support'), array('action' => 'edit', $support['Support']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Support'), array('action' => 'delete', $support['Support']['id']), null, __('Are you sure you want to delete # %s?', $support['Support']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Supports'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Support'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Jobhunters'), array('controller' => 'jobhunters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Jobhunter'), array('controller' => 'jobhunters', 'action' => 'add')); ?> </li>
	</ul>
</div>
