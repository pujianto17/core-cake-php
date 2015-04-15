<?php
    echo $html->css('ui.module.css');
    echo $javascript->link('jquery.collapsor');
    echo $javascript->link('collapsor');
?>

<h2><?php echo __($modelName.'s'); ?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add New', true), array('action'=>'add'), array('class'=>'tablegrid-link')); ?></li>
        <li style="float:right;"><?php echo $form->button(__('Toggle All', true), array('class'=>'toggle')); ?></li>
	</ul>
</div>

<table class="tablegrid" cellspacing="1" cellpadding="0">
    <?php
        $menuNames = array_values($menus);
        $menuIds   = array_keys($menus);
        $i=0; $n=0;
        
        $tableHeaders = array(
            __('Menu Name', true),
            __('Enable', true),
            __('Action', true),
        );
        echo $html->tableHeaders($tableHeaders);
        
        $currentController = '';
        foreach ($menus AS $id => $alias) {
            $class = '';
            
            if( substr($alias, 0, 1) == '-' ) {
                $level = substr_count($alias, '-');
                if ( $level==1 ) {
                    $level = 0;
                    $class .= 'controller expand';
                    $oddOptions = array();
                    $evenOptions = array();
                    $alias = substr_replace($alias, '', 0, 1);
                    $currentController = $id;
                } else {
                    $class .= 'level-'.$level;
                    $oddOptions = array('class' => 'hidden controller-'.$currentController);
                    $evenOptions = array('class' => 'hidden controller-'.$currentController);
                    $alias = substr_replace($alias, '', 0, $level);
                }
                
            } else {
                $class = 'field-header';
                $oddOptions = array();
                $evenOptions = array();
            }

            $actions = $html->link( $html->image("icons/edit.png", array("title" => "Edit")), array('controller' => $modelName.'s', 'action' => 'edit', $id), array('escape'=>false) ) . "&nbsp;";
            $actions .= $html->link( $html->image("icons/cross.png", array("title" => "Delete")), array('controller' => $modelName.'s', 'action' => 'delete', $id), null, __('Are you sure want to delete?', true), array('escape'=>false) ) . "&nbsp;";
            $actions .= $html->link( $html->image("icons/cut.png", array("title" => "Delete All Tree")), array('controller' => $modelName.'s', 'action' => 'delete_all', $id), null, __('Are you sure want to delete this menu and its child?', true), false ) . "&nbsp;";
            $actions .= $html->link( $html->image("icons/arrow_up.png", array("title" => "Move Up")), array('action'=>'moveup', $id .'/1'), array('escape'=>false) ) . "&nbsp;";
            $actions .= $html->link( $html->image("icons/arrow_down.png", array("title" => "Move Down")), array('action'=>'movedown', $id .'/1'), array('escape'=>false) ) . "&nbsp;";
            
            switch ( $activemenu[$id] ){
                case 0:
                    $active = $html->link( $html->image("icons/off.png", array("title" => "Disable")), array('action' => 'enable', $id.'/1'), array('escape'=>false) );
                    break;
                case 1:
                    $active = $html->link( $html->image("icons/on.png", array("title" => "Enable")), array('action' => 'enable', $id.'/0'), array('escape'=>false) );
                    break;
            }

            $row = array(
                $html->div($class, $alias, array('id'=>$id)),
                array($active, array('class'=>'no')),
                array($actions, array('class'=>'action-grid'))
            );

            echo $html->tableCells(array($row), $oddOptions, $evenOptions);
        }

    ?>
</table>

<div class="actions">
	<ul>
        <li style="float:right;"><?php echo $form->button(__('Toggle All', true), array('class'=>'toggle')); ?></li>
	</ul>
</div>