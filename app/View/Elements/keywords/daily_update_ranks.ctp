<?php echo $this->Form->create('Keyword',array('class'=>'form-search')); ?>
<div class="row">
	<h3 class="brand"><?php echo  __('Keyword List') .(' : ') .__('Daily Update Ranks'); ?></h3>
    <div class="section">
        <?php 
            echo $this->Form->input('offset', array(
                            'div' => FALSE,
                            'label' => __('Offset'),
                            'type'=>'text',
                            'after'=>$this->Form->input('limit', array(
                                'type'=>'text',
                                'label'=> __('Limit'),
                                'div'=>FALSE
                                ))
            ));
        ?>
        <?php echo $this->Form->button(__('Set Up'), array('class'=>'btn btn-success', 'div'=>FALSE)); ?>

        <div class="new-line"></div>
        <span class="text-error">※スタート位置またはキーワード数を設定しないと全てのキーワードを順位チェックします。</span>
        <div class="common-button">
            <?php 
                echo $this->Html->link(__('Load All Rank'), 'javascript:void(0)',array('class'=>'loadAllRank btn btn-danger')) 
                    .$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'));
            ?>
        </div>
        <div class="result"></div>
        <div class="progress-rankcheck" style="text-align: left">
            <div class="row-fluid">
                <div class="span3"><b>0%</b><br/><small></small></div>
                <div class="span3"><b>50%</b><br/><small></small></div>
                <div class="span3"><b>100%</b><br/><small></small></div>
            </div>
            <div class="progress progress-striped active span6">
                <div class="bar bar-contract" style="width: 0%;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <h3 class="brand"><?php echo  __('Nocontract List') .(' : ') .__('Daily Update Ranks'); ?></h3>
    <div class="section">
        <?php 
            echo $this->Form->input('offset_nocontract', array(
                            'div' => FALSE,
                            'label' => __('Offset'),
                            'type'=>'text',
                            'after'=>$this->Form->input('limit_nocontract', array(
                                'type'=>'text',
                                'label'=> __('Limit'),
                                'div'=>FALSE
                                ))
            ));
        ?>
        <?php echo $this->Form->button(__('Set Up'), array('class'=>'btn btn-success', 'div'=>FALSE)); ?>

        <div class="new-line"></div>
        <span class="text-error">※スタート位置またはキーワード数を設定しないと全てのキーワードを順位チェックします。</span>
        <div class="common-button">
            <?php 
                echo $this->Html->link(__('Load All Rank'), 'javascript:void(0)',array('class'=>'loadNocontractRank btn btn-danger')) 
                    .$this->Html->image('loading.gif',array('class'=>'loadingNocontract','style'=>'display:none'));
            ?>
        </div>
        <div class="result-nocontract"></div>
        <div class="progress-rankcheck" style="text-align: left">
            <div class="row-fluid">
                <div class="span3"><b>0%</b><br/><small></small></div>
                <div class="span3"><b>50%</b><br/><small></small></div>
                <div class="span3"><b>100%</b><br/><small></small></div>
            </div>
            <div class="progress progress-striped active span6">
                <div class="bar bar-nocontract" style="width: 0%;"></div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?> 

<script type="text/javascript">
    var max = <?php echo count($keywords) ?>;
    var process = 0;
    var min = 0;
    
    <?php $keywords = array_values($keywords) ?>       
    var keyword = <?php echo $keywords[0]; ?>;        
    <?php 
    unset($keywords[0]);
    $keywords = array_values($keywords);
    ?>
    var keywords = '<?php echo json_encode($keywords); ?>';
    var max_contract = <?php echo count($keyword_nocontacts) ?>;
    var process_contract = 0;
    var min_contract = 0;
    
    <?php $keyword_nocontacts = array_values($keyword_nocontacts) ?>       
    var keyword_contract = <?php echo $keyword_nocontacts[0]; ?>;        
    <?php 
    unset($keyword_nocontacts[0]);
    $keyword_nocontacts = array_values($keyword_nocontacts);
    ?>
    var keywords_contract = '<?php echo json_encode($keyword_nocontacts); ?>';  
        
    $(document).ready(function(){
        $('.loadAllRank').click(function(){                
            $('.loading').show();
            $('.loadAllRank').hide();
            $('.loadNocontractRank').hide();
            load_rank(keyword,keywords,0);        
        })
        
        $('.loadNocontractRank').click(function(){                
            $('.loadingNocontract').show();
            $('.loadAllRank').hide();
            $('.loadNocontractRank').hide();
            load_rank_nocontract(keyword_contract,keywords_contract,1);        
        })
    })
    
    //
    function load_rank(keyID, keywords, nocontract){
        $.ajax({
            url:'<?php echo $this->webroot ?>keywords/daily_update_ranks',
            data:{keyID:keyID,keywords:keywords,nocontract:nocontract},
            async: true,
            type:'POST',
            dataType:'json',
            success:function(data){
                if($('#flashMessage').size()>0){
                    $('#flashMessage').html($('#flashMessage').html()+', '+keyID);
                }else{
                    $('.result').prepend('<div class="session_flash_message_box success_box"><div class="message" id="flashMessage"><?php echo __('Update success Rank Keyword'); ?>: '+keyID+'</div></div>');
                }
                min++;
                process = (min/max)*100;
                if(process>100) process=100;                                
                $('.progress .bar-contract').css('width',process+'%');
                if(data.keyID!=''){
                    load_rank(data.keyID,data.keywords,nocontract); 
                }else{
                    $('.loading').hide();
                    var t= setTimeout(function(){
                        $('.progress .bar-contract').css('width','0%');
                        $('.loadAllRank').show();
                        $('.loadNocontractRank').show();
                        min = 0;
                        clearTimeout(t);
                    }, 1000);                        
                }
            }
        })
    }
    
    //
    function load_rank_nocontract(keyID, keywords, nocontract){
        $.ajax({
            url:'<?php echo $this->webroot ?>keywords/daily_update_ranks',
            data:{keyID:keyID,keywords:keywords,nocontract:nocontract},
            async: true,
            type:'POST',
            dataType:'json',
            success:function(data){
                if($('#flashMessage').size()>0){
                    $('#flashMessage').html($('#flashMessage').html()+', '+keyID);
                }else{
                    $('.result-nocontract').prepend('<div class="session_flash_message_box success_box"><div class="message" id="flashMessage"><?php echo __('Update success Rank Keyword'); ?>: '+keyID+'</div></div>');
                }
                min_contract++;
                process_contract = (min_contract/max_contract)*100;
                if(process_contract>100) process_contract=100;                                
                $('.progress .bar-nocontract').css('width',process_contract+'%');
                if(data.keyID!=''){
                    load_rank_nocontract(data.keyID,data.keywords,nocontract); 
                }else{
                    $('.loadingNocontract').hide();
                    var t_nocontact= setTimeout(function(){
                        $('.progress .bar-nocontract').css('width','0%');
                        $('.loadAllRank').show();
                        $('.loadNocontractRank').show();
                        min_contract = 0;
                        clearTimeout(t_nocontact);
                    }, 1000);                        
                }
            }
        })
    }
</script>