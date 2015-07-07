<?php $this -> assign('title', __('Notice Add')); ?>
<?php $this->assign('title',  __(ucfirst($this->params['action']) .' ' .ucfirst(Inflector::singularize($this->params['controller']))));?>
<div id="admin_users">
	<?php echo $this -> element('navigation'); ?>
	<div class="main span10">
		<div class="box admin_statuses span12">
			<div class="navbar">
				<div class="navbar-inner">
					<h3><span class="break"></span><?php  echo __(ucfirst($this->params['action']) .' ' .ucfirst(Inflector::singularize($this->params['controller'])));?></h3>
				</div>
			</div>
			<div class="section extras form">
				<?php echo $this -> Session -> flash(); ?>
				<?php echo $this -> Form -> create('Notice'); ?>
				<table class="table tableX">
					<!-- title -->
					<tr>
						<th>
							<?php echo $this -> Html -> tag('span', __('Title')); ?>
						</th>
						<td>
							<?php echo $this -> Form -> input('title', array('label' => FALSE, 'type' => 'text')); ?>
						</td>
					</tr>
					<!-- content -->
					<tr>
						<th>
							<?php echo $this -> Html -> tag('span', __('Content')); ?>
						</th>
						<td class="col-sm-12">
							<?php echo $this -> Form -> input('content', array('label' => FALSE, 'type' => 'textarea')); ?>
						</td>
					</tr>
					<!-- notice label -->
					<tr>
						<th>
							<?php echo $this -> Html -> tag('span', __('Label')); ?>
						</th>
						<td>
							<?php echo $this -> Form -> input('label', array('label' => false, 'type' => 'select', 'options' => Configure::read('NOTICE_LABEL'))); ?>
						</td>
					</tr>
					<!-- history -->
					<tr>
						<th>
							<?php echo $this -> Html -> tag('span', __('公開日')); ?>
						</th>
						<td>
							<?php echo $this -> Form -> input('history', array('label' => false, 'type' => 'date', 'dateFormat' => 'YMD', 'monthNames' => Configure::read('monthNames'), 'maxYear' => date('Y'), 'minYear' => date('Y') + 1, 'div' => FALSE, 'style' => 'width:auto;')); ?>
						</td>
					</tr>
				</table>
				<?php echo $this -> Form -> button(__('Submit'), array('class' => 'btn btn-info', 'div' => FALSE)); ?>
				<?php echo $this -> Html -> link(__('Cancel'), '/'.$this->params['controller'], array('class' => "btn btn-danger")); ?>
				<?php echo $this -> Form -> end(); ?>
			</div>
		</div>
	</div>
</div>