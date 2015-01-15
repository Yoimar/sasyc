<?php
/**
 * Description of FormMacros
 *
 * @author nadinarturo
 */
namespace Ayudantes\Macros;

class FormBuilder extends \Illuminate\Html\FormBuilder {

    function concurrencia($obj) {
        return \Form::hidden('version', Input::old('version', $obj->version));
    }
    
    public function btSelect($attrName, $values, $value, $numCols=12, $required = true) {
        $data['numCols'] = $numCols;
        $data['attrName'] = $attrName;
        $data['params']['class'] = 'form-control';
        $data['attrValue'] = $value;
        $data['params']['id'] = $attrName;
        $data['options'] = $values;
        if ($required) {
            $data['params']['required'] = 'true';
        }
        $data['inputType'] = "select";
        return \View::make('templates.bootstrap.input', $data);
    }

    function btInput($obj, $attrName, $numCols=12, $type = 'text'
    , $html = []) {
        $data['params'] = $html;
        $data['params']['class'] = '';
        $options = [];
        if ($obj->isRelatedField($attrName) && $type == "text") {
            $type = 'select';
            $options = $obj->getRelatedOptions($attrName);
        } else if ($obj->isDateField($attrName) && $type == "text") {
            $data['params']['class'] = 'jqueryDatePicker ';
            $data['attrValue'] = $obj->getValueAt($attrName);
            if (method_exists($data['attrValue'], 'format')) {
                $data['attrValue'] = $data['attrValue']->format('d/m/Y');
            }
        } else if ($obj->isBooleanField($attrName) && $type == "text") {
            $type = 'boolean';
        }
        $data['numCols'] = $numCols;
        $data['attrName'] = $attrName;
        $data['params']['id'] = str_replace('[]', '', $attrName);
        if (!isset($data['attrValue'])) {
            $data['attrValue'] = $obj->getValueAt($data['params']['id'], false);
        }

        $data['params']['class'] .= 'form-control';
        $data['params']['placeholder'] = $obj->getDescription($attrName);
        if ($obj->isRequired($attrName)) {
            $data['params']['required'] = 'true';
        }
        $data['inputType'] = $type;
        $data['options'] = $options;
        if ($type == "multiselect") {
            unset($data['params']['required']);
            $data['params']['multiple'] = "";
            $data['params']['data-rel'] = "chosen";
            $arr = $obj->{$data['params']['id']};
            $data['attrValue'] = [];
            foreach ($arr as $value) {
                $data['attrValue'][] = $value->id;
            }
        }
        return \View::make('templates.bootstrap.input', $data);
    }

    function submitBt() {
        return \View::make('templates.bootstrap.submit');
    }

}
