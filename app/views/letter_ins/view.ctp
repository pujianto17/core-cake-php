<div class="action-user">
    <?php echo $html->link(__('Back Letter Ins', true), array('action'=>'index'), array('class'=>'user-link')); ?>
</div>
<?php echo $form->create('LetterIn');?>
<div class="action-auth">
    <fieldset>
        <h2><?php __('View LetterIns');?></h2>
	<table class="input">
            <tr>
                <td class="label-required"><?php echo __('Letter No.');?>:</td>
				
					
				
				<td><?php
					echo $LetterIns['LetterIn']['letter_no'];
					?>
				</td>
            </tr>
            <tr>
                <td class="label-required"><?php echo __('From');?>:</td>
                <td><?php echo $LetterIns['LetterIn']['letter_from'];?></td>
            </tr>
            <tr>
                <td><?php echo __('Date');?>:</td>
                <td><?php echo $LetterIns['LetterIn']['letter_date'];?></td>
            </tr>
            <tr>
                <td><?php echo __('From Address');?>:</td>
                <td><?php echo $LetterIns['LetterIn']['letter_from_address'];?></td>
            </tr>
            <tr>
                <td><?php echo __('Term');?>:</td>
                <td><?php echo $LetterIns['LetterIn']['letter_term'];?></td>
            </tr>
            <tr>
                <td><?php echo __('To');?>:</td>
                <td><?php echo $LetterIns['LetterIn']['letter_to'];?></td>
            </tr>

        </table>

    </fieldset>
</div>