<?php echo $this -> Form -> create('Keyword', array('class' => 'KeywordAddForm')); ?>
<!-- keyword -->
	<div class="form-group">
		<label for="InputKeyword"><?php echo $this -> Html -> tag('span', __('Keyword')); ?></label>
		<?php echo $this -> Form -> input('Keyword', array('type' => 'keyword', 'label' => FALSE, 'placeholder' => __('Enter Keyword'), 'class' => 'form-control')); ?>
	</div>
<!-- url -->
	<div class="form-group">
		<label for="InputUrl"><?php echo $this -> Html -> tag('span', __('URL')); ?></label>
		<?php echo $this -> Form -> input('Url', array('type' => 'url', 'label' => FALSE, 'placeholder' => __('Enter Url'), 'class' => 'form-control')); ?>
	</div>
<!-- strict: domain or url -->
	<div class="form-group">
		<label for="InputStrict"><?php echo $this -> Html -> tag('span', __('Strict')); ?></label>
		<?php echo $this -> Form -> input('Strict', array('label' => false, 'type' => 'select', 'options' => Configure::read('STRICT'), 'class' => 'form-control')); ?>
	</div>
	<?php echo $this->Form->button(__('Check'), array('class'=>'btn btn-warning', 'div'=>FALSE)); ?>
<?php echo $this -> Form -> end(); ?>

RANK: <?php echo isset($rank) ? $rank:''; ?>
<br />
Cache: <?php echo isset($cache_text) ? $cache_text:''; ?>
<br />
Domain: <?php echo isset($domain) ? $domain:''; ?>

<?php echo $this->element('sql_dump'); ?>