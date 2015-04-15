<?php
Class SelectAutocompleteHelper extends Helper {
    var $helpers     = array('Form');
    var $view        = '';

    function __construct() {
        $this->view =& ClassRegistry::getObject('view');
        $this->view->addScript($this->__scriptize('jquery.autocomplete'));
        $this->view->addScript($this->__scriptize('jquery.select-autocomplete'));
        $this->view->addScript($this->__cssize('jquery.autocomplete'));
        $this->view->addScript("<script type='text/javascript'>" .
                               "$(document).ready(function() {" .
                               "    $('select:not(.skip-autocomplete)').select_autocomplete();" .
                               "});</script>");
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

    /**
     * $params['datas'], $params['hidden'], $params['modelName'], $params['class'], $params['name']
     * $params['fields'] => [0] = value options
     *                      [1] = text options for first select
     *                      [2] = text options for second select
     * $param['id'] => [0] = id first select
     *                 [1] = id second select
     * $param['name'] => [0] = name first select
     *                   [1] = name second select
     */
    function makeTwoSelect( $params ) {

        $html = '';
        $opts = array();
        $opts[$params['fields'][1]][''] = $opts[$params['fields'][2]][''] = '';
        foreach($params['datas'] as $data) {
            $opts[$params['fields'][1]][$data[$params['modelName']][$params['fields'][0]]] = $data[$params['modelName']][$params['fields'][1]];
            $opts[$params['fields'][2]][$data[$params['modelName']][$params['fields'][0]]] = $data[$params['modelName']][$params['fields'][2]];
        }

        $options = array('div'=>false, 'label'=>false, 'class'=>'required',
                         'type'=>'select', 'name'=>'');
        if( isset($params['class']) ){ $options['class']=$params['class']; }
        if( isset($params['value']) ){ $options['value']=$params['value']; }

        $id_0 = $params['fields'][1];
        if( isset($params['id']) && isset($params['id'][0]) ){
            $id_0 = $params['id'][0];
        }
        $name_0 = $params['fields'][1];
        $options['name']='';
        if( isset($params['name']) && isset($params['name'][0]) ){
            $name_0 = $params['name'][0];
            unset($options['name']);
        }
        $options['id']      = $id_0;
        $options['options'] = $opts[$params['fields'][1]];
        $html .= $this->Form->input($name_0, $options) . "\n";

        $html .= '&nbsp;';

        $id_1 = $params['fields'][2];
        if( isset($params['id']) && isset($params['id'][1]) ){
            $id_1 = $params['id'][1];
        }
        $name_1 = $params['fields'][2];
        $options['name']='';
        if( isset($params['name']) && isset($params['name'][1]) ){
            $name_1 = $params['name'][1];
            unset($options['name']);
        }
        $options['id']      = $id_1;
        $options['options'] = $opts[$params['fields'][2]];
        $html .= $this->Form->input($name_1, $options) . "\n";

        $html .= $this->Form->input($params['hidden'], array('type'=>'hidden', 'id'=>$params['hidden']));
        $html .= $this->Form->error($params['hidden'], 'required');

        $html .= "<script type='text/javascript'>
                 $(function() {
                    $('#_".$id_0."_').blur(function(){
                        var to_be_selected = $('#" .$id_0. "').find('option[text=' + this.value + ']')[0];
                        $(to_be_selected).attr('selected', true);

                        var selectedOpt = $('#" .$id_1. "').find('option[value=' + $(to_be_selected).val() + ']')[0];
                        $(selectedOpt).attr('selected', true);
                        $('#_" .$id_1. "_').val($(selectedOpt).text());
                        $('#" .$params['hidden']. "').val($('#" .$id_0. " :selected').val());
                    });

                    $('#_" .$id_1. "_').blur(function(){
                        var to_be_selected = $('#" .$id_1. "').find('option[text=' + this.value + ']')[0];
                        $(to_be_selected).attr('selected', true);

                        var selectedOpt = $('#" .$id_0. "').find('option[value=' + $(to_be_selected).val() + ']')[0];
                        $(selectedOpt).attr('selected', true);
                        $('#_" .$id_0. "_').val($(selectedOpt).text());
                        $('#" .$params['hidden']. "').val($('#" .$id_1. " :selected').val());
                    });
                  });
                  </script>";
        return $this->output($html);
    }

    /**
     * $params['datas'], $params['modelName'], $params['class'], $params['name']
     * $params['fields'] => [0] = for value options
     *                      [1] = for text options
     */
    function makeSelect($params){
        $html = '';
        $opts = array();
        $opts[$params['fields'][1]][''] = '';
        if( isset($params['datas']) ){
            foreach($params['datas'] as $data) {
                $opts[$params['fields'][1]][$data[$params['modelName']][$params['fields'][0]]] = $data[$params['modelName']][$params['fields'][1]];
            }
        }
        
        if(empty($params['onBlur'])) {
            $params['onBlur'] = null;
        }
        
        if(empty($params['must_match'])) {
            $params['must_match'] = false;
        }
        
        $options = array('div'=>false, 'label'=>false,
                         'type'=>'select', 'options'=>$opts[$params['fields'][1]], 'onBlur'=>$params['onBlur'], 'must_match'=>$params['must_match'],
                         'id'=>$params['fields'][1]);

        if( isset($params['class']) ){ $options['class']=$params['class']; };

        if( isset($params['name']) && $params['name'] ){
            $name=$params['name'];
        } else {
            $name='';
            $options['name']='';
        }
        
        if(substr($name,0,4)=='data') {
            $options['name']=$name;    
        }
        
        if( isset($params['value']) ){ $options['value']=$params['value']; }
        if( isset($params['id']) ){ $options['id']=$params['id']; }
        if( isset($params['readonly']) ){ $options['readonly']=$params['readonly']; }
        if( isset($params['disabled']) ){ $options['disabled']=$params['disabled']; }
        $html .= $this->Form->input($name, $options) . "\n";

        $html .= $this->Form->error($name, 'required');
        return $this->output($html);
    }
}
?>
