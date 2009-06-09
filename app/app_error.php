<?php
class AppError extends ErrorHandler {
	function _outputMessage($template) {
		$this->controller->layout = 'default';
		return parent::_outputMessage($template);
	}
}	
?>