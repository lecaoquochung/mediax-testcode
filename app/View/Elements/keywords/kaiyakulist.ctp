<div class="row">
	<div class="col-xs-12">
		<?php echo $this->Session->flash(); ?>
		<table class="table">
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
	        	<?php echo $this->Html->link($keyword['Keyword']['Keyword'], array('action' => 'view', $keyword['Keyword']['ID'])); ?>
				<?php echo ($keyword['Keyword']['Penalty'])? $this->Html->image('yellowcard.gif') : '';?>
				<br />
				<span class="kaiyaku"><?php echo isset($keyword['Keyword']['rankend'])? '(' .__('Keyword Cancel Date') .' ' .$keyword['Keyword']['rankend'] .')' : '';?></span>
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