<?php
class HomesController extends AppController{
    var $name = 'Homes';
	public $helper = array ('Html','Form');
    //var $uses;
    
     function index(){        
		$this->set('users', $this->paginate());
		
    }
	
	function add(){
		//$petas = $this->loadModel('Petas');
		$modelName = Inflector::singularize ($this->name);
		echo $modelName;
		echo "<pre>";
		print_r ($this->data);
		echo "</pre>";
		
		if ( !empty($this->data) ){
		
            if($this->$modelName->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', 'success'));
				//$this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__('The User could not be saved.', 'error'));
            }
        } 
	}
}
?>