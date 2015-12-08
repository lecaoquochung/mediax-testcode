<?php global $extra_type;?>
<div class="row">
	<div class="col-md-12">
		<?php echo $this->Session->flash(); ?>
        <table cellpadding="0" cellspacing="0" class="table tableX">
            <tr>
                <th class="tbl9"><?php echo __('ExtraType'); ?></th>
                <th th class="tbl2"><?php echo __('Price'); ?></th>
                <th th class="tbl2"><?php echo __('Actions'); ?></th>
            </tr>
            <?php if(isset($keyword['Extra']) && count($keyword['Extra'])>0): ?>
            <?php foreach ($keyword['Extra'] as $extra): ?>
            <tr>
                <td><?php echo h($extra['ExtraType']) .'位保証'; ?>&nbsp;</td>
                <td><?php echo h($extra['Price']); ?>&nbsp;</td>
                <td>
                    <div class="icon">
                        <span class="del">
                                <?php echo $this->Html->link(__('Delete'), 'javascript:void(0)',array('class'=>'delete_extra','extra_id'=>$extra['ID'])); ?>
                        </span>
                    </div>                        
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif ?>
        </table>
		
        <?php echo $this->Form->create('Extra'); ?>
            <legend><?php echo __('Add Extra'); ?></legend>
            <?php echo $this->Form->input('KeyID', array('value' => $keyword['Keyword']['ID'], 'type' => 'hidden')); ?>
			<table class="table tableX">
				<tr>
	                <th>
						<?php echo $this->Form->input('ExtraType', array('label' => FALSE, 'type'=>'text', 'before' => '保証順位<span class="text-error">*</span>&nbsp;')); ?>
	                </th>
	                <td>
						<?php echo $this->Form->input('Price', array('label' => FALSE, 'type'=>'text', 'before' => '価格<span class="text-error">*</span>&nbsp;')); ?>
	                </td>
				</tr>
			</table>
	        <?php echo $this->Form->button(__('Submit'), array('class'=>'btn btn-info', 'div'=>FALSE)); ?>
	        <?php echo $this->Html->link(__('Company Detail'), array('controller' => 'users' , 'action' => 'view', $keyword['User']['id']), array('class' => "btn")); ?>
	        <?php echo $this->Html->link(__('キーワード詳細ページで確認'), array('controller' => 'keywords', 'action' => 'view',$keyword['Keyword']['ID']), array('class' => 'btn btn-warning')); ?>
		<?php echo $this->Form->end(); ?>	        
	</div>
</div>	

<script type="text/javascript">
$(document).ready(function(){
    $('.delete_extra').click(function(){
        var obj = $(this);
        var extraID = $(this).attr('extra_id');
        $(this).parent().addClass('loading');
        $.ajax({
            url:'<?php echo $this->webroot ?>extras/delete/' +extraID,
            type:'Post',
            dataType:'json',
            success:function(data){
                $('.section .session_flash_message_box').remove();
                $('.section').prepend('<div class="session_flash_message_box success_box"><div class="message" id="flashMessage">'+data.msg+'</div></div>');
                if(data.error==0){
                        obj.parents('tr').remove();
                }
                obj.parent().removeClass('loading');
            }
        })
    })
})
</script>