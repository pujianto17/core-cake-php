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
        <?php echo " :: Login"; ?>
	</title>
	<?php
		echo $html->meta('icon');
		echo $html->css('generic');
        echo $javascript->link('jquery-1.3.2');
		echo $scripts_for_layout;
        
        echo "<script type='text/javascript'>\n";
        echo "$(function(){\n";
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
</head>
<body>
	<div id="container">
		<div id="header">
            <h2><?php echo APPLICATION_NAME; ?></h2>
        </div>
		<div id="layout-head">
            <div id="line-head">
                <span id="clock"></span>
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

<script>
var timerID = null;
var timerRunning = false;

function showtime () {
        var now = new Date();
        var date = ((now.getDate() < 10) ? "0" : "") + now.getDate();
        var vmonth = now.getMonth()+1;
        var month = ((vmonth < 10) ? "0" : "") + vmonth;
        var year = now.getFullYear();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        var timeValue = date + "-" + month + "-" + year + " " + hours;
        
        timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
        timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
        $('#clock').html(timeValue);
        timerID = setTimeout("showtime()",1000);
        timerRunning = true;
}

$(document).ready(function(){
    showtime();
});

</script>