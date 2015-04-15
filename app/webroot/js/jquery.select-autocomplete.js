jQuery.fn.select_autocomplete = function() {
  return this.each(function(){
    if (this.tagName.toLowerCase() != 'select') { return; }

    //stick each of it's options in to an items array of objects with name and value attributes
    var id=this.id;
    var name=this.name;
    var classSelect=$(this).attr('class');
    var readonlySelect=$(this).attr('readOnly');
    var disabledSelect=$(this).attr('disabled');
    var onBlurSelect=$(this).attr('onBlur');
    
    if ($(this).attr('must_match')=='must_match') {
		var must_match = false;
	} else {
		var must_match = true;
	}
    
    
    var select = this;
    var items = [];
    $(select).children('option').each(function(){
      var item = $(this);
      if (item.val() != '') //ignore empty value options
      {
        var name = item.html();
        var value = item.val();
        items.push( {'name':name, 'value':value} );
      }
    });

    //make a new input box next to the select list
	var attrReadonly = "";
	var attrDisabled = "";
	if(readonlySelect)
		attrReadonly = " readonly=readonly ";
	if(disabledSelect)
		attrDisabled = " disabled=disabled ";
		
    var input = $("<input type='text' id='_"+id+"_' class='"+classSelect+"' "+attrReadonly+attrDisabled+" onBlur='"+onBlurSelect+"' />").appendTo('body');
    $(select).before(input);

    //make the input box into an autocomplete for the select items
    $(input).autocomplete(items, {
      data: items,
      minChars: 0,
      maxwidth: 310,
      matchContains: true,
      autoFill: false,
      mustMatch: must_match,
      max: 100,
      formatItem: function(row, i, max) {
        return row.name;
      },
      formatMatch: function(row, i, max) {
        return row.name;
      },
      formatResult: function(row) {
        return row.name;
      },
    });

    //make the result handler set the selected item in the select list
    $(input).result(function(event, selected_item, formatted) {
      var to_be_selected = $(select).find("option[value=" + selected_item.value + "]")[0];
      $(to_be_selected).attr('selected', true);
      $(this).blur();
    });
	
    //set the initial text value of the autocomplete input box to the text node of the selected item in the select control
    $(input).val($(select).find(':selected').text());

    //normally, you'd hide the select list but we won't for this demo
    $(select).hide();
    
    //delete select class
    $(input).removeClass('required');
  });
};
