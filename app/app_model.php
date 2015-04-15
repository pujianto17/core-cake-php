<?php
/* SVN FILE: $Id: app_model.php 6311 2008-01-02 06:33:52Z phpnut $ */

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package		cake
 * @subpackage	cake.app
 */
class AppModel extends Model{
    
    function checkByField() {
        // Get the name of the table
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $tableName = $db->fullTableName($this, false);

        // cek if field created_by and modified_by is exists in current table
        $result = $this->query("SHOW COLUMNS FROM {$tableName} LIKE '%ed_by'");

        if ( isset( $result[0]['COLUMNS']['Type'] ) || isset( $result[0][0]['Type'] ) ) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Get Aco id
     *
     * @param string  $alias Alias name in acos table
     * @param string  $parent Parent's alias name in acos table, default is controllers
     * @return string
     */
    function getAcoId($alias=null, $parent='controllers'){
        $query = "SELECT Aco.id, Aco.alias FROM acos AS Aco
                  LEFT JOIN acos AS Aco0 ON (Aco0.id = Aco.parent_id)
                  WHERE Aco0.alias = '".$parent."' AND Aco.alias='".$alias."'";
        $aco = $this->query($query);
        
        return $aco[0]['Aco']['id'];
    }
    
    /**
     * Get Aro id
     *
     * @param string  $key Foreign key in aros table (group's id or user's id)
     * @param string  $model Model's name (Group or User), default is User
     * @return string
     */
    function getAroId($key=null, $model='User'){
        $query = "SELECT Aro.id FROM aros AS Aro
                  WHERE Aro.foreign_key = '".$key."' AND Aro.model='".$model."'";
        $aro = $this->query($query);
        
        return $aro[0]['Aro']['id'];
    }
    
}
?>