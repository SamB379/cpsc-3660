<?php

class Site {

	private $css_list;
	private $js_list;
	private $title;
	
	public function addCSS($location) {
		$this->css_list[] = $location;	
	}	
	
	public function addJS($location) {
		$this->js_list[] = $location;	
	}
	
	private function buildCSS() {
		$oData = "";
		if (is_array($this->css_list)) {
		foreach($this->css_list as $css) {
			$oData .= '<link rel="stylesheet" href="'.$css.'" />'.$this->nl();	
		}
		}
		return $oData;
	}
	
	private function buildJS() {
		$oData = "";
		if (is_array($this->js_list)) {
		foreach ($this->js_list as $js) 
			$oData .= '<script type="text/javascript" src="'.$js.'"></script>'.$this->nl();
		}
		return $oData;
	}
	
	public function startDraw() {
		$oData .= '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.$this->nl().'
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">'.$this->nl();
			$oData .= $this->buildHead();
			$oData .= '<body>'.$this->nl();
			
			return $oData;
	}
	
	private function buildHead() {
		$oData .= '<head>'.$this->nl();
		$oData .= '<title>'.$title.'</title>'.$this->nl();
		$oData .= $this->buildCSS();
		$oData .= $this->buildJS();
		$oData .= '</head>'.$this->nl();	
		return $oData;
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function endDraw() {
		$oData .= '</body></html>'.$this->nl();	
		return $oData;
	}
	
	private function nl() {
		return "\n";	
	}
	
}

?>