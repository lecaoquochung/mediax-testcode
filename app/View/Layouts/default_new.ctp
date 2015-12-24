<?php
/* ----------------------------------------------------------------------
 * ddnb admin template
 *
 * @author: lecaoquochung@gmail.com
 * @created 2015
 * ---------------------------------------------------------------------- */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja">
<head>
	<?php echo $this -> Html -> charset(); ?>
	<title><?php echo $this -> fetch('title') . ' | ' . __('System Name') . 'X'; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!--css -->
	<?php
	echo $this -> Html -> css(array(
		'//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css', 
		'//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css', 
		'//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css', 
		'morris/morris.css', 
		'jvectormap/jquery-jvectormap-1.2.2.css', 
		'datepicker/datepicker3.css', 
		'daterangepicker/daterangepicker-bs3.css', 
		'bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css', 
		'AdminDDNB.css', 
		'//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css', 
		'custom'
	));
	?>
	
	<!--js -->
	<?php
	echo $this -> Html -> script(array(
		'https://lecaoquochung.github.io/ddnb.template/libs/jquery/2.1.1/jquery-2.1.1.min.js', 
		'https://lecaoquochung.github.io/ddnb.template/libs/bootstrap/newest/js/bootstrap.js', 
	));
	?>
	 <!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">var base_url =  '<?php echo $this->webroot ?>';</script>
	
	<?php
		echo $this -> Html -> script(array('javascript'));
		echo $this -> Html -> script(array('count_keyword'));
		echo $this -> fetch('meta');
		echo $this -> fetch('css');
		echo $this -> fetch('script');
	?>
	
	<!-- google chart -->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	
</head>

<body class="skin-black fixed" id="">
	<?php echo $this -> element('header'); ?>
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<?php echo $this -> element('sidebar'); ?>
		<aside class="right-side">
			<section class="content">
				<?php echo $this -> fetch('content'); ?>
			</section>
		</aside>
	</div>
	
	<?php
		echo $this -> Html -> script(array(
			'AdminDDNB/app.js',
			'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js', 'plugins/daterangepicker/daterangepicker.js', 'plugins/datepicker/bootstrap-datepicker.js',
			'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
			'plugins/jvectormap/jquery-jvectormap-world-mill-en.js', 'plugins/sparkline/jquery.sparkline.min.js', '//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js',
			'AdminDDNB/api.js',
		));
	?>
	
	<?php #echo $this->element('footer'); ?>
	
	<?php echo $this -> fetch('scriptBootom'); ?>
</body>

</html>
<?php echo $this -> element('sql_dump'); ?>