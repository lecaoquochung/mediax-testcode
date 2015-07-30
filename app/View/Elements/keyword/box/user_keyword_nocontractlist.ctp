<div class="box admin_statuses span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Nocontract Keyword');?></h3>
		</div>
	</div>    
	<div class="section">
		<?php echo $this->Session->flash(); ?>
		<div class="description-box">
			<div class="new-line"><strong>マーク説明</strong></div>
			<i class="icon-edit"></i>
			<?php echo __('Keywork information edit'); ?>
			<br />
			<i class="icon-plus"></i>
			<?php echo __('Keywork add more details'); ?>
			<br />
			<i class="icon-ok"></i>
			<?php echo __('Set Keyword to contract list'); ?>
		</div>
		<table class="table tableX">
		<tr>
			<th class="tbl1"><?php echo __('ID'); ?></th>
			<th class="tbl5"><?php echo __('Company'); ?></th>
			<th class="tbl6"><?php echo __('Keyword') .'/' .__('Url'); ?></th>
			<th class="actions tbl3"><?php echo __('Actions'); ?></th>
		</tr>
		<?php
		foreach ($keywords as $keyword): ?>
		<tr>
			<td><?php echo h($keyword['Keyword']['ID']); ?>&nbsp;</td>
			<td>
				<?php echo $this->Html->link($keyword['User']['company'], array('controller' => 'users', 'action' => 'view', $keyword['User']['id'])); ?>
			</td>
			<td>
	        	<span class="nocontract"><?php echo $this->Html->link($keyword['Keyword']['Keyword'], array('action' => 'view', $keyword['Keyword']['ID'])); ?></span>
				<?php echo ($keyword['Keyword']['Penalty'])? $this->Html->image('yellowcard.gif') : '';?>
	        	<br />
	        	<?php echo $this->Html->link($keyword['Keyword']['Url'], $keyword['Keyword']['Url'], array('target'=>'_blank')); ?>
	        </td>
			<td class="actions">
				<div class="btn-group">
					<i class="icon-edit">
               			<?php echo $this->Html->link(__('Edit'), array('controller' => 'keywords', 'action' => 'edit', $keyword['Keyword']['ID'])); ?>
                	</i>
				</div>
				<div class="btn-group">
					<i class="icon-plus">
               			<?php echo $this->Html->link(__('Extra'), array('controller' => 'extras', 'action' => 'add', $keyword['Keyword']['ID'])); ?>
                	</i>
				</div>
				<div class="btn-group">
					<i class="icon-ok">
						<?php echo $this->Html->link(__('Set Nocontract'), array('controller' => 'keywords', 'action' => 'nocontract', $keyword['Keyword']['ID'],($keyword['Keyword']['nocontract']==1?0:1))); ?>
					</i>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
		</table>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('.loadRank').click(function(){
        var keyID = $(this).attr('KeyID');
        $('.loading').show();
        $.ajax({
            url:'<?php echo $this->webroot ?>keywords/load_rank',
            data:{keyID:keyID},
            type:'POST',
            success:function(data){
                $('.loading').hide();
                window.location.reload(true);
            }
        })
    })
})
</script>