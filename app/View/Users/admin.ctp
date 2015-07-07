<?php echo $this->assign('title', __(Inflector::singularize($this->params['controller']) .' ' .$this->params['action'])) ?>
<div id="">
<?php echo $this->element('navigation'); ?>
<div class="main span10">
<?php echo $this->element($this->params['controller'] .'/' .$this->params['action']) ?>
</div>
</div>