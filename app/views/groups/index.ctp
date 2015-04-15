<h2><?php echo __('Groups'); ?></h2>
<div class="actions">
	<ul>
		<li class="group_add"><?php echo $html->link(__('New Group', true), array('action'=>'add')); ?></li>
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
                                      $paginator->sort('name'),
                                      __('Actions', true),
                                     ));
        $rows = array();
        $i = 0;
        foreach ($records as $record):
            $actions = ' ' . $html->link( $html->image("icons/edit.png", array("title" => "Edit")),  array('controller' => $modelName.'s', 'action' => 'edit', $record[$modelName]['id']), array('escape'=>false) );
            if ($record[$modelName]['id']!=1){
                $actions .= ' ' . $html->link( $html->image("icons/cross.png", array("title" => "Delete")), array('controller' => $modelName.'s', 'action' => 'delete', $record[$modelName]['id']), null, __('Are you sure want to delete?', true), false);            
            }            
            
            $rows[] = array(
                           array(($paginator->counter(array('format' => '%start%.', true)) + ($i)), array('class'=>'no', 'width'=>'2%')),
                           $record[$modelName]['name'],
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