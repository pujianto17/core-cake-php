<?php
class AclFilterComponent extends Object {
/**
 * @param object $controller controller
 * @param array  $settings   settings
 */
    function initialize(&$controller, $settings = array()) {
        $this->controller =& $controller;
    }

/**
 * acl and auth
 *
 * @return void
 */
    function auth() {
        //Configure AuthComponent
        $this->controller->Auth->authorize = 'actions';
        $this->controller->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->controller->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->controller->Auth->loginRedirect = array('controller' => 'home', 'action' => 'index');        
        $this->controller->Auth->actionPath = 'controllers/';
        $this->controller->Auth->userScope = array('User.active' => '1');
        $this->controller->Auth->autoRedirect = false;
        
        if ($this->controller->Auth->user() &&
            $this->controller->Auth->user('group_id') == 1) {
            // Group: Admin
            $this->controller->Auth->allowedActions = array('*');
        } else {
            
            if ($this->controller->Auth->user()) {

                if ( ($this->controller->name=='Menus' && $this->controller->action=='show_menus') || 
                     ($this->controller->name=='Home' && $this->controller->action=='index') ){

                    // untuk menus->show_menus dan home diperbolehkan
                    $this->controller->Auth->allow();

                } else {
                    $groupId = $this->controller->Auth->user('group_id');
                    $thisControllerNode = $this->controller->Acl->Aco->node($this->controller->Auth->actionPath.$this->controller->name);
                    
                    if ($thisControllerNode) {
                        $thisControllerNode = $thisControllerNode['0'];

                        $aroCurrent = $this->controller->Acl->Aro->find('first', array(
                                                                        'conditions'=>array('model'=>'Group', 'foreign_key'=>$groupId)
                                                                    ));

                        $allowedActions = $this->controller->Acl->Aco->Permission->find('list', array(
                            'conditions' => array(
                                'Permission.aro_id' => $aroCurrent['Aro']['id'],
                                'Permission.aco_id' => $thisControllerNode['Aco']['id'],
                                'Permission._create' => 1,
                                'Permission._read' => 1,
                                'Permission._update' => 1,
                                'Permission._delete' => 1,
                            ),
                            'fields' => array(
                                'id',
                                'aco_id',
                            ),
                            'recursive' => '-1',
                        ));
                        
                        if ( isset($allowedActions) && !empty($allowedActions) ){
                            $this->controller->Auth->allow();
                        }                        
                    }
                    
                }

            } else {
                $this->controller->Auth->allowedActions = array('login'); // for before login
            }

        } // endif1
    }
}
?>