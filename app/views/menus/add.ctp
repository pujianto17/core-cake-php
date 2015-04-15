<div>
    <fieldset>
        <legend><?php __('Add '.$modelName);?></legend>
    
<?php
    echo $form->create($modelName, array('action' => 'add'));
    echo $form->input('name', array());
    echo $form->input('url', array());
    echo $form->input('parent_id', array('type'=>'select', 'label'=>'Parent Menu', 'empty'=>'', 'options'=>$menus, ));
    echo $form->input('enable', array('checked'=>true));
    echo $form->submit('Save', array('div'=>false)) . "&nbsp;";
    echo $html->link('Back', array('action'=>'/'), array('class'=>'back'));
    echo $form->end();
?>
    </fieldset>
</div>