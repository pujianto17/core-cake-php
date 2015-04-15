<?php
Class DatepickerHelper extends Helper {
    var $helpers     = array('Html', 'Form');
    var $view        = '';
    var $packedPath   = 'packed/';

    function __construct() {
        //parent::__construct();
        $this->view =& ClassRegistry::getObject('view');
        $this->view->addScript($this->__scriptize('ui.core'));
        $this->view->addScript($this->__cssize('ui.core'));
        $this->view->addScript($this->__cssize('ui.theme'));
        $this->view->addScript($this->__scriptize('ui.datepicker'));
        $this->view->addScript($this->__cssize('ui.datepicker'));
        $this->view->addScript($this->__scriptize('ui.datetimepicker'));  
        $this->view->addScript($this->__scriptize('jquery.dynDateTime.pack'));
        $this->view->addScript($this->__scriptize('lang/calendar-en.pack'));
        $this->view->addScript($this->__cssize('calendar-blue'));
    }

    function loadScript ($scripts = null) {
        $this->__loadScript( $this->__scriptize($this->packedPath . $this->process($scripts)) );
    }

    function __loadScript( $scripts = null ) {
        if (empty($this->view)) {
            $this->view =& ClassRegistry::getObject('view');
        }

        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                $this->view->addScript($script);
            }
        } else if ( is_string($scripts) && !empty($scripts) ) {
            $this->view->addScript($scripts);
        }
    }

    function __scriptize( $fileName = '') {
        $fileName = str_replace('.js', '', $fileName);
        $url  = BASE_URL ? '/' . BASE_URL . '/' .  JS_URL . $fileName . '.js' : '/' . JS_URL . $fileName . '.js';
        $url  = '<script type="text/javascript" src="' . $url . '"></script>';

        return $url;
    }

    function __cssize( $fileName = '' ) {
        $fileName = str_replace('.js', '', $fileName);
        $css = BASE_URL ? '/' . BASE_URL . '/' .  CSS_URL . $fileName . '.css' : '/' . CSS_URL . $fileName . '.css';
        $css = "<link rel=\"stylesheet\" type=\"text/css\" href=\"$css\" />";

        return $css;
    }

     function generate( $param,$code,$size='',$readonly=false ) {
        if($param=="start"){
        	$default_time= date("d/m/Y");
        	$inputDate = $this->Form->input($code, array('div'=>false, 'label' => false,'class' => 'start_date', 'id' => $param.'Datepicker','readonly'=>$readonly));
        }else if($param=="end"){
            $inputDate = $this->Form->input($code, array('div'=>false, 'label' => false, 'class'=>'end_date', 'id' => $param.'Datepicker','readonly'=>$readonly));
        }
        return $this->output("<p>".$inputDate."</p>");
    }

    function timecreate( $param,$code,$size='',$readonly=false ) {
        if($param=="start"){
        $default_time= date("d/m/Y");
        $inputDate = $this->Form->input($code, array('div'=>false, 'label' => false,'class' => 'start_date', 'id' => $param.'Datepicker','readonly'=>$readonly));
        }else if($param=="end"){
            $inputDate = $this->Form->input($code, array('div'=>false, 'label' => false, 'class'=>'end_date', 'id' => $param.'Datepicker','readonly'=>$readonly));
        }
         $JSstart="\n<script type='text/javascript'>\n";
         $JSCal  ="$('#".$param."DateTimepicker,#".$param."DateTimepicker').datetimepicker({\n";
         $JSCal .="beforeShow: customRange,\n";
         $JSCal .="dateFormat: 'dd/mm/yy'\n";
         $JSCal .="});";
         $JSCal .="function customRange(input) {";
         $JSCal .="return {minDate: (input.id == 'endDatepicker' ? \n";
         $JSCal .="$('#".$param."Datepicker').datetimepicker('getDate') : null), \n";
         $JSCal .="maxDate: (input.id == 'startDatepicker' ? \n";
         $JSCal .="$('#endDatepicker').datetimepicker('getDate') : null)}; \n";
         $JSCal .="   } \n";
         $JSCal .="   });\n";
         $jsclose="</script>";
         /* kurang tutup javascript*/
        return $this->output("<p>".$inputDate.$JSstart.$JSCal.$jsclose."</p>");
    }

    function maketime($name, $size='', $readonly=false) {
        $inputDate = $this->Form->text($name, array('div'=>false, 'label' => false, 'class' => 'date',
                                                    'id' => $name,'size'=>$size, 'readonly'=>$readonly));
        $JSstart="\n<script type='text/javascript'>\n";
        $JSCal ="\n$('#".$name."').dynDateTime({
							showsTime: true,
							ifFormat: '%d/%m/%Y-%H:%M',
							daFormat: '%l;%M %p, %e %m,  %Y',
							align: 'Br',
							electric: false,
							singleClick: true
						});\n";
        $jsclose="</script>";
        return $this->output($inputDate.$JSstart.$JSCal.$jsclose);
    }

    function makeDateTime($name, $options=array()) {
		$ifFormat = '%d/%m/%Y-%H:%M';
		if(isset($options['ifFormat']) && $options['ifFormat']) {
			$ifFormat = $options['ifFormat'];
			unset($options['ifFormat']);
		}

		$daFormat = '%l;%M %p, %e %m,  %Y';
		if(isset($options['daFormat']) && $options['daFormat']) {
			$daFormat = $options['daFormat'];
			unset($options['daFormat']);
		}

		$align = 'Br';
		if(isset($options['align']) && $options['align']) {
			$align = $options['align'];
			unset($options['align']);
		}

		$electric = 'false';
		if(isset($options['electric']) && $options['electric']) {
			$electric = "'".$options['electric']."'";
			unset($options['electric']);
		}

		$singleClick = 'true';
		if(isset($options['singleClick']) && $options['singleClick']) {
			$singleClick = "'".$options['singleClick']."'";
			unset($options['singleClick']);
		}

        $dateStatusFunc = 'false';
        if(isset($options['dateStatusFunc']) && $options['dateStatusFunc']){
            $dateStatusFunc = $options['dateStatusFunc'];
        }

        $JSstart="<script type='text/javascript'>";
        $JSCal ="\n$('#".$name."').dynDateTime({
				showsTime: true,
				ifFormat: '".$ifFormat."',
				daFormat: '".$daFormat."',
				align: '".$align."',
				electric: ".$electric.",
				singleClick: ".$singleClick.",
                dateStatusFunc: ".$dateStatusFunc."
				});\n";
        $jsclose="</script>";
		$default = array('div'=>false, 'label' => false, 'class' => 'date', 'id' => $name);
		$newOptions = array_merge($default, $options);
        $inputDate = $this->Form->text($name, $newOptions);

        return $this->output($inputDate.$JSstart.$JSCal.$jsclose);
    }

    /**
     * Desc : Create datepicker input type
     * @return output HTML
     * @param object $name
     * @param object $options[optional]
     * $options['dateFormat']        : used to format the displayed date
     * $options['minDate']           : used to restrict min date range / sample : minDate: -20
     * $options['maxDate']           : used to restrict max date range / sample " maxDate: '+1M +10D'
     *                                 (use 'D' for days, 'W' for weeks, 'M' for months, or 'Y' for years)
     * $options['showButtonPanel']   : used to show button panel / Bolean
     * $options['changeMonth']       : used to show Month select / Bolean
     * $options['changeYear']        : used to show Year select / Bolean
     * $options['numberOfMonths']    : used to show multiple month / integer
     */
    function make($name, $options=array()) {
        $JSstart="<script type='text/javascript'>\n";
        $JSCal  ="$(document).ready(function(){\n";

        // add previous value if exist
        if(!empty($this->params['url']['data'][$name])) {
        	$JSCal  .="$('#".$name."').val('".$this->params['url']['data'][$name]."');\n";
        }

        $JSCal .="    $('#".$name."').datepicker({\n";

        if( isset($options['dateFormat']) ) {
            $JSCal .="        dateFormat: '".$options['dateFormat']."', \n";
            unset($options['dateFormat']);
        } else {
            $JSCal .="        dateFormat: 'dd/mm/yy', \n";
        }

        if( isset($options['minDate']) ) {
            $JSCal .="        minDate: '".$options['minDate']."', \n";
            unset($options['minDate']);
        }

        if( isset($options['maxDate']) ) {
            $JSCal .="        maxDate: '".$options['maxDate']."', \n";
            unset($options['maxDate']);
        }

        if( isset($options['showButtonPanel']) ) {
            $JSCal .="        showButtonPanel: '".$options['showButtonPanel']."', \n";
            unset($options['showButtonPanel']);
        }

        if( isset($options['changeMonth']) ) {
            $JSCal .="        changeMonth: '".$options['changeMonth']."', \n";
            unset($options['changeMonth']);
        }

        if( isset($options['changeYear']) ) {
            $JSCal .="        changeYear: '".$options['changeYear']."', \n";
            unset($options['changeYear']);
        }

        if( isset($options['numberOfMonths']) ) {
            $JSCal .="        numberOfMonths: '".$options['numberOfMonths']."', \n";
            unset($options['numberOfMonths']);
        }

        $JSCal .="    });\n";
        $JSCal .="});\n";
        $jsclose="</script>";
        $default = array('div'=>false, 'label' => false, 'class' => 'date', 'id' => $name);
        $newOptions = array_merge($default, $options);
        $inputDate = $this->Form->text($name, $newOptions);

        return $this->output($inputDate.$JSstart.$JSCal.$jsclose);
    }
}
?>