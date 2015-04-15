<div>
    <fieldset>
    <?php
        echo $form->create(null, array('action'=>'changeMypassword'));
        echo $form->input('email', array('label'=>'Email', 'size'=>'40'));
        echo $form->input('code', array('label'=>'Code', 'size'=>'40'));
        echo $form->input('password1', array('label'=>'New password', 'type'=>'password', 'value' => ''));
        echo $form->input('password2', array('label'=>'Please re-enter password', 'type'=>'password', 'value' => ''));
        echo $form->end(__('Change my password now', true));
    ?>
    </fieldset>
</div>