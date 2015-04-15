<?php
/**
 * for index page, generate grid view and filter form
 * @param fields    array of field_name and label for viewing data
 * @param editable  array of field_name and options for edit link
 * @param filter    array of field_name and label for filtering
 * @param assoc     array of field_name and array of modelName and field
 *
 * sample used :
 * echo $this->element('tablegrid.multy.assoc',
 *       array('fields'   => array('field_name' => 'Label Header', ....),
 *             'editable' => array('field_name'=>array('action'=>'edit', 'modelName'=>'', 'field'=>'')),
 *             'filter'   => array('field_name' => 'Label Find', ..........),
 *             'assoc' => array('field_name'=>array('modelName'=>'', 'field'=>''),...),
 *       ));
 */
?>
<!-- begin tablegrid-head -->
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add New', true), array('action'=>'add'), array('class'=>'tablegrid-link')); ?></li>
	</ul>
</div>
<div>
<?php
    //calling element filter
    //echo $this->element('tablegrid.filter', array('filter'=>$filter));
?>
</div>
<!-- tablegrid-head eof -->
<br>

<!-- begin tablegrid -->
<div>
    <p class="paging_count">
    <?php
        echo $paginator->counter(array(
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
    ?></p>
    
    <form>
    <table cellpadding="0" cellspacing="0" id="tablegrid">
        <tr>
            <th><input type="checkbox" name="checkall" id="checkall" /></th>
            <th>No</th>
            <?php
                foreach ( $fields as $field => $title ){
                    if ( isset($assoc[$field]) ){
                        $field=$assoc[$field]['modelName'].'.'.$field;
                    }
            ?>
            <th><?php echo $paginator->sort($title, $field, array('title'=>'Sort by '.$title));?></th>
            <?php } ?>
            <th>Actions</th>
        </tr>
        <?php
        $i = 0;
        foreach ($records as $record):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
        ?>
        <tr<?php echo $class;?>>
            <td width="1%" class="no"><input type="checkbox" name="data[rows][]" value="<?php echo $record[$modelName]['id']; ?>" />
            <td class="no" width="2%" nowrap>
                <?php echo ($paginator->counter(array('format' => '%start%.', true)) + ($i-1)); ?>
            </td>
               <?php
                foreach ( $fields as $field => $title ){
                    if ( isset($editable[$field]) ){
                        if( isset($editable[$field]['modelName']) ){
                            $editablemodel=$editable[$field]['modelName'];
                                if( isset($editable[$field]['urlName']) ){
                                    $modelName = $editable[$field]['modelName'];
                                }
                        } else {
                            $editablemodel=$modelName;
                        }
                    ?>
                    <td><?php echo $html->link($record[$modelName][$field],
                                                array('action'=>$editable[$field]['action'],
                                                $record[$editablemodel][$editable[$field]['field']])); ?>
                    </td>
                    <?php
                    } else {
                        if ( isset($assoc[$field]) ){
                            if( strstr(strtolower($field), 'date') ){
                                $dataField=$time->format('d-M-Y', $record[$assoc[$field]['modelName']][$assoc[$field]['field']]);
                            } else {
                                $dataField=$record[$assoc[$field]['modelName']][$assoc[$field]['field']];
                            }
                            ?>
                            <td><?php echo $dataField; ?></td>
                        <?php
                        } else {
                            if( strstr(strtolower($field), 'date') ){
                                $dataField=$time->format('d-M-Y', $record[$modelName][$field]);
                            } else {
                                $dataField=$record[$modelName][$field];
                            }
                            ?>
                            <td><?php echo $dataField; ?></td>
                        <?php
                        } ?>
                    <?php
                    } ?>
               <?php
                } ?>
            <td class="action-grid">
            <?php
                echo $html->link(__('Edit', true), array('controller' => $modelName.'s', 'action' => 'edit', $record[$modelName]['id'])) . ' ';
                echo $html->link(__('Delete', true), array('controller' => $modelName.'s', 'action' => 'delete', $record[$modelName]['id']), null, __('Are you sure want to delete?', true));
            ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php echo $form->end();?>
</div>

<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<!-- end table grid -->