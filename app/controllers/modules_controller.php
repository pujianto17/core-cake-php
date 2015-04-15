<?php
class ModulesController extends AppController{
    var $name = 'Modules';
    var $uses = array('ArosAco','Group');
    var $components = array('ControllerList');
    
    function index(){
        
        //dari croogo acl_permissions
        $acoConditions = array(
            'parent_id !=' => null,
            'model' => null,
            'foreign_key' => null,
            'alias !=' => null,
        );
        $acos  = $this->Acl->Aco->generatetreelist($acoConditions, '{n}.Aco.id', '{n}.Aco.alias');
        $groups = $this->Group->find('list');
        $this->set(compact('acos', 'groups'));

        $groupsAros = $this->Acl->Aro->find('all', array(
            'conditions' => array(
                'Aro.model' => 'Group',
                'Aro.foreign_key' => array_keys($groups),
            ),
        ));
        $groupsAros = Set::combine($groupsAros, '{n}.Aro.foreign_key', '{n}.Aro.id');

        $permissions = array(); // acoId => groupId => bool
        $this->loadModel('ArosAco');
        foreach ($acos AS $acoId => $acoAlias) {
            if (substr_count($acoAlias, '_') == 0) {
                $permission = array();
                foreach ($groups AS $groupId => $groupName) {
                    $hasAny = array(
                        'aco_id'  => $acoId,
                        'aro_id'  => $groupsAros[$groupId],
                        '_create' => 1,
                        '_read'   => 1,
                        '_update' => 1,
                        '_delete' => 1,
                    );
                    if ($this->ArosAco->hasAny($hasAny)) {
                        $permission[$groupId] = 1;
                    } else {
                        $permission[$groupId] = 0;
                    }
                    $permissions[$acoId] = $permission;
                }
            }
        }
        $this->set(compact('groupsAros', 'permissions'));
        
    }
    
    function generate(){
        $aco =& $this->Acl->Aco;
        $root = $aco->node('controllers');
        if (!$root) {
            $aco->create(array(
                'parent_id' => null,
                'model' => null,
                'alias' => 'controllers',
            ));
            $root = $aco->save();
            $root['Aco']['id'] = $aco->id;
        } else {
            $root = $root[0];
        }

        $controllerPaths = $this->ControllerList->listControllers();
        foreach ($controllerPaths AS $controllerName => $controllerPath) {
            $controllerNode = $aco->node('controllers/'.$controllerName);
            if (!$controllerNode) {
                $aco->create(array(
                    'parent_id' => $root['Aco']['id'],
                    'model' => null,
                    'alias' => $controllerName,
                ));
                $controllerNode = $aco->save();
                $controllerNode['Aco']['id'] = $aco->id;
                $log[] = 'Created Aco node for '.$controllerName;
            } else {
                $controllerNode = $controllerNode[0];
            }

            $methods = $this->ControllerList->listActions($controllerName, $controllerPath);
            foreach ($methods AS $method) {
                $methodNode = $aco->node('controllers/'.$controllerName.'/'.$method);
                if (!$methodNode) {
                    $aco->create(array(
                        'parent_id' => $controllerNode['Aco']['id'],
                        'model' => null,
                        'alias' => $method,
                    ));
                    $methodNode = $aco->save();
                }
            }
        }

        if (isset($this->params['named']['permissions'])) {
            $this->redirect(array('action' => 'index'));
        } else {
            $this->redirect(array('action' => 'index'));
        }
    }
}
?>