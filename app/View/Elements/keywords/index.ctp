<table id="example" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
	<thead>
		<tr>
			<th class=""><?php echo __('#'); ?></th>
			<th class=""><?php echo __('ID'); ?></th>
			<th class=""><?php echo __('Keyword'); ?></th>
			<th class=""><?php echo __('Url'); ?></th>
			<th class=""><?php echo __('Company'); ?></th>
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
			</td>
			<td><?php echo $this->Text->truncate($keyword['Keyword']['Url'], 30); ?></td>
			<td><?php echo $keyword['User']['company']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php echo $this -> Html -> script(array('fancybox/jquery.fancybox.pack')); ?>
<?php echo $this->Html->css(array('fancybox/jquery.fancybox'));?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.edit_keyword_popup a').fancybox({
			type : 'iframe',
			width		: '70%',
			height		: '100%'		
		});
	});
</script>