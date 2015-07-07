<div class="box admin_statuses span12">
    <div class="navbar">
        <div class="navbar-inner">
        <h3 class="brand"><?php echo __('Edit Company'); ?></h3>
        </div>
    </div>
    <div class="section company form">
    <?php echo $this->Form->create('User'); ?>
        <?php echo $this->Form->input('id'); ?>
        <table class="table tableX">
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Company')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('company', array('label' => FALSE)); ?>
                </td>
            </tr>
<!-- limit price multi group 1 -->
             <tr>
                <th>
					<span class="label label-warning"><?php echo __('Limit Price Group') .'1'; ?></span>
                </th>
                <td>
	                <?php echo $this->Form->input('limit_price_multi', array('label' => false, 'type' => 'text', 'div' => FALSE)); ?>
	                <?php echo $this->Html->tag('span', __('Yen')); ?>
                </td>
            </tr>
<!-- limit price multi group 2 -->
             <tr>
                <th>
					<span class="label label-warning"><?php echo __('Limit Price Group') .'2'; ?></span>
                </th>
                <td>
	                <?php echo $this->Form->input('limit_price_multi2', array('label' => false, 'type' => 'text', 'div' => FALSE)); ?>
	                <?php echo $this->Html->tag('span', __('Yen')); ?>
                </td>
            </tr>
<!-- limit price multi group 3 -->
             <tr>
                <th>
					<span class="label label-warning"><?php echo __('Limit Price Group') .'3'; ?></span>
                </th>
                <td>
	                <?php echo $this->Form->input('limit_price_multi3', array('label' => false, 'type' => 'text', 'div' => FALSE)); ?>
	                <?php echo $this->Html->tag('span', __('Yen')); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Department')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('department', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Name')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('name', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('TEL')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('tel', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('FAX')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('fax', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Email')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('email', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('URL')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('homepage', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Address')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('address', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Postcode')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('zipcode', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Billlastday')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('billlastday', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Remark')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('remark', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Sell Remark')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('sellremark', array('label' => FALSE, 'type' => 'textarea')); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Tech Remark')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('techremark', array('label' => FALSE, 'type' => 'textarea')); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Pwd')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('pwd', array('label' => FALSE, 'div' => FALSE, 'type' => 'text')); ?>
                    <span class="text-warning"><strong><?php echo __('※変更の時に入力してください') ?></strong></span>
                </td>
            </tr>
        </table>
        	<?php echo $this->Form->button(__('Submit'), array('class'=>'btn btn-info', 'div'=>FALSE)); ?>
        	<?php echo $this->Html->link(__('Company Detail'), array('controller' => 'users' , 'action' => 'view', $this->request->data['User']['id']), array('class' => "btn")); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>