<div class="action-user">
    <?php echo $html->link(__('Manage Group', true), array('action'=>'index'), array('class'=>'group-link')); ?>
</div>
<div class="action-auth">
    <fieldset>
        <h2><?php __('Edit Group');?></h2>
    
<?php
    echo $form->create($modelName, array('action' => 'edit'));
    echo $form->input('name', array());
    echo $form->submit('Save', array('div'=>false)) . "&nbsp;";
    echo $form->end();
?>
    </fieldset>
</div>