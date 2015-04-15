<?php
class ChangePasswordsController extends AppController{
    var $name = 'ChangePasswords';
    var $uses = array('User');
    
    function index(){
        if ( empty($this->data) ){
            $id = $this->getUserId();
            $this->data = $this->User->read(null, $id);
        } else {
            $this->User->recursive = -1;
            $old_pass = $this->User->find('first', array(
                                                'conditions'=>array('id'=>$this->getUserId()),
                                                'fields'=>array('id','username','password')
                                            ));

            if ( $this->Auth->password($this->data['ChangePassword']['old_password']) == $old_pass['User']['password']){
                if ($this->data['ChangePassword']['new_password'] == $this->data['ChangePassword']['confirm_password']){
                    $data = array();
                    $data['User']['id'] = $this->getUserId();
                    $data['User']['password'] = $this->Auth->password($this->data['ChangePassword']['new_password']);
                    unset($this->data['ChangePassword']);

                    if ($this->User->save($data)) {
                        $this->flash("Password updated <br /> You are logged out and You have to login now", '/users/logout', 5);
                    } else {
                        $this->Session->setFlash("Unable to update Password", 'error');
                        $this->redirect(array('action' => 'index'));
                    }         
                }else{
                    $this->Session->setFlash("New password and confirm password not Match", 'error');
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->Session->setFlash("Old Password not Match", 'error');
                $this->redirect(array('action' => 'index'));
            }
            
        }
    }
}
?>