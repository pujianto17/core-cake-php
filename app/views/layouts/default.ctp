<?php
/* SVN FILE: $Id$ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo APPLICATION_NAME; ?>
        <?php echo " :: " . $title_for_layout; ?>
	</title>
	<?php
		echo $html->meta('icon');
		echo $html->css('generic');
		echo $html->css('superfish');
        echo $javascript->link('jquery-1.3.2');
        echo $javascript->link('hoverIntent');
        echo $javascript->link('superfish');
        echo $javascript->link('supersubs');
		echo $scripts_for_layout;
        
        echo "<script type='text/javascript'>\n";
        echo "$(function(){\n";
            if ( isset($form_js) && !empty($form_js) ) {
                echo $form_js;
            }
            if ($session->check('Message.flash')):
                echo "$(window).load(function(){" .
                     "setTimeout(function(){" .
                     "$('.flash_box').fadeOut('slow');" .
                     "}, 700);" .
                "});";
            endif;
        echo "\n});";
        echo "</script>";
	?>
    
    <script type="text/javascript">

		// initialise plugins
		jQuery(function(){
            $("ul.sf-menu").supersubs({ 
                minWidth:    15,   // minimum width of sub-menus in em units 
                maxWidth:    30,   // maximum width of sub-menus in em units 
                extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
                                   // due to slight rounding differences and font-family 
            }).superfish({
                delay:       1000,                            // one second delay on mouseout 
                animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
                speed:       'fast',                          // faster animation speed 
            });  // call supersubs first, then superfish, so that subs are 
                 // not display:none when measuring. Call before initialising 
                 // containing tabs for same reason. 
        
		});

    </script>
</head>
<body>
	<div id="container">
		<div id="header">
            <h2><?php echo APPLICATION_NAME; ?></h2>
        </div>
		<div id="layout-head">
            <?php echo $this->element('layout_head'); ?>
            <div id='layout-menu'>
            <?php echo $this->element('layout_menu'); ?>
            </div>
        </div>
		<div id="content">
			<?php 
                $session->flash();
                echo $session->flash('auth');
                echo $content_for_layout; 
            ?>
		</div>
        <div style="clear:both;"></div>
	</div>	
</body>
</html>