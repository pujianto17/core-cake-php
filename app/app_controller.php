<?php
/* SVN FILE: $Id: app_controller.php 6311 2008-01-02 06:33:52Z phpnut $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 6311 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2008-01-02 01:33:52 -0500 (Wed, 02 Jan 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		cake
 * @subpackage	cake.app
 */
class AppController extends Controller {
    var $components = array('Acl', 'Auth', 'Session', 'AclFilter');
    var $helpers    = array('Html', 'Form', 'Javascript');
    var $paginate   = array('limit' => MAX_ROWS, 'page' => 1);

    function beforeFilter() {
        $this->AclFilter->auth();
        $this->set('modelName', Inflector::singularize($this->name));

        if ($this->isLoggedIn()){
            $this->layout = 'default'; //set layout with menu
            $this->set('authRealname', $this->getRealname());
            
            $action = $this->params['action'];
            // form
            if ($action == 'add' || $action == 'edit') {
                // form client side scripting automated via jQuery
                $this->set('form_js', FORM_JS);

                // make sure created_by & modified by fields are filled, if table has that fields
                if ( !empty($this->data) ) {
                    if ( $this->{Inflector::singularize($this->name)}->checkByField() ) {
                        if ($action == 'add') {
                            $this->data[Inflector::singularize($this->name)]['created_by'] = $this->getLogin();
                        } else if ($action == 'edit') {
                            $this->data[Inflector::singularize($this->name)]['modified_by'] = $this->getLogin();
                        }
                    }
                }
            } else if ($action == 'index') { // usually tablegrid is found in index action
                //check all
                $tablegrid = "$('#checkall').click(function(){var state=this.checked; if(state){\n";
                $tablegrid .= "$(':checkbox').attr(\"checked\",\"checked\");}else{\n$(':checkbox').attr(\"checked\",\"\");}});";
                
                $this->set('form_js', $tablegrid);
            }
            
        } else {
            $this->layout = 'anonymous'; //set layout without menu
        }
    }
    
    function __authUser(){
        return $this->Auth->user();
    }
    
    function isLoggedIn() {
        return ($this->getUserId() !== null);
    }
    
    function getUserId(){
        return $this->Session->read('Auth.User.id');
    }
    
    function getLogin(){
        return $this->Session->read('Auth.User.username');
    }
    
    function getRealname(){
        return $this->Session->read('Auth.User.realname');
    }
    
    function getGroupId(){
        return $this->Session->read('Auth.User.group_id');
    }
    
    function __index(){
		$this->set('records', $this->paginate());
    }
    
    function __add(){    
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
    
    function __edit($id){
        $modelName = Inflector::singularize($this->name);
        if ( !empty($this->data) ){
            if($this->$modelName->save($this->data)) {
                $this->Session->setFlash(__($modelName . ' has been updated', true), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__($modelName . ' could not be updated.', true), 'error');
            }
        }
    }
    
    function delete($id = null) {
        if ($this->{Inflector::singularize($this->name)}->del($id)) {
            $this->Session->setFlash("Record deleted", 'success');
        } else {
            $this->Session->setFlash("Unable to delete record", 'error');
        }
        $this->redirect(array('action' => 'index'));
    }
    
    // delete rows in tablegrid by checked checkbox
    function delete_rows() {
        $this->layout   = 'ajax';
        $this->viewPath = 'common';

        if (!empty($this->data) ) {
            $count = 0;
            foreach ($this->data['rows'] as $row) {
                if ( $this->{Inflector::singularize($this->name)}->del($row) ) {
                    $count++;
                } else {
                    $s = ($count > 1) ? 's' : '';
                    $this->set('result', "Only $count records$s deleted");
                }
            }
            $this->set('result', "$count record$s successfully deleted.");
        } else {
            $this->set('result', "Error deleting");
        }
    }

}
?>