<?php
class GroupsMenu extends AppModel{
    var $name = 'GroupsMenu';
    
    var $belongsTo = array(
        'Group' => array(
                    'className' => 'Group',
                    'foreignKey' => 'group_id',
                    'fields' => array('id','name')
                ),
        'Menu' => array(
                    'className' => 'Menu',
                    'foreignKey' => 'menu_id',
                    'fields' => array('id','name','parent_id','url')
                )
    );
    
    function saveData($data, $gid){
        
        $this->query("DELETE FROM groups_menus WHERE group_id=$gid");
        
        $temp = array();
        foreach ($data as $key => $val){
            if ( $val['check'] ){
                $temp[$key]['group_id'] = $gid;
                $temp[$key]['menu_id'] = $val['menu_id'];
            }
        }
        
        if( $this->saveAll($temp) ) {
            return true;
        } else {
            return false;
        }
        
    }
}
?>