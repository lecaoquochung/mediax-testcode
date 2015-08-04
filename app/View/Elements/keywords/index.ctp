<?php 
	echo $this->Html->link('Export csv',array('controller'=>'keywords','action'=>'exportCsv'),array('class'=>'btn btn-info'));
	echo $this->Html->link('Upload csv',array('controller'=>'keywords','action'=>'uploadCsv'),array('class'=>'btn btn-success'));
?>
<table id="example" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
	<thead>
		<tr>
			<th class=""><?php echo __('#'); ?></th>
			<th class=""><?php echo __('ID'); ?></th>
			<th class=""><?php echo __('Keyword'); ?></th>
			<th class=""><?php echo __('Company'); ?></th>
			<th class=""><?php echo __('Cost'); ?></th>
			<th class=""><?php echo __('Price'); ?></th>
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
			<td><?php echo $this->Text->truncate($keyword['User']['company'], 12); ?></td>
			<td>
				<div class="edit_inline" data-name="cost" data-pk="<?php echo $keyword['Keyword']['ID']; ?>">
					<?php echo $keyword['Keyword']['cost']; ?>
				</div>
			</td>
			<td>
				<div class="edit_inline" data-name="Price" data-pk="<?php echo $keyword['Keyword']['ID']; ?>">
					<?php echo $keyword['Keyword']['Price']; ?>
				</div>
			</td>
			<td class="edit_keword_extra">
				<a href="<?php echo $this->webroot; ?>extras/add/<?php echo $keyword['Keyword']['ID']; ?>/popup" title="Edit keyowrd <?php echo $keyword['Keyword']['Keyword']; ?>"><i class="fa fa-edit"></i></a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php echo $this -> Html -> script(array('fancybox/jquery.fancybox','bootstrap-editable')); ?>
<?php echo $this->Html->css(array('fancybox/jquery.fancybox','bootstrap-editable'));?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.edit_keyword_popup a').fancybox({
			type : 'iframe',
			width		: '70%',
			height		: '100%'		
		});
		
		$('.edit_keyword_extra a').fancybox({
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
	});
</script>