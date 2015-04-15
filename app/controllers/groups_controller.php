<?php
class GroupsController extends AppController{
    var $name = 'Groups';
    
    function index(){
        $this->set('modelName', Inflector::singularize($this->name));
		$this->set('records', $this->paginate());
    }
    
    function add(){    
        $modelName = Inflector::singularize($this->name);
        if ( !empty($this->data) ){
            $this->$modelName->create();
            if($this->$modelName->save($this->data)) {
                $this->Session->setFlash(__($modelName . ' has been saved', true), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__($modelName . ' could not be saved.', true), 'error');
            }
        }
    }
    
    function edit($id=null){
        
        if ($id==1){
            $this->Session->setFlash('You can not change the group Administrator', 'error');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->__edit($id);
            if (empty($this->data)){
                $this->data = $this->{Inflector::singularize($this->name)}->read(null, $id);
            }
        }
        
    }
}
?>