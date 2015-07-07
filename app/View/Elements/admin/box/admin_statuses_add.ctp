<?php $this->assign('title', __('New Status'));?>
<div class="box admin_statuses_add span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('New Status'); ?></h3>
		</div>
	</div>
	<div class="section">
		<?php echo $this->Form->create('Status'); ?>
			<!--<legend><?php echo __('Admin Add Status'); ?></legend>-->
			<?php
				// #1 Session
				echo $this->Form->input('user_id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.admin.id')));
				if(isset($this->request->params['pass'][0])){
					echo $this->Form->input('jobhunter_id',array('value'=>$this->request->params['pass'][0],'type'=>'hidden'));	
				} else {
					echo $this->Form->input('jobhunter_id');	
				}
				echo $this->Form->input('joboffer_id');
				
				$current_year = date('Y');
				echo $this->Form->input('Date',array('type'=>'date' ,'dateFormat'=>'YMD','monthNames'=>Configure::read('monthNames'), 'maxYear'=>$current_year+1, 'minYear'=>$current_year));
				
			?>
		<?php echo $this->Form->button(__('Submit'), array('onClick'=>'return confirmSubmit()')); ?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		//list box
		var jobhunter_id = $('#StatusJobhunterId').val();
        $.ajax({
            url: '<?php echo $this->webroot ?>statuses/get_list_joboffer_status/'+jobhunter_id,
            data:{},
            type:'post',
            async:true,
            success:function(res){
				$('#StatusJobofferId').html(res);
            }
        }); 			
			
		$('#StatusJobhunterId').change(function(){
			var jobhunter_id = $('#StatusJobhunterId').val();
			$.ajax({
				url: '<?php echo $this->webroot ?>statuses/get_list_joboffer_status/'+jobhunter_id,
				data:{},
				type:'post',
				async:true,
				success:function(res){
					$('#StatusJobofferId').html(res);
				}
			});		
		});
		
		//jobhunter
        $.ajax({
            url: '<?php echo $this->webroot ?>statuses/get_list_jobhunter_status/',
            data:{},
            type:'post',
            async:true,
            success:function(res){
				$('#StatusJobhunterId').html(res);
            }
        }); 
	})
</script>