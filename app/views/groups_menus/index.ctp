<h2><?php echo __('Access Menu Management'); ?></h2>

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
            <th>No</th>            
            <th><?php echo $paginator->sort('Group Name', 'Group.id', array('title'=>'Sort by Group'));?></th>
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
            <td class="no" width="2%" nowrap>
                <?php echo ($paginator->counter(array('format' => '%start%.', true)) + ($i-1)); ?>
            </td>
            <td>
                <?php echo $record['Group']['name']; ?>
            </td>
            <td class="action-grid">
                <a href="<?php echo $this->base; ?>/<?php echo $modelName; ?>s/edit/<?php echo $record['Group']['id'] ?>">
                    <img alt="" title="Edit" src="<?php echo $this->base; ?>/img/icons/edit.png"/>
                </a>
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