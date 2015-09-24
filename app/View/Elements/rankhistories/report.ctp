<div class="row">
	<div class="col-xs-12">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#today" aria-controls="today" role="tab" data-toggle="tab"><?php echo __('Today') ?></a></li>
                <li role="presentation"><a href="#yesterday" aria-controls="yesterday" role="tab" data-toggle="tab"><?php echo __('Yesterday') ?></a></li>
                <li role="presentation"><a href="#in" aria-controls="in" role="tab" data-toggle="tab"><?php echo __('Rank-in') ?></a></li>
                <li role="presentation"><a href="#out" aria-controls="out" role="tab" data-toggle="tab"><?php echo __('Rank-out') ?></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="today">
                    <p><strong>Rank 1~10:</strong> <?php echo $sumaries['today']['1~10'] ?></p>
                    <p><strong>Rank 11~20:</strong> <?php echo $sumaries['today']['11~20'] ?></p>
                    <p><strong>Rank 21~100:</strong> <?php echo $sumaries['today']['21~100'] ?></p>
                    <p><strong>No Rank:</strong> <?php echo $sumaries['today']['no_rank'] ?></p>
                    <h3 style="color:red">Detail</h3>
                    <?php foreach ($keywords['today'] as $k => $rank): ?>
                        <?php if (count($rank) > 0): ?>
                            <p><strong>Rank <?php echo $k ?></strong></p>
                            <?php foreach ($rank as $today): ?>
                                <p>
                                    <a href="<?php echo $today['Keyword']['Url'] ?>" target="_blank"><?php echo $today['Keyword']['Keyword'] ?></a> 
                                    <strong><?php echo $today['Rankhistory']['Rank'] ?></strong>
                                </p>
                            <?php endforeach; ?>
                        <?php endif ?>   
                    <?php endforeach; ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="yesterday">
                    <p><strong>Rank 1~10:</strong> <?php echo $sumaries['yesterday']['1~10'] ?></p>
                    <p><strong>Rank 11~20:</strong> <?php echo $sumaries['yesterday']['11~20'] ?></p>
                    <p><strong>Rank 21~100:</strong> <?php echo $sumaries['yesterday']['21~100'] ?></p>
                    <p><strong>No Rank:</strong> <?php echo $sumaries['yesterday']['no_rank'] ?></p>  
                    <h3 style="color:red">Detail</h3>
                    <?php foreach ($keywords['yesterday'] as $k => $rank): ?>
                        <?php if (count($rank) > 0): ?>
                            <p><strong>Rank <?php echo $k ?></strong></p>
                            <?php foreach ($rank as $yesterday): ?>
                                <p>
                                    <a href="<?php echo $yesterday['Keyword']['Url'] ?>" target="_blank"><?php echo $yesterday['Keyword']['Keyword'] ?></a> 
                                    <strong><?php echo $yesterday['Rankhistory']['Rank'] ?></strong>
                                </p>
                            <?php endforeach; ?>
                        <?php endif ?>          
                    <?php endforeach; ?>                            
                </div>
            </div>

        </div>        

    </div>
</div>	