function go2URL(address,target){
    window.open(address,target);
}

function newWindow(address){
    var maxW = screen.width;
    var maxH = screen.height;
    var w = 800;
    var h = 600;
    var _top = Math.floor((maxH - h) / 2);
    var _left = Math.floor((maxW - w) / 2);

    var win = window.open(address,'doiW',"toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,copyhistory=yes,width="+w+",height="+h);
    win.moveTo(_left,_top);
    win.focus();
}

function isInt(v){
    return (parseInt(v) == v);
}

function detectNum(e){
   var nv='';
   var pt=false;
   for (x=0; x<e.value.length; x++)
   {
     c = e.value.substring(x,x+1);
     if (isInt(c) || ((c == '.') && (pt == false)) || ((x == 0) && (c == '-')))
   {
   nv += c;
   if (c == '.') { pt=true; }
   }
  }
   e.value = nv;
}

function isInteger(num){
 return (!isNaN(num) && num%1==0);
}

/**
 * Check whether number or not from pressing keyboard
 *
 * @author  Arief Sofyan
 * @date    11.10.2008 09:11:12
 * @param   event
 * @use     onkeyup="javascript:return numberOnly(event);"
 */
function numberOnly(e) {
    var keycode;

    if (window.event) keycode = window.event.keyCode;
      else if (e) keycode = e.which;

    // 48..57  => 0..9
    // 8       => Backspace
    // 190     => . (for decimal)
    // 37..40  => Arrow Key
    // 9       => Tab
    // 46      => Del
    // 96..105 => (NumPad) 0..9
    // 110     => (NumPad) . (for decimal)
    // 109     => -

    if ((keycode >= 48 && keycode <= 57) ||
        (keycode >= 37 && keycode <= 40) ||
        (keycode >= 96 && keycode <= 105) ||
         keycode==8 || keycode==190 ||
         keycode==9 || keycode==110 ||
         keycode==46 || keycode==109 ) {
      return true;
    } else {
      return false;
    }
}

function checkAllByPrefix(items, objCheckBox, checkBoxPrefix) {
/**
 * REMEMBER THAT :
 *    objCheckBox refers to checkBox with caption "CHECK ALL" or "CANCEL ALL"
 */
var state = (objCheckBox.checked) ? true : false;

for (n=1; n <= items; n++)
  if (document.getElementById(checkBoxPrefix + n))
    document.getElementById(checkBoxPrefix + n).checked = state;
}

function getNextElementId(what, parentNode, tagName) {
    var element        = document.getElementById(parentNode);
    var startToProcess = false;

    for (i = 0; i < element.childNodes.length; i++) {
        if (element.childNodes[i].tagName==tagName) {
            if (startToProcess) return element.childNodes[i].getAttribute('id');
            if (element.childNodes[i].getAttribute('id')==what) startToProcess = true;
        }
    }

    return '';
}

function thisIdHasSub(candID, list) {
  var nextID  = getNextElementId(candID, 'maincontent'+list, 'tr');

  if (nextID.indexOf('sub') != -1) {
    return true;
  } else {
    return false;
  }
}

function clearAllSub(candID) {
  var i = 1;
  var sequence = 0;
  while (i < 566) {
    if (document.getElementById(candID + '_sub' + i)) {
      document.getElementById('maincontent').removeChild(document.getElementById(candID + '_sub' + i));
      i++;
    } else {
      i = 566;
    }
  }
}

/**
 *  rowPrefix => prefix dari id <tr>
 *  checkBoxPrefix => prefix dari checkBox yang d gunakan
 *  item => nama var item pada fungsi AddItem
 *  list => prefix dari maincontent -> <tbody id="maincontent">
 */
function removeRowsByCheckedBox(items, rowPrefix, checkBoxPrefix, list) {
    var result = true;
    if(!list)
        list='';

    for (n=1; n<=items; n++) {
      if (document.getElementById(rowPrefix + n)) {
        if (document.getElementById(checkBoxPrefix + n).checked==true) {
          // Clear Sub if there is
          if (thisIdHasSub(rowPrefix + n, list)) clearAllSub(rowPrefix + n, list);

          document.getElementById(rowPrefix + n).parentNode.removeChild(document.getElementById(rowPrefix + n));

          //for (var idx in textBoxID[tp1.getSelectedIndex()])
          //  if (textBoxID[tp1.getSelectedIndex()][idx] == n) textBoxID[tp1.getSelectedIndex()].splice(idx,1);
        }
      }
    }
}

function removeRowsByCheckedBoxDefine(items, rowPrefix, checkBoxPrefix, list) {
    var cek = 0;
    for (n=1; n <= items; n++) {
        if (document.getElementById(rowPrefix + n)) {
            if (document.getElementById(checkBoxPrefix + n).checked==true) {
                cek++;
            }
        }
    }
    if(cek>0){
        if(confirm('Are you sure you want to delete?')){
            var result = true;
            if(!list)
                list='';

            for (n=1; n <= items; n++) {
              if (document.getElementById(rowPrefix + n)) {
                if (document.getElementById(checkBoxPrefix + n).checked==true) {
                  if (thisIdHasSub(rowPrefix + n, list)) clearAllSub(rowPrefix + n, list);
                    document.getElementById(rowPrefix + n).parentNode.removeChild(document.getElementById(rowPrefix + n));
                }
              }
            }
            document.getElementById(checkBoxPrefix + 'all').checked=false;
        }
    }
}

//+ Carlos R. L. Rodrigues
//@ http://jsfromhell.com/geral/event-listener [rev. #5]
/**
 * addEvent(object: Object, event: String, handler: Function(e: Event): Boolean, [scope: Object = object]): void
 * Adds an event listener to an object.
 *
 * removeEvent(object: Object, event: String, handler: function(e: Event): Boolean, [scope: Object = object]): Boolean
 * Removes a previously added listener from the object and returns true in case of success
 */
addEvent = function(o, e, f, s){
    var r = o[r = "_" + (e = "on" + e)] = o[r] || (o[e] ? [[o[e], o]] : []), a, c, d;
    r[r.length] = [f, s || o], o[e] = function(e){
        try{
            (e = e || event).preventDefault || (e.preventDefault = function(){e.returnValue = false;});
            e.stopPropagation || (e.stopPropagation = function(){e.cancelBubble = true;});
            e.target || (e.target = e.srcElement || null);
            e.key = (e.which + 1 || e.keyCode + 1) - 1 || 0;
        }catch(f){}
        for(d = 1, f = r.length; f; r[--f] && (a = r[f][0], o = r[f][1], a.call ? c = a.call(o, e) : (o._ = a, c = o._(e), o._ = null), d &= c !== false));
        return e = null, !!d;
    }
};

removeEvent = function(o, e, f, s){
    for(var i = (e = o["_on" + e] || []).length; i;)
        if(e[--i] && e[i][0] == f && (s || o) == e[i][1])
            return delete e[i];
    return false;
};

//+ Carlos R. L. Rodrigues
//@ http://jsfromhell.com/forms/format-currency [rev. #3]
/**
 * formatCurrency(field: HTMLInput, [floatPoint: Integer = 2], [thousandsSep: String = "."], [decimalSep: String = ","]): String
 * Formats the input making it assume the behaviour of a monetary field
 */
function formatCurrency(o, n, dig, dec){
    new function(c, dig, dec, m){
        addEvent(o, "keypress", function(e, _){
            if((_ = e.key == 45) || e.key > 47 && e.key < 58){
                var o = this, d = 0, n, s, h = o.value.charAt(0) == "-" ? "-" : "",
                    l = (s = (o.value.replace(/^(-?)0+/g, "$1") + String.fromCharCode(e.key)).replace(/\D/g, "")).length;
                m + 1 && (o.maxLength = m + (d = o.value.length - l + 1));
                if(m + 1 && l >= m && !_) return false;
                l <= (n = c) && (s = new Array(n - l + 2).join("0") + s);
                for(var i = (l = (s = s.split("")).length) - n; (i -= 3) > 0; s[i - 1] += dig);
                n && n < l && (s[l - ++n] += dec);
                _ ? h ? m + 1 && (o.maxLength = m + d) : s[0] = "-" + s[0] : s[0] = h + s[0];
                o.value = s.join("");
            }
            e.key > 30 && e.preventDefault();
        });
    }(!isNaN(n) ? Math.abs(n) : 2, typeof dig != "string" ? "." : dig, typeof dec != "string" ? "," : dec, o.maxLength);
}

//+ Jonas Raoni Soares Silva
//@ http://jsfromhell.com/number/fmt-money [rev. #2]
/**
 * Number.formatMoney([floatPoint: Integer = 2], [decimalSep: String = ","], [thousandsSep: String = "."]): String
 * Returns the number into the monetary format.
 */
Number.prototype.formatMoney = function(c, d, t){
    var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t)
    + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function formatAsMoney(mnt) {
    mnt -= 0;
    mnt = (Math.round(mnt*100))/100;
    return (mnt == Math.floor(mnt)) ? mnt + '.00'
              : ( (mnt*10 == Math.floor(mnt*10)) ?
                       mnt + '0' : mnt);
};

/**
 * Desc : function to cek digit
 * @param {Object} obj
 */
function cekDigitContainer(obj) {
    var noCont = obj.value;
    var lenNoCont = noCont.length * 1;
    var mcekd = noCont.substr((lenNoCont - 1), 1);
    var result = 0;
    var prefCont = noCont.substr(0, 4);
    var strToBeCheck = noCont.substr(0, 10);

    //if( prefCont.toUpperCase() == 'HLCU' ) {
    //    result = cekDigitHlcu( strToBeCheck );
    //} else {
        result = __cekDigit( strToBeCheck );
    //}

    if( result.toString() == mcekd ) {
        return true;
    } else {
        return false;
    }
}

/**
 * desc : cek digit container in international rules
 * @param {Object} data
 */
function __cekDigit( data ) {
    var anilai = new Array();

    for (var x=1; x<11; x++ ) {
        if( x==1) {
            anilai[x] = 1;
        } else if( x==2 ){
            anilai[x] = anilai[x-1] + 1;
        } else {
            anilai[x] = anilai[x-1] * 2;
        }
    }

    var jmd = 0;
    for( var j=1; j<11; j++ ) {
        var cutCekData = data.substr(j-1, 1);
        var cekData = cutCekData.toUpperCase();
        var y = 0;

        switch (cekData) {
            case "A":
                y=10;
                break;
            case "B":
                y=12;
                break;
            case "C":
                y=13;
                break;
            case "D":
                y=14;
                break;
            case "E":
                y=15;
                break;
            case "F":
                y=16;
                break;
            case "G":
                y=17;
                break;
            case "H":
                y=18;
                break;
            case "I":
                y=19;
                break;
            case "J":
                y=20;
                break;
            case "K":
                y=21;
                break;
            case "L":
                y=23;
                break;
            case "M":
                y=24;
                break;
            case "N":
                y=25;
                break;
            case "O":
                y=26;
                break;
            case "P":
                y=27;
                break;
            case "Q":
                y=28;
                break;
            case "R":
                y=29;
                break;
            case "S":
                y=30;
                break;
            case "T":
                y=31;
                break;
            case "U":
                y=32;
                break;
            case "V":
                y=34;
                break;
            case "W":
                y=35;
                break;
            case "X":
                y=36;
                break;
            case "Y":
                y=37;
                break;
            case "Z":
                y=38;
                break;
            case "0":
            case "1":
            case "2":
            case "3":
            case "4":
            case "5":
            case "6":
            case "7":
            case "8":
            case "9":
                y=cekData;
                break;
           default:
               y=0;
        }
        jmd = jmd + y * anilai[j];
    }

    var result = jmd - Math.floor(jmd / 11) * 11;
    if( result == 10) {
        result = 0;
    }
    return result;
}

/**
 * desc : Number format from pressing keyboard
 *          (,) is separator, (.) is decimal
 * 
 * @author  Argyaputri
 * @date    01 March 2010 5:55 PM
 * @param   {Object} obj
 * @use     onkeyup="javascript: numberFormat(this);"
 */
function numberFormat(obj) {
   var a = obj.value;
   b = a.replace(/[^\d+\..]/g,"");   
   dtNumber = b.split('.');
   numberInt = dtNumber[0];
   numberVal = "";
   intLength = numberInt.length;
   j = 0;
   
   if (dtNumber.length==1){
       numberDec="";
   }else{
        numberDec=".";
   }
   
   for (n=1; n<dtNumber.length; n++){
      numberDec += dtNumber[n];
   }
   
   for (i = intLength; i > 0; i--) {
     j = j + 1;
     if (((j % 3) == 1) && (j != 1)) {
       numberVal = numberInt.substr(i-1,1) + "," + numberVal;
     } else {
       numberVal = numberInt.substr(i-1,1) + numberVal;
     }
   }
   
   obj.value = numberVal + numberDec;
}

/**
 *  Add by : d3m0n
 *  date   : 15 Apr 2009
 *  disabled enter to all input in div with id trans-header
 */
$("#trans-header input").live("keypress", function (evt) {
    var flag = true;
    if (evt.which == null) {
        //var key = String.fromCharCode(evt.keyCode); // IE
        var key = evt.keyCode; // IE
    } else if ( evt.which > 0 ) {
        var key = evt.which; // All others
    }

    if (key == 13) { //enter button
        //alert('enter di header niyeeeeeeee');
        flag = false;
    }
    return flag;
});

/**
 *  Add by : d3m0n
 *  date   : 15 Apr 2009
 *  disabled enter to all input in div with id grid_detail
 *  and adding numlock plus for new line
 */
$('#grid_detail input').live("keypress", function(evt) {
    var flag = true;
    if (evt.which == null) {
        //var key = String.fromCharCode(evt.keyCode); // IE
        var key = evt.keyCode; // IE
    } else if ( evt.which > 0 ) {
        var key = evt.which; // All others
    }

    if (key==13) { //enter button
        //alert('enter di detail niyeeeeeeee');
        flag = false;
    } else
    if (key==43) { //numlock plus button
        if(cekDetails()){
            AddItem();
        };
        flag = false;
    }
    return flag;
});

/**
 * desc : NPWP format from pressing keyboard
 *        (nn.nnn.nnn.n-nnn.nnn) n=number
 * 
 * @author  Argyaputri
 * @date    12 April 2010 4:51 PM
 * @param   {Object} obj
 * @use     onkeyup="javascript: npwpFormat(this);"
 */
function npwpFormat(obj) {
   var a = obj.value;
   b = a.replace(/[^\d]/g,"");
   npwpVal = "";
   intLength = b.length;
   j = 0;

   for (i = 1; i <= intLength; i++) {
     if ( i==2 ){
         npwpVal = npwpVal + b.substr(i-1,1) + ".";
     } else if ( i==5 ){
         npwpVal = npwpVal + b.substr(i-1,1) + ".";
     } else if ( i==8 ) {
         npwpVal = npwpVal + b.substr(i-1,1) + ".";
     } else if ( i==9 ) {
         npwpVal = npwpVal + b.substr(i-1,1) + "-";
     } else if ( i==12 ) {
         npwpVal = npwpVal + b.substr(i-1,1) + ".";
     } else {
         npwpVal = npwpVal + b.substr(i-1,1);
     }
   }

   obj.value = npwpVal;
}