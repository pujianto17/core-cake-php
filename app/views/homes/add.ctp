<div class="action-auth">
    <fieldset>
        <h2><?php __('Upload Form');?></h2>
    
<?php
    echo $form->create($modelName, array('action' => 'add'));
	
    echo $form->input('nama_peta', array('label'=>'Name'));
    echo $form->input('nama_pt', array());
    echo $form->input('tujuan', array());
    echo $form->input('tgl_buat', array());
    echo $form->input('pembuat', array());
    echo $form->input('file', array('type'=>'file'));
    echo $form->submit('Save', array('div'=>false)) . "&nbsp;";
    echo $form->end();
?>
    </fieldset>
</div>