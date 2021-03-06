<?php
class UsersController extends AppController{
    var $name = 'Users';
    var $components = array('Email');
    var $helpers = array('Time');
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','logout','mypassword','changeMypassword');
    }

    function login() {
        if ($this->Session->read('Auth.User')) {
            $this->Session->setFlash('You are logged in!', 'success');
            $this->redirect('/', null, false); 
        }
    }
     
    function logout() {
        $this->Session->setFlash('You are logged out!', 'success');
        $this->redirect($this->Auth->logout());
    }
    
    function mypassword(){
        $this->User->recursive = -1;
        
        if (!empty($this->data)) {
            $useroremail = $this->data['User']['useroremail'];
            if ($useroremail) {
                $user = $this->User->findByUsername($useroremail);
            }
            if (empty($user)) {
                $user = $this->User->findByEmail($useroremail);
            }
            
            if (!empty($user)) { // ok, login or email is ok
                $md5 = $user['User']['passwordchangecode'] = md5(time()*rand());
                if ($this->User->save($user)) {
                
                    // send a mail with code to change the pw
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = 'Your password';
                    $this->Email->replyTo = 'noreply@example.com';
                    $this->Email->from = 'Cake Test Account <noreply@example.com>';
                    $this->Email->sendAs = 'text';
                    $this->Email->charset = 'utf-8';
                    echo $body = "Please goto ".Configure::read('baseUrl')."/".BASE_URL."/users/changeMypassword/email:{$user['User']['email']}/code:{$md5}";
                     
                    if ($this->Email->send($body) ) {
                        $this->Session->setFlash(__('If data provided is correct, you should receive a mail with instructions to change your password...', true), 'warning');
                    } else {
                        $this->Session->setFlash(__('Failed to send a email to change your password. Please contact the administrator at xxx@xxx', true), 'error');
                    }
                } else {
                    $this->Session->setFlash(__('Failed to change your password. Please contact the administrator at xxx@xxx', true), 'error');
                }
            } else {
                $this->Session->setFlash(__('If data provided is correct, you should receive a mail with instructions to change your password...', true), 'warning');
            }
            $this->redirect('/');
        }
    }
    
    function changeMypassword() {
        if (!empty($this->data)) {
            $this->User->recursive = -1;
            
            if ($this->data['User']['password1'] == $this->data['User']['password2']){
                $user = $this->User->find("email = '".addslashes($this->data['User']['email'])."' AND passwordchangecode='".addslashes($this->data['User']['code'])."'");

                if (empty($user)) { // bad code or email
                    $this->Session->setFlash(__("Bad identification data!", true), 'error');
                } else {
                    $user['User']['password'] = $this->Auth->password($this->data['User']['password1']);
                    $user['User']['passwordchangecode'] = '';

                    if ($this->User->save($user)) {
                        $this->Session->setFlash("Your password is changed. Log in now!", 'success');
                        $this->redirect(array('action'=>'login'));
                    } else {
                        $this->Session->setFlash("Unable to change password", 'error');
                    }
                }

            } else {
                $this->Session->setFlash("New password and confirm password not Match", 'error');
            }
            
        }
        
        if (!empty($this->params['named']))
            $this->data['User'] = $this->params['named'];
    }
        
    function index(){        
		$this->set('users', $this->paginate());
    }
    
    function add(){    
        $modelName = Inflector::singularize($this->name);
        if ( !empty($this->data) ){
            if($this->User->save($this->data)) {
                $this->Session->setFlash(__('The User has been saved', 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__('The User could not be saved.', 'error'));
            }
        } else {
            $groups = $this->User->Group->find('list');
            $this->set('groups', $groups);
        }
    }
    
    function edit($id=null){
        $this->__edit($id);
        if (empty($this->data)){
            $this->data = $this->{Inflector::singularize($this->name)}->read(null, $id);
            $this->loadModel('Group');
            $groups = $this->Group->find('list', array('fields'=>array('id','name')));
            $this->set('groups', $groups);
        }
    }
    
    function view($id){
        if ( !empty($id) ){
            $this->data = $this->{Inflector::singularize($this->name)}->read(null, $id);
        }
    }
    
    function active($id, $active=1){
        if ( !empty($id) ){
            $this->{Inflector::singularize($this->name)}->updateAll(
                                    array('User.active'=>$active), 
                                    array('User.id'=>$id)
                                );
            $this->redirect(array('action' => 'index'), null, true);
        }
    }

}
?>