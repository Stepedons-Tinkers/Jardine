<?php
Class DirectoryWriter {

	function __construct($writer){
		$this->writer = $writer;
	}
	
	function __initialize($modulename){
		$this->MODULECLASS = $modulename;
		$this->MODULENAME = strtolower($modulename);
	}
	
	function copyDirectory($src,$dst,$module_name){
		$this->src = $src;
		$this->dst = $dst.$module_name;
		$this->module_name = $module_name;
		recurse_copy($this->src,$this->dst);
	}
	
	function renameFiles(){
		@rename($this->dst."/ModuleFile.js",$this->dst."/".$this->module_name.".js");
		@rename($this->dst."/ModuleFile.php",$this->dst."/".$this->module_name.".php");
		@rename($this->dst."/ModuleFileAjax.php",$this->dst."/".$this->module_name."Ajax.php");
	}
	
	function writeModuleFile($modulefiles){
		$this->writer->openFile($this->dst."/".$this->module_name.".php");
		$this->writer->__initializeWriter();
		$this->writer->writeHeaderModule($this->MODULECLASS,$this->MODULENAME);
		$this->writer->writeVariables($modulefiles);
		$this->writer->writeFooterModule($this->src."/ModuleFooter.php");
		$this->writer->write();
		$this->writer->close();
	}
	
	
}

?>