<?php $this->assign('title', __('Kotei List'));?>
<?php echo $this->element('rankhistories/index') ?>

<?php #echo $this->assign('title', __($this->params['controller'] .' ' .$this->params['action'])) ?>
<?php #echo $this->element($this->params['controller'] .'/' .$this->params['action']) ?>