<div class="servers view">
<h2><?php echo __('Server'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($server['Server']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($server['Server']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ip'); ?></dt>
		<dd>
			<?php echo h($server['Server']['ip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Api'); ?></dt>
		<dd>
			<?php echo h($server['Server']['api']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Memo'); ?></dt>
		<dd>
			<?php echo h($server['Server']['memo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($server['Server']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($server['Server']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Server'), array('action' => 'edit', $server['Server']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Server'), array('action' => 'delete', $server['Server']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $server['Server']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Servers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Server'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Keywords'); ?></h3>
	<?php if (!empty($server['Keyword'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('ID'); ?></th>
		<th><?php echo __('UserID'); ?></th>
		<th><?php echo __('Server Id'); ?></th>
		<th><?php echo __('Keyword'); ?></th>
		<th><?php echo __('Url'); ?></th>
		<th><?php echo __('Engine'); ?></th>
		<th><?php echo __('G Local'); ?></th>
		<th><?php echo __('Cost'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Limit Price'); ?></th>
		<th><?php echo __('Limit Price Check'); ?></th>
		<th><?php echo __('Limit Price Group'); ?></th>
		<th><?php echo __('Upday'); ?></th>
		<th><?php echo __('Goukeifee'); ?></th>
		<th><?php echo __('Sengoukeifee'); ?></th>
		<th><?php echo __('$sensengoukeifee'); ?></th>
		<th><?php echo __('Enabled'); ?></th>
		<th><?php echo __('Strict'); ?></th>
		<th><?php echo __('Extra'); ?></th>
		<th><?php echo __('Start'); ?></th>
		<th><?php echo __('Rankstart'); ?></th>
		<th><?php echo __('Rankend'); ?></th>
		<th><?php echo __('Kaiyaku Reason'); ?></th>
		<th><?php echo __('Middle'); ?></th>
		<th><?php echo __('Middleinfo'); ?></th>
		<th><?php echo __('Seika'); ?></th>
		<th><?php echo __('Nocontract'); ?></th>
		<th><?php echo __('Csv Type'); ?></th>
		<th><?php echo __('Penalty'); ?></th>
		<th><?php echo __('Service'); ?></th>
		<th><?php echo __('Mobile'); ?></th>
		<th><?php echo __('C Logic'); ?></th>
		<th><?php echo __('Sales'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Updated'); ?></th>
		<th><?php echo __('Sitename'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($server['Keyword'] as $keyword): ?>
		<tr>
			<td><?php echo $keyword['ID']; ?></td>
			<td><?php echo $keyword['UserID']; ?></td>
			<td><?php echo $keyword['server_id']; ?></td>
			<td><?php echo $keyword['Keyword']; ?></td>
			<td><?php echo $keyword['Url']; ?></td>
			<td><?php echo $keyword['Engine']; ?></td>
			<td><?php echo $keyword['g_local']; ?></td>
			<td><?php echo $keyword['cost']; ?></td>
			<td><?php echo $keyword['Price']; ?></td>
			<td><?php echo $keyword['limit_price']; ?></td>
			<td><?php echo $keyword['limit_price_check']; ?></td>
			<td><?php echo $keyword['limit_price_group']; ?></td>
			<td><?php echo $keyword['upday']; ?></td>
			<td><?php echo $keyword['goukeifee']; ?></td>
			<td><?php echo $keyword['sengoukeifee']; ?></td>
			<td><?php echo $keyword['$sensengoukeifee']; ?></td>
			<td><?php echo $keyword['Enabled']; ?></td>
			<td><?php echo $keyword['Strict']; ?></td>
			<td><?php echo $keyword['Extra']; ?></td>
			<td><?php echo $keyword['start']; ?></td>
			<td><?php echo $keyword['rankstart']; ?></td>
			<td><?php echo $keyword['rankend']; ?></td>
			<td><?php echo $keyword['kaiyaku_reason']; ?></td>
			<td><?php echo $keyword['middle']; ?></td>
			<td><?php echo $keyword['middleinfo']; ?></td>
			<td><?php echo $keyword['seika']; ?></td>
			<td><?php echo $keyword['nocontract']; ?></td>
			<td><?php echo $keyword['csv_type']; ?></td>
			<td><?php echo $keyword['penalty']; ?></td>
			<td><?php echo $keyword['service']; ?></td>
			<td><?php echo $keyword['mobile']; ?></td>
			<td><?php echo $keyword['c_logic']; ?></td>
			<td><?php echo $keyword['sales']; ?></td>
			<td><?php echo $keyword['created']; ?></td>
			<td><?php echo $keyword['updated']; ?></td>
			<td><?php echo $keyword['sitename']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'keywords', 'action' => 'view', $keyword['ID'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'keywords', 'action' => 'edit', $keyword['ID'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'keywords', 'action' => 'delete', $keyword['ID']), array('confirm' => __('Are you sure you want to delete # %s?', $keyword['ID']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
