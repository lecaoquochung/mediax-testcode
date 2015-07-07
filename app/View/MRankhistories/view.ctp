<div class="mRankhistories view">
<h2><?php echo __('M Rankhistory'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mRankhistory['MRankhistory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keyword'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mRankhistory['Keyword']['ID'], array('controller' => 'keywords', 'action' => 'view', $mRankhistory['Keyword']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Engine'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mRankhistory['Engine']['ID'], array('controller' => 'engines', 'action' => 'view', $mRankhistory['Engine']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keyword'); ?></dt>
		<dd>
			<?php echo h($mRankhistory['MRankhistory']['keyword']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($mRankhistory['MRankhistory']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rank'); ?></dt>
		<dd>
			<?php echo h($mRankhistory['MRankhistory']['rank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rankdate'); ?></dt>
		<dd>
			<?php echo h($mRankhistory['MRankhistory']['rankdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($mRankhistory['MRankhistory']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($mRankhistory['MRankhistory']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit M Rankhistory'), array('action' => 'edit', $mRankhistory['MRankhistory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete M Rankhistory'), array('action' => 'delete', $mRankhistory['MRankhistory']['id']), null, __('Are you sure you want to delete # %s?', $mRankhistory['MRankhistory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List M Rankhistories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New M Rankhistory'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Engines'), array('controller' => 'engines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Engine'), array('controller' => 'engines', 'action' => 'add')); ?> </li>
	</ul>
</div>
