<?php

class Template{
	
	var $tmpl;
	var $data;
	
	function Template($templFile) {
		$this->tmpl = implode('', file($templFile));
		$this->data = Array();
	}
	
	function add($name, $value='') {

		if(is_array($name)){
			$this->data = $name;
		}else if(!empty($value)){
			$this->data[$name] = $value;
		}
	}
	
	function execute() {
		return preg_replace('/\\${([^}]+)}/e', '$this->data["\\1"]', $this->tmpl);
	}
	
	
	
}

?>