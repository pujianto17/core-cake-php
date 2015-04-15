<div>
    <fieldset>
        <legend><?php __('Edit '.$modelName);?></legend>
    
<?php
    echo $form->create($modelName, array('action' => 'edit'));
    echo $form->input('name', array());
    echo $form->input('url', array());
    echo $form->input('parent_id', array('type'=>'select', 'label'=>'Parent Menu', 'options'=>$menus, 'empty'=>''));
    echo $form->input('enable', array());
    echo $form->submit('Save', array('div'=>false)) . "&nbsp;";
    echo $html->link('Back', array('action'=>'/'), array('class'=>'back'));
    echo $form->end();
?>
    </fieldset>
</div>