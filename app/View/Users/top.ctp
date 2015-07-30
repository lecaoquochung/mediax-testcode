<?php $this->assign('title', __('Top Title'));?>
<div id="admin_top">
<?php echo $this->element('navigation'); ?>
<div class="main span10">
<?php echo $this->element('user/box/user_top') ?>
<?php #echo $this->element('user/box/user_supports') ?>
<?php #echo $this->element('user/box/user_sales') ?>
<?php #echo $this->element('user/box/user_statuses') ?>
</div>
</div>