<div class="extras view">
<h2><?php  echo __('Extra'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($extra['Extra']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keyword'); ?></dt>
		<dd>
			<?php echo $this->Html->link($extra['Keyword']['ID'], array('controller' => 'keywords', 'action' => 'view', $extra['Keyword']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ExtraType'); ?></dt>
		<dd>
			<?php echo h($extra['Extra']['ExtraType']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($extra['Extra']['Price']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Extra'), array('action' => 'edit', $extra['Extra']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Extra'), array('action' => 'delete', $extra['Extra']['ID']), null, __('Are you sure you want to delete # %s?', $extra['Extra']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Extras'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Extra'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>
