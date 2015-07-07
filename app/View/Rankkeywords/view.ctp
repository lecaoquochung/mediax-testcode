<div class="rankkeywords view">
<h2><?php  echo __('Rankkeyword'); ?></h2>
	<dl>
		<dt><?php echo __('ID'); ?></dt>
		<dd>
			<?php echo h($rankkeyword['Rankkeyword']['ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keyword'); ?></dt>
		<dd>
			<?php echo h($rankkeyword['Rankkeyword']['Keyword']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Google Jp'); ?></dt>
		<dd>
			<?php echo h($rankkeyword['Rankkeyword']['google_jp']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Yahoo Jp'); ?></dt>
		<dd>
			<?php echo h($rankkeyword['Rankkeyword']['yahoo_jp']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Google En'); ?></dt>
		<dd>
			<?php echo h($rankkeyword['Rankkeyword']['google_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Yahoo En'); ?></dt>
		<dd>
			<?php echo h($rankkeyword['Rankkeyword']['yahoo_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bing'); ?></dt>
		<dd>
			<?php echo h($rankkeyword['Rankkeyword']['bing']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Rankkeyword'), array('action' => 'edit', $rankkeyword['Rankkeyword']['ID'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Rankkeyword'), array('action' => 'delete', $rankkeyword['Rankkeyword']['ID']), null, __('Are you sure you want to delete # %s?', $rankkeyword['Rankkeyword']['ID'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Rankkeywords'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rankkeyword'), array('action' => 'add')); ?> </li>
	</ul>
</div>
