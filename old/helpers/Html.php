<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author Rafayel Khachatryan
 */
 
namespace helpers;
 
class Html {

    public static function dropDownList($data = [], $options = [], $showEmptyLine = true) {
        $name = '';
        if (array_key_exists('name', $options)) {
            $name = 'name="' . $options['name'] . '"';
        }

        if (array_key_exists('classes', $options)) {
            $classes = $options['classes'];
        } else {
            $classes = '';
        }
        if (array_key_exists('showLabel', $options) && $options['showLabel'] === false) {
            $label = '';
        } else {
            $label = ' <label for="sel1">{TR_' . $options['name'] . '}</label>';
        }

        $return = '<div class="form-group">
                 ' . $label . '
       <select ' . $name . ' class="form-control  ' . $classes . '">';
        if ($showEmptyLine) {
            $return .= '<option value="0">-------------</option>';
        }
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $selected = '';
                if (array_key_exists('selected', $options) && $options['selected'] == $k) {
                    $selected = 'selected="selected"';
                }
                $return.='<option ' . $selected . '  value="' . $k . '">' . $v . '</option>';
            }
        }
        $return .= "</select>  </div>";

        return $return;
    }

    public static function dataList($data = [], $options = [], $showEmptyLine = true) {
        $name = '';
        $id = '';
        if (array_key_exists('name', $options)) {
            $name = 'name="' . $options['name'] . '"';
            $id = 'id="' . $options['name'] . '"';
        }

        $return = '<div class="form-group">
                    <label for="sel1">{TR_' . $options['name'] . '}</label>
                    <input onblur="getDataListValue()"  id="input' . $options['name'] . '"  list="' . $options['name'] . '" type="text"  />
       <datalist ' . $id . '>';
        if ($showEmptyLine) {
            $return .= '<option id="0" value="-------------">';
        }
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $selected = '';
                if (array_key_exists('selected', $options) && $options['selected'] == $k) {
                    $selected = 'selected="selected"';
                }
                $return.='<option id="' . $k . '" ' . $selected . '  value="' . $v . '">';
            }
        }

        $return .= "</datalist><input type='hidden'  $name id='hidden" . $options['name'] . "'>  </div>";

        return $return;
    }

    public static function inputField($options = []) {
        $idName = (isset($options['name'])) ? $options['name'] : 'idname';
        $value = (isset($options['value'])) ? $options['value'] : '';
        $type = (isset($options['type'])) ? $options['type'] : 'text';
        $classes = (isset($options['classes'])) ? 'class="' . $options['classes'] . '"' : '';
        $required = (isset($options['required'])) ? 'required="required"' : '';
        $readonly = (isset($options['readonly'])) ? 'readonly="readonly"' : '';
        $maxLength = (isset($options['maxlength'])) ? 'maxlength="' . $options['maxlength'] . '"' : '';
        $max = (isset($options['max'])) ? 'max="' . $options['max'] . '"' : '';
        return '<div class="form-group">
                    <label for="' . $idName . '">' . $idName . '</label>
                    <input '.$max.'  '.$maxLength.' ' . $required . ' ' . $classes . ' ' . $readonly . ' placeholder="" type="' . $type . '" name="' . self::generateName(['name' => $idName]) . '" value="' . $value . '" class="form-control" id="' . $idName . '">
                  </div>';
    }

    public static function inputPassword($options = []) {
        $idName = (isset($options['name'])) ? $options['name'] : 'idname';
        $value = (isset($options['value'])) ? $options['value'] : '';
        return '<div class="form-group">
                    <label for="' . $idName . '">' . $idName . '</label>
                    <input  placeholder="" type="password" name="' . self::generateName(['name' => $idName]) . '" value="' . $value . '" class="form-control" id="' . $idName . '">
                  </div>';
    }

    public static function inputReadOnly($options = []) {
        $value = (isset($options['value'])) ? $options['value'] : '';
        $idName = (isset($options['name'])) ? $options['name'] : 'idname';
        return '<label for="' . $idName . '">{TR_' . $idName . '}</label><div class="form-group readonly">' . $value . '
                  </div>';
    }

    public static function inputHidden($options = []) {
        $idName = (isset($options['name'])) ? $options['name'] : 'idname';
        $value = (isset($options['value'])) ? $options['value'] : '';
        return '<input type="hidden" name="' . $idName . '" value="' . $value . '">';
    }

    public static function inputDate($options = []) {
        $idName = (isset($options['name'])) ? $options['name'] : 'idname';
        $value = (isset($options['value'])) ? $options['value'] : '';

        $display_string = (isset($options['display_string'])) ? $options['display_string'] : '';
        return '  <div class="form-group">
                     <label >' . $display_string . '</label> 
                    <div class="input-group datePickerClass w100 date" data-provide="datepicker">
                        <input type="text"  class="datepicker form-control" value="' . $value . '" name="' . $idName . '">
                        <div class="input-group-addon">
                            <span class="  glyphicon glyphicon-th"></span>
                        </div>
                   </div>
                </div>';
    }

    public static function inputNumber($options = []) {
        $idName = (isset($options['name'])) ? $options['name'] : 'idname';
        $value = (isset($options['value'])) ? $options['value'] : '';
        return '<div class="form-group">
                    <label for="' . $idName . '">{TR_' . $idName . '}</label>
                    <input type="number" name="' . self::generateName(['name' => $idName]) . '" value="' . $value . '" class="form-control" id="' . $idName . '">
                  </div>';
    }

    public static function inputFile($options = []) {
        $idName = (isset($options['name'])) ? $options['name'] : 'idname';
        $value = (isset($options['value'])) ? $options['value'] : '';
        $showFile = (isset($options['showFile']) && ($options['showFile']) ) ? true : false;
        $return = '<div class="form-group">
                    <label for="' . $idName . '">{TR_' . $idName . '}</label>
                    <input placeholder=""  type="file" name="' . self::generateName(['name' => $idName]) . '" class="form-control" id="' . $idName . '">
                  </div>';

        if (isset($options['showFile']) && $options['showFile']) {
            $return.= File::returnFileIfExists($options['pathName'], $value);
        }



        return $return;
    }

    public static function checkBox($options = []) {
        $idName = (isset($options['name'])) ? $options['name'] : 'idname';
        $checked = (isset($options['value']) && (!!$options['value'])) ? 'checked="checked"' : '';
         $classes = (isset($options['classes']) ? $options['classes'] : '' );
        return '<div class="form-group"> 
                <div class="">
                  <div class="checkbox">
                    <label><input  class="' . $classes . '"   ' . $checked . ' name="' . $idName . '" value="1" type="checkbox"> {TR_' . $idName . '}</label>
                  </div>
                </div>
              </div>';
    }

    public static function inputcheckBox($options = []) {
        $idName = (isset($options['name'])) ? $options['name'] : 'idname';
        $display_string = (isset($options['display_string'])) ? $options['display_string'] : 'display_string';
        $value = (isset($options['value'])) ? $options['value'] : '1';
         
        $checked = (isset($options['checked']) && (!!$options['checked'])) ? 'checked="checked"' : '';
        $dataId = (isset($options['dataId']) && (!!$options['dataId'])) ? 'data-id="' . $options['dataId'] . '"' : '';
        return '<div class="form-group"> 
                <div class="">
                  <div class="checkbox">
                    <label><input ' . $dataId . ' ' . $checked . ' name="' . $idName . '" value="' . $value . '" type="checkbox"> ' . $display_string . '</label>
                  </div>
                </div>
              </div>';
    }

    public static function buttonSubmit($options = []) {
        $classes = '';
        if (array_key_exists('classes', $options)) {
            $classes = 'class ="' . $options['classes'] . '"';
        }
        if (array_key_exists('display_name', $options)) {
            $display_name = $options['display_name'];
        }
		 if (array_key_exists('name', $options)) {
            $name = $options['name'];
        }

        return '<button '.$name.' ' . $classes . ' type="submit" >' . $display_name . '</button>';
    }

    public static function a($options = []) {
        $classes = (isset($options['classes']) ? $options['classes'] : '' );
        $href = (isset($options['href']) ? $options['href'] : '' );
        $name = (isset($options['name']) ? $options['name'] : '' );
        return '<a href="' . $href . '" class="' . $classes . '">' . $name . '</a>';
    }

    public static function simpleText($options = []) {
        $text = (isset($options['text']) ? $options['text'] : '' );
        $classes = (isset($options['classes']) ? $options['classes'] : '' );
        return '<div class="' . $classes . '">' . $text . '</div>';
    }

    public static function buttonBack($options = []) {
        $classes = '';
        if (array_key_exists('classes', $options)) {
            $classes = 'class ="' . $options['classes'] . '"';
        }
        if (array_key_exists('display_name', $options)) {
            $display_name = $options['display_name'];
        }

        return '<button ' . $classes . ' type="button" onclick="javascript:goBack();">{TR_' . $display_name . '}</button>';
    }

    private static function generateName($options = []) {
        $name = (isset($options['name']) ? $options['name'] : 'name');
        return $name;
    }

}
