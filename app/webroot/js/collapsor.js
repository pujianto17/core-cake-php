$(document).ready(function() {
    $('tr div').collapsor({sublevelElement:'tr', speed: 200});
    
    $('table div.controller').click(function() {
        $('.controller-'+this.id).toggle();
            if ($(this).hasClass('expand')) {
                $(this).removeClass('expand');
                $(this).addClass('collapse');
                $('tr.hidden').filter('.controller-'+this.id).attr('style','display:atr-row');
            } else {
                $(this).removeClass('collapse');
                $(this).addClass('expand');
                $('tr.hidden').filter('.controller-'+this.id).attr('style','display:none');
            }
    }); 
    
    $('tr.hidden').attr('style','display:none');

	$('.toggle').click(function(){
		$('.hidden').toggle();
        $('table div.controller').each(function(){
            if ($(this).hasClass('expand')) {
                $(this).removeClass('expand');
                $(this).addClass('collapse');
            } else {
                $(this).removeClass('collapse');
                $(this).addClass('expand');
            }
        });
	});
});
