<h2><?php echo __('Letter Ins'); ?></h2>
<div class="actions">
	<ul>
		<li class="user_add"><?php echo $html->link(__('New Letter ins', true), array('action'=>'add')); ?></li>
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
                                      $paginator->sort('Letter No.'),
                                      $paginator->sort('From'),
                                      $paginator->sort('Date'),
                                      $paginator->sort('From Address'),
                                      $paginator->sort('Term'),
									  $paginator->sort('To'),
                                      //$paginator->sort('Unit'),
                                      $paginator->sort('Created By'),
									  $paginator->sort('Created On'),
                                      __('Actions', true),
                                     ));
        $rows = array();
        $i = 0;
        foreach ($LetterIns as $LetterIn):
			/*echo "<pre>";
				print_r ($LetterIn);
			echo "</pre>";*/
		
            $actions = $html->link( $html->image("icons/user_view.png", array("title" => "View")), array('controller' => $modelName.'s', 'action' => 'view', $LetterIn[$modelName]['id']), null, null, false);
            $actions .= ' ' . $html->link( $html->image("icons/user_edit.png", array("title" => "Edit")),  array('controller' => $modelName.'s', 'action' => 'edit', $LetterIn[$modelName]['id']), array('escape'=>false) );
            if ($LetterIn[$modelName]['id']!=1){
                $actions .= ' ' . $html->link( $html->image("icons/user_delete.png", array("title" => "Delete")), array('controller' => $modelName.'s', 'action' => 'delete', $LetterIn[$modelName]['id']), null, __('Are you sure want to delete?', true), false);            
            }

            /*switch ( $LetterIn[$modelName]['active'] ){
                case 0:
                    $active = $html->link( $html->image("icons/user_off.png", array("title" => "Inactive")), array('action' => 'active', $LetterIn[$modelName]['id'].'/1'), array('escape'=>false) );
                    break;
                case 1:
                    $active = $html->link( $html->image("icons/LetterIn.png", array("title" => "Active")), array('action' => 'active', $LetterIn[$modelName]['id'].'/0'), array('escape'=>false) );
                    break;
            }*/
            
            $rows[] = array(
                           array(($paginator->counter(array('format' => '%start%.', true)) + ($i)), array('class'=>'no')),
                           $LetterIn[$modelName]['letter_no'],
                           $LetterIn[$modelName]['letter_from'],
                           $LetterIn[$modelName]['letter_date'],
                           $LetterIn[$modelName]['letter_from_address'],
                           $LetterIn[$modelName]['letter_term'],
                           $LetterIn[$modelName]['letter_to'],
						   //$LetterIn[$modelName]['letter_to'],
                           $LetterIn[$modelName]['created_by'],
                           $LetterIn[$modelName]['created'],
						   //$LetterIn[$modelName]['created'],
						   //array($active, array('style'=>'text-align:center;')),
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