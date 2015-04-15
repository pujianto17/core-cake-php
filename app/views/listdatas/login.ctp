<div id="form-login">
    <fieldset>
    <?php
        $session->flash('auth');
        echo $form->create('User', array('action' => 'login'));
        echo $form->input('username');
        echo $form->input('password');
        echo $form->submit('Login');
        echo $form->end();
    ?>
    <p class="lostpassword">
        <?php echo $html->link(__("I forgot my password", true), array('action'=>'mypassword')); ?>
    </p>
    </fieldset>
</div>