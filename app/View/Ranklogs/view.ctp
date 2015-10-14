<div class="ranklogs view">
<h2><?php echo __('Ranklog'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ranklog['Ranklog']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keyword'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ranklog['Keyword']['ID'], array('controller' => 'keywords', 'action' => 'view', $ranklog['Keyword']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Engine'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ranklog['Engine']['ID'], array('controller' => 'engines', 'action' => 'view', $ranklog['Engine']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keyword'); ?></dt>
		<dd>
			<?php echo h($ranklog['Ranklog']['keyword']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($ranklog['Ranklog']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rank'); ?></dt>
		<dd>
			<?php echo h($ranklog['Ranklog']['rank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rankdate'); ?></dt>
		<dd>
			<?php echo h($ranklog['Ranklog']['rankdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($ranklog['Ranklog']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($ranklog['Ranklog']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ranklog'), array('action' => 'edit', $ranklog['Ranklog']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ranklog'), array('action' => 'delete', $ranklog['Ranklog']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $ranklog['Ranklog']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Ranklogs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ranklog'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Engines'), array('controller' => 'engines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Engine'), array('controller' => 'engines', 'action' => 'add')); ?> </li>
	</ul>
</div>
