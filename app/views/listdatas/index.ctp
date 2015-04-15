<h2><?php echo __('Users'); ?></h2>
<div class="actions">
	<ul>
		<li class="user_add"><?php echo $html->link(__('New User', true), array('action'=>'add')); ?></li>
	</ul>
</div><br>

<div>
    <p class="paging_count">
    <?php
        echo $paginator->counter(array(
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
    ?></p>

    <table class="tablegrid" cellpadding="0" cellspacing="0">
    <?php
        echo $html->tableHeaders(array(
                                      'No',
                                      $paginator->sort('username'),
                                      $paginator->sort('Name','realname'),
                                      $paginator->sort('group_id'),
                                      $paginator->sort('email'),
                                      $paginator->sort('active'),
                                      __('Actions', true),
                                     ));
        $rows = array();
        $i = 0;
        foreach ($users as $user):
            $actions = $html->link( $html->image("icons/user_view.png", array("title" => "View")), array('controller' => $modelName.'s', 'action' => 'view', $user[$modelName]['id']), null, null, false);
            $actions .= ' ' . $html->link( $html->image("icons/user_edit.png", array("title" => "Edit")),  array('controller' => $modelName.'s', 'action' => 'edit', $user[$modelName]['id']), array('escape'=>false) );
            if ($user[$modelName]['id']!=1){
                $actions .= ' ' . $html->link( $html->image("icons/user_delete.png", array("title" => "Delete")), array('controller' => $modelName.'s', 'action' => 'delete', $user[$modelName]['id']), null, __('Are you sure want to delete?', true), false);            
            }

            switch ( $user[$modelName]['active'] ){
                case 0:
                    $active = $html->link( $html->image("icons/user_off.png", array("title" => "Inactive")), array('action' => 'active', $user[$modelName]['id'].'/1'), array('escape'=>false) );
                    break;
                case 1:
                    $active = $html->link( $html->image("icons/user.png", array("title" => "Active")), array('action' => 'active', $user[$modelName]['id'].'/0'), array('escape'=>false) );
                    break;
            }
            
            $rows[] = array(
                           array(($paginator->counter(array('format' => '%start%.', true)) + ($i)), array('class'=>'no')),
                           $user[$modelName]['username'],
                           $user[$modelName]['realname'],
                           $user['Group']['name'],
                           $user[$modelName]['email'],
                           array($active, array('style'=>'text-align:center;')),
                           array($actions, array('class'=>'action-grid'))
                        );
            $i++;
        endforeach;

        echo $html->tableCells($rows, array('class'=>'altrow'));
    ?>
    </table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>