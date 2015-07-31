<?php echo $this->assign('title', __($this->params['controller'] .' ' .$this->params['action'])) ?>
<?php 
	if(isset($this->params['pass'][1]) && !empty($this->params['pass'][1])):
		echo $this->element($this->params['controller'] .'/' .$this->params['action'].'_'.$this->params['pass'][1]);
	else:
		echo $this->element($this->params['controller'] .'/' .$this->params['action']);
	endif;
?>