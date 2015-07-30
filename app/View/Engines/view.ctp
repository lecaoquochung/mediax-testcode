<div class="engines view">
<h2><?php  echo __('Engine'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($engine['Engine']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($engine['Engine']['Name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ShowName'); ?></dt>
		<dd>
			<?php echo h($engine['Engine']['ShowName']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short'); ?></dt>
		<dd>
			<?php echo h($engine['Engine']['Short']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($engine['Engine']['Code']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Engine'), array('action' => 'edit', $engine['Engine']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Engine'), array('action' => 'delete', $engine['Engine']['ID']), null, __('Are you sure you want to delete # %s?', $engine['Engine']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Engines'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Engine'), array('action' => 'add')); ?> </li>
	</ul>
</div>
