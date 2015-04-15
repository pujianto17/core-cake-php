<div>
    <fieldset>
        <legend><?php __('Change Password');?></legend>
        <?php echo $form->create('ChangePassword', array('action' => 'index')); ?>
        <table class="input">
            <tr>
                <td>Username</td>
                <td><?php echo $html->div('info', $this->data['User']['realname']); ?></td>
            </tr>
            <tr>
                <td>Old Password</td>
                <td><?php echo $form->input('old_password', array('div'=>false, 'label'=>false, 'type'=>'password')); ?></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td><?php echo $form->input('new_password', array('div'=>false, 'label'=>false, 'type'=>'password')); ?></td>
            </tr>
            <tr>
                <td>Confirm Password</td>
                <td><?php echo $form->input('confirm_password', array('div'=>false, 'label'=>false, 'type'=>'password')); ?></td>
            </tr>
        </table>
    
<?php
    echo $form->submit('Save', array('div'=>false)) . "&nbsp;";
    echo $form->end();
?>
    </fieldset>
</div>