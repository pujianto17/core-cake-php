<?php 
class LetterInsController extends AppController{
	var $name = 'LetterIns';
	
	function index(){        
		$this->set('LetterIns', $this->paginate());
    }
	
	function view ($id=NULL){
		$this->LetterIn->id = $id;
		$this->set('LetterIns',$this->LetterIn->read());
	}
	
	function edit ($id=NULL){
        if(!$id){
            $this->Session->setFlash('Id ora ono');
            $this->redirect(array('action'=>'index'),null,TRUE);
        }
        if(empty($this->data)){
            $this->data = $this->LetterIn->find(array('LetterIn.id'=>$id));
        }
        else {
            if ($this->LetterIn->save($this->data)){
                $this->Session->setFlash('data udh ke update');
                $this->redirect(array('action'=>'index'));
            }else{
                $this->Session->setFlash('Data Gagal di update, cobal lagi');
            }
        }
        
    }
	
	function add(){
	$modelName = Inflector::singularize($this->name);
		if (!empty($this->data)){
			
			echo "<pre>";
				print_r ($this->data);
			echo "</pre>";
			exit();
			if ($this->LetterIn->save($this->data)){
				$this->Session->setFlash('LetterIn has been Added');
				//$this->redirect(array('action'=>'index'));
			}
		}/*else {
				$this->Session->setFlash('LetterIn has been Added');
				$this->redirect(array('action'=>'index'));
        }*/
		
		//echo $this->getUserId();
		$this->loadModel('Users');
		$users = $this->Users->find('all',array(
			'fields'=>array('Groups.alias','Groups.id'),
			'conditions' => array('Groups.id' => $this->getUserId()),
			'joins'=> array(
						  array(
							  'table'=>'groups',
							  'alias'=>'Groups',
							  'type'=>'RIGHT',
							  'conditions' => array(
								'Users.group_id'=>'Groups.id'
							  )
					  )
			)));
		$this->set('users',$users);
	}
}
?>