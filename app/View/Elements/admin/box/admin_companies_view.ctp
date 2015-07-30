<div class="box admin_students_view span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Admin Company View'); ?></h3>
		</div>
	</div>
	<div class="section">
		<table class="table tableX">
			<tr><th><?php echo __('Contact'); ?></th>
			<td>
				<?php echo h($company['Company']['contact']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Name'); ?></th>
			<td>
				<?php echo h($company['Company']['name']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Furigana'); ?></th>
			<td>
				<?php echo h($company['Company']['furigana']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Working Time'); ?></th>
			<td>
				<?php echo h($company['Company']['working_time']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Welfare Facilities'); ?></th>
			<td>
				<?php echo h($company['Company']['welfare_facilities']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Benefit'); ?></th>
			<td>
				<?php echo h($company['Company']['benefit']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Dayoff'); ?></th>
			<td>
				<?php echo h($company['Company']['dayoff']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Postcode'); ?></th>
			<td>
				<?php echo h($company['Company']['postcode']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Prefecture'); ?></th>
			<td>
				<?php echo h($company['Company']['prefecture']); ?>
				
			</td></tr>
			<tr><th><?php echo __('City'); ?></th>
			<td>
				<?php echo h($company['Company']['city']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Address No'); ?></th>
			<td>
				<?php echo h($company['Company']['address_no']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Building Name'); ?></th>
			<td>
				<?php echo h($company['Company']['building_name']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Billing Destination'); ?></th>
			<td>
				<?php echo h($company['Company']['billing_destination']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Created'); ?></th>
			<td>
				<?php echo h($company['Company']['created']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Modified'); ?></th>
			<td>
				<?php echo isset($company['Company']['modified'])?h($company['Company']['modified']):__("Not modified"); ?>				
			</td></tr>
		</table>
	</div>
</div>