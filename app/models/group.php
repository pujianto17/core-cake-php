<?php
class Group extends Model{
    var $name = 'Group';
    var $actsAs = array('Acl' => array('type' => 'requester'));
 
    function parentNode() {
        return null;
    }
    
    function afterSave($created = null){
        if( $created ){
		    $this->id = $this->getLastInsertId();
		    // first create alias for the newly created Aro
		    $this->__createAroAlias();
		}
    }
    
    /**
     * Creates an alias for the newly created Aro record -- AclBehavior
     * does not create an alias automatically.
     *
     * @access private
     * @returns boolean TRUE if alias is successfully added to the recently
     *     created Aro node
     */
	function __createAroAlias()
	{
	    $aroId = $this->Aro->getLastInsertId();
		$this->Aro->create();
		$this->Aro->id = $aroId;
		if( $this->Aro->saveField('alias', $this->data['Group']['name'] ) ){
		    return TRUE;
		} else {
		    return FALSE;
		}
	}

}
?>