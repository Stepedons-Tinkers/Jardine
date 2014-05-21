<?php
Class Writer
{
	public function __construct(){
	
	}
	
	function openFile($file){
		$this->file = $file;
	}
	
	function __initializeWriter(){
		$this->fh = fopen($this->file,'w') or die("cant Open File");
	}
	
	function write(){
		fwrite($this->fh,$this->str);
	}
	
	function close(){
		fclose($this->fh);
	}
	
	function writeClassName($class_name){
$this->str = <<<EOF
<?php
Class $class_name extends Reports
{
	protected \$adb;
	protected \$focus;

	function __construct(\$focus){
		global \$adb;
		\$this->adb = \$adb;
		\$this->focus = \$focus;
	}

	function generate(){
		global \$log;
		\$log->debug("Entering generate() method ...");
		
		/* code here */	
	}
	
	function assignData(\$smarty){
		global \$log;
		\$log->debug("Entering assignData() method ...");
		
		/* code here */	
	}
}
?>
EOF;
	}
}
?>