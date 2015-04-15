<div class="action-user">
    <?php echo $html->link(__('Back Letter Ins', true), array('action'=>'index'), array('class'=>'user-link')); ?>
</div>
<?php echo $form->create('LetterIn');?>
<div class="action-auth">
    <fieldset>
        <h2><?php __('Add LetterIns');?></h2>
	<table class="input">
            <tr>
                <td class="label-required"><?php echo __('Letter No.');?>:</td>
				
				<td><?php
						/*echo "<pre>";
						print_r($users);
						echo "</pre>";*/
						
						$date = date("y.d"); 
						$result = $date.".001/SIT/".$users[0]['Groups']['alias']."/";
						/*echo $form->input('first',array('div'=>false,'label'=>false,'name'=>'data[LetterIn][letter_no][first]','value'=>$result,'readonly'=>'readonly','style'=>'width: 140px'));*/
						echo $form->input('letter_no', array('div'=>false,'value'=>$result, 'label' => false, 'maxlength' => 50, 'class'=>'required'));
					?>
				</td>
            </tr>
            <tr>
                <td class="label-required"><?php echo __('From');?>:</td>
                <td><?php echo $form->input('letter_from', array('div'=>false, 'label' => false, 'maxlength' => 100, 'class'=>'required'));?></td>
            </tr>
            <tr>
                <td><?php echo __('Date');?>:</td>
                <td><?php echo $form->input('letter_date', array('div'=>false, 'label' => false, 'class' => 'inputDate'));?></td>
            </tr>
            <tr>
                <td><?php echo __('From Address');?>:</td>
                <td><?php echo $form->input('letter_from_address', array('div'=>false, 'label' => false));?></td>
            </tr>
            <tr>
                <td><?php echo __('Term');?>:</td>
                <td><?php echo $form->input('letter_term', array('div'=>false, 'label' => false));?></td>
            </tr>
            <tr>
                <td><?php echo __('To');?>:</td>
                <td><?php echo $form->input('letter_to', array('div'=>false, 'label' => false));?></td>
            </tr>
			
            
                <?php echo $form->input('created_by');//, array('div'=>false,'name'=>'data[LetterIn][created_by]','value'=>$users[0]['Groups']['id'] ,'label' => false));?>
            
            <tr>
                <td colspan="2">
                <?php
                    echo $form->submit('Add', array('div'=>false)) . "&nbsp;" . __('or', true) . "&nbsp;";
                    echo $html->link(__('Back to index', true), array('action'=>'index'));
                ?>
                </td>
            </tr>
        </table>

    </fieldset>
</div>