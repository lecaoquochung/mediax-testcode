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
                    <?php echo $this->Html->tag('span', __('Email')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('email', array('label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $this->Html->tag('span', __('Pwd')); ?>
                </th>
                <td>
                    <?php echo $this->Form->input('pwd', array('label' => FALSE, 'type' => 'text')); ?>
                </td>
            </tr>
        </table>
        <?php echo $this->Form->end(__('Submit')); ?>
    </div>
</div>