<div class="action-user">
    <?php echo $html->link(__('Manage User', true), array('action'=>'index'), array('class'=>'user-link')); ?>
</div>

<div class="action-auth">
    <fieldset>
        <h2><?php __('Edit User');?></h2>
    
<?php
    echo $form->create($modelName, array('action' => 'edit'));
    echo $form->input('realname', array('label'=>'Name'));
    echo $form->input('username', array());
    //echo $form->input('password', array());
    echo $form->input('email', array());
    echo $form->input('group_id', array('options'=>$groups, 'empty'=>''));
    echo $form->input('active', array('type'=>'checkbox'));
    echo $form->submit('Save', array('div'=>false)) . "&nbsp;";
    echo $form->end();
?>
    </fieldset>
</div>