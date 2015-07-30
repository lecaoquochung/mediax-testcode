<div class="row">
	<div class="col-xs-12">
		<section class="">
			<?php echo $this->Session->flash(); ?>
			<div class="box-header">
				<!-- right -->
				<h3>
					<a class="btn btn-success btn-sm" href="<?php echo Router::url(array( 'rankrange', 10), array('class' => '')); ?>" role="button">1-10</a>
					<a class="btn btn-warning btn-sm" href="<?php echo Router::url(array( 'rankrange', 20), array('class' => '')); ?>" role="button">11-20</a>
					<a class="btn btn-default btn-sm" href="<?php echo Router::url(array( 'rankrange', 100), array('class' => '')); ?>" role="button">21-100</a>
					<a class="btn btn-default btn-sm" href="<?php echo Router::url(array( 'rankrange', 1000), array('class' => '')); ?>" role="button"><?php echo __('No Rank') ?></a>
				</h3>
			</div>
		</section>
	</div>
</div>