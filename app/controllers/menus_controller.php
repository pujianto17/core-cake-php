<?php
class MenusController extends AppController{
    var $name = 'Menus';
    
    function index(){
        $this->__index();
        $this->set('formgrid', Helper::url('delete_rows'));
        if ( empty($this->data) ){            
            $menus = $this->Menu->generatetreelist(null, '{n}.Menu.id', '{n}.Menu.name', '-');
            $this->set('menus', $menus);
                        
            $activemenu = $this->Menu->find('list', array('fields'=>array('id','enable')));
            $this->set('activemenu', $activemenu);
        }
    }
    
    function add(){
        $this->__add();
        if (empty($this->data)){
            $menus = $this->{Inflector::singularize($this->name)}->generatetreelist(null, '{n}.Menu.id', '{n}.Menu.name', '--');
            $this->set('menus', $menus);
        }
    }
    
    function edit($id=null){
        $this->__edit($id);
        if (empty($this->data)){
            $this->data = $this->{Inflector::singularize($this->name)}->read(null, $id);
            $menus = $this->{Inflector::singularize($this->name)}->generatetreelist(null, '{n}.Menu.id', '{n}.Menu.name', '--');
            $this->set('menus', $menus);
        }
    }
    
    function delete($id=null){
        if ( $this->{Inflector::singularize($this->name)}->removeFromTree($id,true) ){
            $this->Session->setFlash(__("Record deleted", true), 'success');
        } else {
            $this->Session->setFlash(__("Unable to delete record", true), 'error');
        }
        $this->redirect(array('action' => 'index'));
    }
    
    function delete_all($id=null){
        if ( !empty($id) ){
            $this->{Inflector::singularize($this->name)}->id = $id;
            if ( $this->{Inflector::singularize($this->name)}->delete() ){
                $this->Session->setFlash(__("Record deleted", true), 'success');
            } else {
                $this->Session->setFlash(__("Unable to delete record", true), 'error');
            }
            $this->redirect(array('action' => 'index'));
        }
    }
    
    function enable($id, $active=1){
        if ( !empty($id) ){
            $this->{Inflector::singularize($this->name)}->updateAll(
                                    array('Menu.enable'=>$active), 
                                    array('Menu.id'=>$id)
                                );
            $this->redirect(array('action' => 'index'), null, true);
        }
    }
    
    /*  function to move down menu position
     *  param: id is menu id, delta is number of how many positions the node should be moved down
     */
    function movedown($id = null, $delta = null) {
        $modelName = Inflector::singularize($this->name);
        
        if (empty($id)) {
            $this->Session->setFlash('Menu not found');
            $this->redirect(array('action' => 'index'), null, true);
        } else {
            
            $this->$modelName->id = $id;
            if ($delta > 0) {  
                $this->$modelName->moveDown($this->$modelName->id, abs($delta));
            } else {
                $this->Session->setFlash('Please provide the number of positions the field should be moved down.'); 
            }
        
            $this->redirect(array('action' => 'index'), null, true);
            
        }
    }
    
    /*  function to move up menu position
     *  param: id is menu id, delta is number of how many positions the node should be moved up
     */
    function moveup($id = null, $delta = null){
        $modelName = Inflector::singularize($this->name);
        
        if (empty($id)) {
            $this->Session->setFlash('Menu not found');
            $this->redirect(array('action' => 'index'), null, true);
        } else {
            
            $this->$modelName->id = $id;
            if ($delta > 0) {  
                $this->$modelName->moveup($this->$modelName->id, abs($delta));
            } else {
                $this->Session->setFlash('Please provide a number of positions the category should be moved up.'); 
            }

        
            $this->redirect(array('action' => 'index'), null, true);
            
        }
        
    }

    /* function to check if current menu has child or not.
     * params: current element menu in array menus
     * return: boolean
     */
    function __hasChild( &$child ) {
        if ( $child && count($child) > 0 ) {
            return true;
        }
        return false;
    }
    
    
    function __generateMenuAdmin() {
        $menus = $this->Menu->findAllThreaded("Menu.enable = 1", array('id', 'name', 'url', 'parent_id'), "lft");

        if ( $menus && count( $menus ) > 0 ) {
            $list_menus = "<ul class='sf-menu'>";

            foreach ( $menus as $menu ) {                    
                // if current top menu has children
                if ( $this->__hasChild( &$menu['children'] ) ) {
                    // 1st li or top parent
                    $list_menus .= "<li class='current'><a href='" . Helper::url($menu['Menu']['url']) ."' title='" . $menu['Menu']['name'] . "'>" . $menu['Menu']['name'] . "</a>";
                    $this->__generateChildMenuAdmin( &$menu['children'], &$list_menus );
                } else {
                    $list_menus .= "<li><a href='" . Helper::url($menu['Menu']['url']) ."' title='" . $menu['Menu']['name'] . "'>" . $menu['Menu']['name'] . "</a>";
                }

                $list_menus .= "</li>";
            }

            
            $list_menus .= "</ul>";
            $list_menus .= "</li>";

            return $list_menus . "</ul>";
        }

    }
    
    function __generateChildMenuAdmin( &$menus, &$list_menus ) {
        $list_menus .= "<ul>";
        foreach ( $menus as $menu ) {   
            // if child has children, iterate its childs!!
            if ( $this->__hasChild( &$menu['children'] ) ) {

                // first output its child parent
                $list_menus .= "<li class='current'><a href='" . Helper::url($menu['Menu']['url']) . "' title='" . $menu['Menu']['name'] . "'>" .
                               $menu['Menu']['name'] . "</a>";

                // generate again
                $this->__generateChildMenuAdmin( &$menu['children'], &$list_menus );

            } else {
                $list_menus .= "<li><a href='" . Helper::url($menu['Menu']['url']) . "' title='" . $menu['Menu']['name'] . "'>" .
                               $menu['Menu']['name'] . "</a>";
            }
            $list_menus .= "</li>";
        }

        $list_menus .= "</ul>";
    }
    
    function __generateMenu() {
        $menus = $this->Menu->findAllThreaded("Menu.enable = 1", array('id', 'name', 'url', 'parent_id'), "lft");
        $this->loadModel('GroupsMenu');
        $groupmenu = $this->GroupsMenu->find('list', array( 'conditions'=>array('group_id'=>$this->getGroupId()), 
                                                            'fields'=>array('menu_id','group_id')));

        if ( $menus && count( $menus ) > 0 ) {
            $list_menus = "<ul class='sf-menu'>";

            foreach ( $menus as $menu ) {
                // only write menu for user group
                if ( isset($groupmenu[$menu['Menu']['id']]) ){
                    
                    // if current top menu has children
                    if ( $this->__hasChild( &$menu['children'] ) ) {
                        // 1st li or top parent
                        $list_menus .= "<li class='current'><a href='" . Helper::url($menu['Menu']['url']) ."' title='" . $menu['Menu']['name'] . "'>" . $menu['Menu']['name'] . "</a>";
                        $this->__generateChildMenu( &$menu['children'], &$list_menus, $groupmenu );
                    } else {
                        $list_menus .= "<li><a href='" . Helper::url($menu['Menu']['url']) ."' title='" . $menu['Menu']['name'] . "'>" . $menu['Menu']['name'] . "</a>";
                    }

                    $list_menus .= "</li>";
                    
                }
            }

            
            $list_menus .= "</ul>";
            $list_menus .= "</li>";

            return $list_menus . "</ul>";
        }

    }

    function __generateChildMenu( &$menus, &$list_menus, $groupmenu ) {
        $list_menus .= "<ul>";
        foreach ( $menus as $menu ) {            
            // only write menu for user group
            if ( isset($groupmenu[$menu['Menu']['id']]) ){

                // if child has children, iterate its childs!!
                if ( $this->__hasChild( &$menu['children'] ) ) {

                    // first output its child parent
                    $list_menus .= "<li class='current'><a href='" . Helper::url($menu['Menu']['url']) . "' title='" . $menu['Menu']['name'] . "'>" .
                                   $menu['Menu']['name'] . "</a>";

                    // generate again
                    $this->__generateChildMenu( &$menu['children'], &$list_menus, $groupmenu );

                } else {
                    $list_menus .= "<li><a href='" . Helper::url($menu['Menu']['url']) . "' title='" . $menu['Menu']['name'] . "'>" .
                                   $menu['Menu']['name'] . "</a>";
                }
                $list_menus .= "</li>";
                
            }
        }

        $list_menus .= "</ul>";
    }
    
    function show_menus() {
        if ( isset($this->params['requested']) ) {
            if ( $this->getGroupId() != '1' ){
                return $this->__generateMenu();
            } else {
                return $this->__generateMenuAdmin();
            }
        }
        return false;
    }    
}
?>