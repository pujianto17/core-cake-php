<?php
    echo $html->css('ui.module.css');
    echo $javascript->link('jquery.collapsor');
    echo $javascript->link('collapsor');
?>

<h2><?php echo __($modelName.'s'); ?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Generate', true), array('action'=>'generate'), array('class'=>'tablegrid-link')); ?></li>
		<li style="float:right;"><?php echo $form->button(__('Toggle All', true), array('class'=>'toggle')); ?></li>
	</ul>
</div>
<table class="tablegrid-module" cellpadding="0" cellspacing="0">
    <?php
        $groupNames = array_values($groups);
        $groupIds   = array_keys($groups);

        $tableHeaders = array(
            __('Id', true),
            __('Alias', true),
        );
        $tableHeaders = array_merge($tableHeaders, $groupNames);
        $tableHeaders =  $html->tableHeaders($tableHeaders);
        echo $tableHeaders;
        
        $currentController = '';
        foreach ($acos AS $id => $alias) {
            $class = '';
            if(substr($alias, 0, 1) == '_') {
                $level = 1;
                $class .= 'level-'.$level;
                $oddOptions = array('class' => 'hidden controller-'.$currentController);
                $evenOptions = array('class' => 'hidden controller-'.$currentController);
                $alias = substr_replace($alias, '', 0, 1);
            } else {
                $level = 0;
                $class .= 'controller expand';
                $oddOptions = array();
                $evenOptions = array();
                $currentController = $id;
                $currentAlias = $alias;
            }
            
            $defaultAllow = false;
            if ( ($currentAlias=="Menus" && $alias=="show_menus") || ($currentAlias=="Home" && $alias=="index") ||
                 ($currentAlias=="Users" && ($alias=="login" || $alias=="logout" || $alias=="mypassword" || $alias=="changeMypassword")) ){
                     $defaultAllow = true;
            }
            
            $row = array(
                $id,
                $html->div($class, $alias, array('id'=>$id)),
            );

            foreach ($groups AS $groupId => $groupName) {
                if ($level != 0) {
                    if ($groupId != 1) {
                        if ($permissions[$currentController][$groupId] == 1 || $defaultAllow ) {
                            $row[] = array( $html->image('/img/icons/accept.png', array('class' => 'permission-toggle', 'rel' => $id.'-'.$groupsAros[$groupId])), array('class'=>'no') );
                        } else {
                            $row[] = array( $html->image('/img/icons/cross.png', array('class' => 'permission-toggle', 'rel' => $id.'-'.$groupsAros[$groupId])), array('class'=>'no') );
                        }
                    } else {
                        $row[] = array( $html->image('/img/icons/accept.png'), array('class'=>'no') );
                    }
                } else {
                    $row[] = '';
                }
            }

            echo $html->tableCells(array($row), $oddOptions, $evenOptions);
        }

    ?>
</table>