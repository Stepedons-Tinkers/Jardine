<?php
require_once "include/nextixlib/phpmailer/class.phpmailer.php";
require_once "include/nextixlib/phpmailer/class.smtp.php";

class MySMTP {
    private $adb;
    private $current_user;
    private $mail;
    
    public function __construct() {
		global $adb, $current_user;
        $this->adb = $adb;
        $this->current_user = $current_user;
		
		$query = "Select * from vtiger_systems where server_type = 'email'";
		$result = $adb->pquery($query,array());
		$noofrows = $adb->num_rows($result);
		$data = array();
		if($noofrows) {
			while($resultrow = $adb->fetchByAssoc($result)) {
				$data = $resultrow;
			}
		}
		
		
        // $user = new User();
        // $user_info = $user->getName(1);
        //$name = $user_info['first_name']." ".$user_info['last_name'];
        $name = "Jardine CRM Mailer";
        
        $secure = substr($data['server'], 0, strpos($data['server'], ':'));
        $host   = substr($data['server'], 6, strripos($data['server'], ':') - (strripos($data['server'], '/') + 1));
                                  
        $this->mail = new PHPMailer2();
        $this->mail->IsSMTP();
        $this->mail->SMTPAuth   = $data['smtp_auth'];
        $this->mail->SMTPSecure = $secure;
        $this->mail->Host       = $host;
        $this->mail->Port       = ($data['server_port'] == 0) ? 
                                    substr($data['server'], (strripos($data['server'], ':') + 1) - strlen($data['server'])) : 
                                    $data['server_port'];
        $this->mail->Username   = $data['server_username'];
        $this->mail->Password   = $data['server_password'];
        $this->mail->From       = $data['server_username'];
        $this->mail->FromName   = $name;
        $this->mail->Subject    = "";
        $this->mail->WordWrap   = 100;
        $this->mail->SMTPDebug  = 1;
        $this->mail->Timeout    = 30;
    }
    
    public function getMail() {
        return $this->mail;
    }
	
	public function revSendDynamicRecipient($subject, $body, $recipient=array(), $cc=array()){
		if(count($recipient) >= 1)
		{         
			foreach($recipient as $email => $name){
				$this->mail->AddAddress($email, $name);
			}
			foreach($cc as $email => $name){
				$this->mail->AddCC($email, $name);
			}	
			$this->mail->IsHTML(true);
			$this->mail->Subject = $subject; 
			$this->mail->Body = $body;    
			if(!$this->mail->Send())
			{
			  echo "Error sending: " . $this->mail->ErrorInfo;;
			}
		}
	}	
}

?>