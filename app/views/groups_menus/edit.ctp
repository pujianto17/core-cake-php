<div>
    <fieldset>
        <legend><?php __('Edit Access Menu');?></legend>
        <h3><?php __('Access Menu Group: '.$group['Group']['name']);?></h3>
    
<?php
$user = false;
if ( $group['Group']['id']!=1 && $group['Group']['name']!="Administrator" ){
    $user = true;
}

echo $form->create($modelName, array('action' => 'edit/'. $group['Group']['id']));
if ( $user ){    
    //echo $form->button('Check All', array('div'=>false, 'id'=>'check_all')) . "&nbsp;";
}
?>

    <table>
        <?php

            $menuNames = array_values($menus);
            $menuIds   = array_keys($menus);
            $i = 0;
            foreach ($menuNames as $val){
                $level = substr_count($val, '-');
                $lft = $level * 10;
                $checked = false;
                
                if ( isset($groupmenu[$menuIds[$i]]) ){
                    $checked = true;
                    echo $form->input('', array('type'=>'hidden', 'value'=>'1', 'name'=>'data[GroupsMenu]['.$i.'][existed]'));
                }
                
                if ($level==0){ 
                    $name=array();
                    $name[$level] = "check_" . $menuIds[$i];
                    if ( $i!=0 ){ echo "</td></tr>"; }
                    echo "<tr><td>";
                } else {
                    $name[$level] = $name[$level-2] . "_" .$menuIds[$i];
                }
                
                echo '<span style="display:block; margin-left:'.$lft.'px;">';
                echo $form->input('', array('label'=>substr_replace($val, '', 0,$level), 'type'=>'checkbox',
                                            'name'=>'data[GroupsMenu]['.$i.'][check]', 'id'=>$name[$level],
                                            'checked'=>$checked, 'onclick'=>'javascript: check_child(this)'
                                            ));
                echo '</span>';
                echo $form->input('', array('type'=>'hidden', 'value'=>$menuIds[$i], 'name'=>'data[GroupsMenu]['.$i.'][menu_id]'));
                echo $form->input('', array('type'=>'hidden', 'value'=>$listMenus[$menuIds[$i]], 'name'=>'data[GroupsMenu]['.$i.'][url]'));
                $i++;
            } // end foreach

        ?>
    </table>

<?php
    if ( $user ){ echo $form->submit('Save', array('div'=>false)) . "&nbsp;";  }        
    echo $html->link('Back', array('action'=>'/'), array('class'=>'back'));
    echo $form->end();
?>
    </fieldset>
</div>

<script>
var user = '<?php echo $user; ?>';

function check_child(obj){
    var objId = obj.id;
    var pos = objId.split('_');
    
    /** check child menu **/
    if ( obj.checked ){
        $(":checkbox[id*='"+objId+"_']").attr('checked', true);
    } else {
        $(":checkbox[id*='"+objId+"_']").attr('checked', false);
    }

    /** check parent menu **/
    if ( pos.length>2 && obj.checked ){
        var cid = '';
        for ( var i=1; i<pos.length; i++ ){
            cid += '_' + pos[i];
            $("#check"+cid).attr('checked', true);
        }
    }
}

$(document).ready(function(){

    if (!user){ // for admin
        $(":checkbox").attr('checked', true);
        $(":checkbox").attr('disabled', true);
    }
    
    $('#check_all').click(function(){
        if ( $(this).val()=='Check All' ){
            $(":checkbox").attr('checked', true);
            $(this).val('Uncheck All');
        } else {
            $(":checkbox").attr('checked', false);
            $(this).val('Check All');
        }
    });
    
});
</script>