<?php 
class LetterIn extends AppModel{
	var $name = 'LetterIns' ;
	
	var $belongsTo = array(
	'Groups' => array(
		'fields'=>'alias',
		 'foreignKey' => false,
		'conditions'=>array('LetterIn.created_by = Groups.id'))
	);
}

?>