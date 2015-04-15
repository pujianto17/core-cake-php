<div id="line-head">
<?php 

    echo $html->link('Home','/') . " | ";
    echo $html->link('Logout','/users/logout') . " | ";
    echo "Logged as $authRealname | ";
    
?>
    <span id="clock"></span>
</div>

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