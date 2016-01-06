<div class="row">
    <?php echo $this->Session->flash(); ?>
    <div class="col-xs-12">
        <div class="box-header">
            <div class="col-xs-12">

                <div class="navbar-right">
                	<a class="btn btn-default btn-sm" href="<?php echo Router::url(array('controller' => 'ranklogs')); ?>" role="button"><?php echo __('All'); ?></a>
                    <a class="btn btn-success btn-sm" href="<?php echo Router::url(array('rankrange', 10), array('class' => '')); ?>" role="button">1-10</a>
                    <a class="btn btn-warning btn-sm" href="<?php echo Router::url(array('rankrange', 20), array('class' => '')); ?>" role="button">11-20</a>
                    <a class="btn btn-default btn-sm" href="<?php echo Router::url(array('rankrange', 100), array('class' => '')); ?>" role="button">21-100</a>
                    <a class="btn btn-default btn-sm" href="<?php echo Router::url(array('rankrange', 1000), array('class' => '')); ?>" role="button"><?php echo __('No Rank') ?></a>
                    &nbsp;
                    <a class="btn btn-danger btn-sm" href="<?php echo Router::url(array('controller' => 'keywords', 'action' => 'add')); ?>" role="button"><?php echo __('Add Keyword') ?></a>

                </div>

                <?php echo $this->Form->create('Ranks', array('class' => 'form-search', 'id' => 'RankViewForm_list')); ?>
                <div class="form-group">
                    <div class="controls row">
                        <div class="input-group col-sm-8">
                            <?php
                            echo $this->Form->input('rankDate', array('div' => False,
                                'label' => False,
                                'class' => 'input-sm', 'type' => 'date', 'dateFormat' => 'YMD', 'monthNames' => Configure::read('monthNames'), 'maxYear' => date('Y'), 'minYear' => date('Y') - 1));
                            echo '&nbsp';
                            echo $this->Form->submit(__('Show'), array('class' => 'btn btn-info btn-sm  icon-refresh', 'div' => False));
                            ?>
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>