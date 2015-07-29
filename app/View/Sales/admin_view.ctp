<!--/*/*<div class="sales view">
<h2><?php  echo __('Sale'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sale['User']['name'], array('controller' => 'users', 'action' => 'view', $sale['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Target Month'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['target_month']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Target Sale'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['target_sale']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
-->