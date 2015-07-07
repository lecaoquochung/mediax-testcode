<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $this->fetch('title') .' | ' .__('System Name').'X'; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('cake_form_custom','bootstrap.min','bootstrap-responsive.min','bootstrap-custom','jquery.msgbox'));
	?>
	<link href="http://lecaoquochung.github.io/ddnb.template/libs/bootstrap/newest/css/bootstrap.css" rel="stylesheet">
	<?php echo $this->Html->css(array('http://lecaoquochung.github.io/ddnb.template/libs/ddnb/css/custom/datax.css')); ?>
	
	<link href='http://fonts.googleapis.com/css?family=Cinzel+Decorative:700' rel='stylesheet' type='text/css'>
	<script type="text/javascript">var base_url = '<?php echo $this->webroot ?>';</script>
	<?php
		echo $this->Html->script(array('jquery-1.8.3.min','bootstrap.min','javascript'));
		#Graph
		echo $this->Html->script(array('exporting', 'highcharts'));
		#Count Keyword
		echo $this->Html->script(array('count_keyword'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	
	<script src="http://lecaoquochung.github.io/ddnb.template/libs/bootstrap/newest/js/bootstrap.js"></script>
	
	<style type="text/css">
		#top{display:none;width:50px;height:50px;position:fixed;bottom:10px;right:10px;text-indent:-99999px;cursor:pointer;background:url(<?php echo FULL_BASE_URL .$this->webroot ?>img/top_orange.png) no-repeat 0 0}
	</style>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('.page').append('<div id="top">Back to Top</div>');
			$(window).scroll(function(){
				//
				if($(window).scrollTop()!=0){
					$('#top').fadeIn();
				}else{
					$('#top').fadeOut();
				}
				//
				// $('.sidebar').animate({top:$(window).scrollTop()+"px" },{queue: false, duration: 0});
			});
			$('#top').click(function(){
				$('html, body').animate({scrollTop:0},1000);
			});
		});
	</script>
</head>

<body class="" id="">
	<div class="page">
		<div class="header"></div>
		<div class="container-fluid">
			<div class="row">
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>	
		<div class="footer"><p class="copyright">Copyright&#169; <?php echo date('Y'); ?> givery, Inc. All rights reserved.</p></div>
	</div>
</body>
</html>
<?php echo $this->element('sql_dump'); ?>