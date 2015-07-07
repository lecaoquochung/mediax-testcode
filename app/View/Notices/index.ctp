<?php $this->assign('title',  __(ucfirst($this->params['action']) .' ' .ucfirst(Inflector::singularize($this->params['controller']))));?>
<div id="admin users">
	<?php echo $this -> element('navigation'); ?>
	<div class="main span10">
		<div class="box admin_statuses span12">
			<div class="navbar">
				<div class="navbar-inner">
					<h3 class="brand"><?php echo __(ucfirst($this->params['action']) .' ' .ucfirst(Inflector::singularize($this->params['controller']))); ?></h3>
				</div>
			</div>
			<div class="section">
				<?php echo $this -> Session -> flash(); ?>
				<!-- button -->
				<div class="common-button">
					<?php echo $this -> Html -> link(__('+'), array('action' => 'add'), array('class' => "btn btn-success")); ?>
				</div>
				<!-- table -->
				<table class="table tableX">
					<tr>
						<th class="tbl1"><?php echo $this -> Paginator -> sort('label'); ?></th>
						<th class="tbl2"><?php echo $this -> Paginator -> sort('created'); ?></th>
						<th class="tbl4"><?php echo $this -> Paginator -> sort('title'); ?></th>
						<th class="tbl1"><?php echo __('Status'); ?></th>
						<th class="actions tbl2"><?php echo __('Actions'); ?></th>
					</tr>
					<?php foreach ($notices as $notice): ?>
					<tr>
						<td><?php echo $this->Layout->notice_label($notice['Notice']['label']) ?>&nbsp;</td>
						<td><?php echo $notice['Notice']['created'] ?>&nbsp;</td>
						<td><?php echo h($notice['Notice']['title']); ?>&nbsp;</td>
						<td><?php echo $this->Layout->compare_today($notice['Notice']['history'])!=0?'<span class="label label-important">未公開</span>':'<span class="label label-default">公開済</span>' ?>&nbsp;</td>
						<td class="actions">
							<div class="btn-group">
								<i class="icon-edit">
									<?php echo $this->Html->link(__('Edit'), array( 'action' => 'edit', $notice['Notice']['id'])); ?>
								</i>
							</div>
							<div class="btn-warning" style="float: right;">
								<i class="icon-remove">
									<?php echo $this->Form->postLink('', array( 'action' => 'delete', $notice['Notice']['id']), array('class' => ''), __('【%s】を削除しますか？', $notice['Notice']['title'])); ?>
								</i>
							</div>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<p>
					<?php
						#echo $this -> Paginator -> counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
					?>
				</p>
				<div class="paging">
					<?php
						echo $this -> Paginator -> prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
						echo $this -> Paginator -> numbers(array('separator' => ''));
						echo $this -> Paginator -> next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
					?>
				</div>
			</div>
		</div>	
	</div>
</div>