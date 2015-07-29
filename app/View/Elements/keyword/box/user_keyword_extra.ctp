<?php
global $current_year;
?>
<div class="box admin_statuses_add span12">
          <div class="navbar">
                    <div class="navbar-inner">
                              <h3 class="brand"><?php echo __('Keyword Extra'); ?></h3>
                    </div>
          </div>
          <div class="section keywords form">
                    <?php echo $this->Form->create('Extra', array('class' => 'KeywordExtra')); ?>
                    <?php echo $this->Form->input('ID'); ?>
                    <table class="table tableX">
                              <tr>
                                        <th>
                                                  <?php echo $this->Form->input('ExtraType', array('label' => FALSE, 'type' => 'select', 'options' => Configure::read('EXTRA'))); ?>
                                        </th>
                                        <td>
                                                  <?php echo $this->Form->input('Price', array('label' => FALSE, 'type' => 'text')); ?>
                                        </td>
                              </tr>
                    </table>
                    <?php echo $this->Form->end(__('Submit')); ?>
          </div>
</div>