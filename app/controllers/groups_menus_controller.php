<?php
class GroupsMenusController extends AppController{
    var $name = 'GroupsMenus';
    var $components = array('ControllerList');
    
    function index(){
        $this->set('records', $this->paginate('Group'));
    }
    
    function edit($gid=null){
        $modelName = Inflector::singularize($this->name);
        if ( empty($this->data) ){
            $group = $this->$modelName->Group->find('first', array(
                                                            'conditions'=>array('Group.id'=>$gid),
                                                            'fields'=>array('Group.id','Group.name')
                                                        ));
            $groupmenu = $this->$modelName->find('list', array(
                                                            'conditions'=>array($modelName.'.group_id'=>$gid),
                                                            'fields'=>array('menu_id','group_id')
                                                        ));
            $listMenus = $this->$modelName->Menu->find('list', array(
                                                            'fields'=>array('id','url')
                                                        ));

            $menus = $this->$modelName->Menu->generatetreelist(null, '{n}.Menu.id', '{n}.Menu.name', '--');
            $this->set('menus', $menus);
            $this->set('listMenus', $listMenus);
            $this->set('groupmenu', $groupmenu);
            $this->set('group', $group);
        } else {
            $aroId = $this->$modelName->getAroId($gid, 'Group');
            $this->loadModel('ArosAco');

            foreach ( $this->data[$modelName] as $key => $val ){
                if ( $val['url']!='/' && ($val['check']==1 || isset($val['existed'])) ){
                    $path = explode('/', $val['url']);
                    $acoAlias = '';

                    if ( $this->ControllerList->isController(Inflector::camelize($path[1])) ){
                        $acoAlias = Inflector::camelize($path[1]);
                    } elseif ( $this->ControllerList->isPluginController($path[1], Inflector::camelize($path[2])) ){
                        $acoAlias = Inflector::camelize($path[2]);
                    }

                    $data = array();
                    $acoId = $this->$modelName->getAcoId($acoAlias);

                    if ( $val['check']==1 && !isset($val['existed']) ){
                        $data['ArosAco']['aro_id'] = $aroId;
                        $data['ArosAco']['aco_id'] = $acoId;
                        $data['ArosAco']['_create'] = 1;
                        $data['ArosAco']['_read'] = 1;
                        $data['ArosAco']['_update'] = 1;
                        $data['ArosAco']['_delete'] = 1;

                        $this->ArosAco->create();
                        $this->ArosAco->save($data);
                    } elseif ( $val['check']==0 && isset($val['existed']) ){
                        $data['ArosAco.aro_id'] = $aroId;
                        $data['ArosAco.aco_id'] = $acoId;
                        $data['ArosAco._create'] = -1;
                        $data['ArosAco._read'] = -1;
                        $data['ArosAco._update'] = -1;
                        $data['ArosAco._delete'] = -1;
                        
                        $this->ArosAco->updateAll($data, array('ArosAco.aro_id'=>$aroId, 'ArosAco.aco_id'=>$acoId));
                    }
                }
            }

            if( $this->$modelName->saveData($this->data[$modelName], $gid) ) {
                $this->Session->setFlash(__($modelName . ' has been saved', true), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__($modelName . ' could not be saved.', true), 'error');
                $this->redirect(array('action' => 'edit/'.$gid));
            }
            
        }
    }
}
?>