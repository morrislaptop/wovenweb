<?php
App::import('Helper', 'Form');

class AdvformHelper extends FormHelper {

	var $helpers = array('Html', 'Javascript');
	var $wysiwygEmbedded = false;
	var $calendarEmbedded = false;

	/**
	* put your comment there...
	*
	* @var HtmlHelper
	*/
	var $Html;

	function create($model = null, $options = array()) 
	{
		// include required files.
		$this->Javascript->codeBlock('
$(function() {
	$("input, select, textarea").focus(function() {
		$(this).parent("div.input").addClass("focused");
	}).blur(function() {
		$(this).parent("div.input").removeClass("focused");
	});
});', array('inline' => false));

		if ( is_array($model) ) {
			// put the first model into the form helper and then add onto the validations array with further models.
			$out = parent::create(array_shift($model), $options);
			foreach ($model as $model) {
				$this->addToValidates($model);
			}
			return $out;
		}
		else {
			return parent::create($model, $options);
		}
	}

	function addToValidates($model)
	{
		$object = ClassRegistry::getObject($model);
		if (!empty($object->validate)) {
			foreach ($object->validate as $validateField => $validateProperties) {
				if (is_array($validateProperties)) {
					$dims = Set::countDim($validateProperties);
					if (($dims == 1 && !isset($validateProperties['required']) || (array_key_exists('required', $validateProperties) && $validateProperties['required'] !== false))) {
						$validates[] = $validateField;
					} elseif ($dims > 1) {
						foreach ($validateProperties as $rule => $validateProp) {
							if (is_array($validateProp) && (array_key_exists('required', $validateProp) && $validateProp['required'] !== false)) {
								$validates[] = $validateField;
							}
						}
					}
				}
			}
		}
		$this->fieldset['validates'] = array_merge($this->fieldset['validates'], $validates);
	}

	function input($fieldName, $options = array())
	{
		$type = null;
		if ( !empty($options['type']) ) {
			$type = $options['type'];
		}

		if ( in_array($type, array('file', 'image', 'flash')) ) {
			$options['type'] = 'file';
		}
		else if ( in_array($type, array('number', 'url')) ) {
			$options['type'] = 'text';
		}
		else if ( 'wysiwyg' == $type ) {
			if ( !$this->wysiwygEmbedded ) {
				$this->embedWysiwyg();
			}
			$options['type'] = 'textarea';
			$options['class'] = 'tinymce';
		}
		else if ( 'calendar' == $type ) {
			if ( !$this->calendarEmbedded ) {
				$this->embedCalendar();
			}
			$options['type'] = 'text';
			$options['class'] = 'calendar';
			if ( strpos($fieldName, '.') === false ) {
				$fieldName = $model->name . '.' . $fieldName . '.date';
			}
			else {
				$fieldName .= '.date';
			}
		}

		return parent::input($fieldName, $options);
	}
	
	function inputWithDefault($fieldName, $default, $options) {
		$this->setEntity($fieldName);
		$value = $this->value();
		if ( !empty($options['id']) ) {
			$id = $options['id'];
		}
		else {
			$id = $this->domId();
		}
		
		// if there is a value, return as normal
		if ( !empty($value['value']) ) {
			return parent::input($fieldName, $options);	
		}
		
		$blurColor = '#808080';
		if ( !empty($options['blurColor']) ) {
			$blurColor = $options['blurColor'];
			unset($options['blurColor']);
		}
		
		// start the fun!
		$jsDefault = $this->Javascript->escapeString($default);
		
		$js = '
$("#' . $id . '").focus(function() {
	if ( this.value == "' . $jsDefault . '" ) {
		this.value = "";
		$(this).css("color", "");
	}
}).blur(function() {
	if ( this.value == "" ) {
		this.value = "' . $jsDefault . '";
		$(this).css("color", "' . $blurColor . '");
	}
});
		';
		
		$newOptions = array(
			'value' => $default,
			'after' => $this->Javascript->codeBlock($js),
			'style' => 'color: ' . $blurColor
		);
		
		return $this->input($fieldName, array_merge($newOptions, $options));
	}

	function embedWysiwyg()
	{
		$this->wysiwygEmbedded = true;
		$this->Javascript->link('tiny_mce/tiny_mce', false);
		$view = ClassRegistry::getObject('view');
		echo $view->element('admin' . DS . 'tiny_mce', array('plugin' => 'uniform'));
	}

	function embedCalendar()
	{
		$this->calendarEmbedded = true;
		$this->Html->css('calendar/css/smoothness/jquery-ui-1.7.1.custom', null, null, false);
		$this->Javascript->link('calendar/js/jquery-ui-1.7.1.custom.min', false);
		$view = ClassRegistry::getObject('view');
		echo $view->element('admin' . DS . 'calendar', array('plugin' => 'uniform'));
	}
}
?>