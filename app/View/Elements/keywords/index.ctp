<div class="row">
<div class="col-xs-12">
	<div class="box-content">
		<div class="col-xs-12">
			<span class="align-right">
				<a href="<?php echo Router::url(array('action'=>'exportCsv')) ?>" class="btn-sm btn-info"><i class="fa fa-download"></i></a>
			</span>
		</div>
				
	<table id="example" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
		<thead>
			<tr>
				<th class=""><?php echo __('#'); ?></th>
				<th class=""><?php echo __('ID'); ?></th>
				<th class=""><?php echo __('Keyword'); ?></th>
				<th class=""><?php echo __('Server'); ?></th>
				<th class=""><?php echo __('Cost'); ?></th>
				<th class=""><?php echo __('Limit Price'); ?></th>
				<th class=""><?php echo __('Seika Sales'); ?></th>
				<th class=""><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php $count = 0; ?>
		<?php foreach ($keywords as $keyword): $count++;?>
			<tr>
				<td><?php echo $count; ?></td>
				<td><?php echo $keyword['Keyword']['ID']; ?></td>
				<td class="edit_keyword_popup">			
					<a href="<?php echo $this->webroot; ?>keywords/edit/<?php echo $keyword['Keyword']['ID']; ?>/popup" title="Edit keyowrd <?php echo $keyword['Keyword']['Keyword']; ?>"><?php echo $keyword['Keyword']['Keyword']; ?></a>
					<br />
					<?php echo $this->Text->truncate($keyword['Keyword']['Url'], 30); ?>
				</td>
				<td>
					<div class="edit_inline" data-name="server_id" data-pk="<?php echo $keyword['Keyword']['ID']; ?>">
						<?php echo $keyword['Server']['name']; ?>
					</div>
				</td>
				<td>
					<div class="edit_inline" data-name="cost" data-pk="<?php echo $keyword['Keyword']['ID']; ?>">
						<?php echo $keyword['Keyword']['cost']; ?>
					</div>
				</td>
				<td>
					<div class="edit_inline" data-name="limit_price" data-pk="<?php echo $keyword['Keyword']['ID']; ?>">
						<?php echo $keyword['Keyword']['limit_price']; ?>
					</div>
				</td>
				<td>
					<?php if(empty($keyword['Keyword']['sales'])): ?>
						<a href="javascript:void(0)" class="edit_ajax" data-value="1" data-name="sales" data-pk="<?php echo $keyword['Keyword']['ID']; ?>"><span class="label label-default"><i class="fa fa-times"></i></span></a>
					<?php else: ?>
						<a href="javascript:void(0)" class="edit_ajax" data-value="0" data-name="sales" data-pk="<?php echo $keyword['Keyword']['ID']; ?>"><span class="label label-success"><i class="fa fa-check"></i></span></a>
					<?php endif; ?>
				</td>			
				<td class="edit_keyword_extra">
					<a href="<?php echo $this->webroot; ?>extras/add/<?php echo $keyword['Keyword']['ID']; ?>/popup" title="Edit keyowrd <?php echo $keyword['Keyword']['Keyword']; ?>"><span class="label label-warning"><i class="fa fa-edit"></i></span></a>
					<a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'view', $keyword['User']['id'])) ?>" class="label label-success" data-toggle="tooltip" rel="tooltip" title="<?php echo $this->Text->truncate($keyword['User']['company'], 12); ?>"><i class="fa fa-eye"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	</div>
</div>
</div>


<?php echo $this -> Html -> script(array('fancybox/jquery.fancybox','bootstrap-editable')); ?>
<?php echo $this->Html->css(array('fancybox/jquery.fancybox','bootstrap-editable'));?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.edit_keyword_popup a, .edit_keyword_extra a').fancybox({
			type : 'iframe',
			width		: '70%',
			height		: '100%'		
		});
		
		$.fn.editable.defaults.mode = 'inline';
		//editables 
		$('.edit_inline').editable({
			   url: '<?php echo $this->webroot.'keywords/edit_inline' ?>',
			   type: 'text',
			   name: $(this).attr('name'),
			   title: 'Edit '+$(this).attr('name')
		});		
		
		$('.edit_ajax').click(function(){
			var obj = $(this);
			var name = $(this).attr('data-name');
			var value = $(this).attr('data-value');
			var pk = $(this).attr('data-pk');
			$.ajax({
				url: '<?php echo $this->webroot.'keywords/edit_inline' ?>',
				data: {name:name, value:value, pk:pk},
				type: 'post',
				dataType: 'json',
				success: function(data){
					var tmp_value = data.value==0?1:0;
					obj.attr('data-value',tmp_value);
					if(tmp_value==1){
						obj.find('i').attr('class','fa fa-times');
						obj.find('span').attr('class','label label-default');
					}else{
						obj.find('i').attr('class','fa fa-check');
						obj.find('span').attr('class','label label-success');
					}
				}
			});
		});
	});
</script>