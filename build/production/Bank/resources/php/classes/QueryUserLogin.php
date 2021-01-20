<?php

include_once './yis_config.php';


class QueryUserLogin
{
	private $_db;
	protected $login;
	protected $password;	
	protected $sql;
	public $results;
	
	
	public function connect()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YISGRAND');
		if ($_db->connect_error) {
			return false;
		} else {		
		$_db->set_charset("utf8");    
		return $_db;
		}
	}


		public function login(stdClass $params)
	{
			
		if(isset($params->otdelenie) && ($params->otdelenie)) {
		  $this->otdelenie= addslashes($params->otdelenie);
		} else {
		   $this->otdelenie= null;
		}
    
		if(isset($params->login) && ($params->login)) {
		  $this->login= addslashes($params->login);
		} else {
		   $this->login= null;
		}
			if(isset($params->user_id) && ($params->user_id)) {
		  $this->user_id= $params->user_id;
		} else {
		   $this->user_id= 0;
		}
		if(isset($params->password) && ($params->password)) {
		  $this->password= $params->password;
		} else {
		   $this->password= null;
		}
		if(isset($params->memorize) && ($params->memorize)) {
		  $this->remember= $params->memorize;
		} else {
		   $this->remember=0;
		}		
		    $_db = $this->connect();

		if($_db){
		$this->sql='SELECT t1.`user_id`,t1.`role`,t1.`login`  FROM YISGRAND.'.BANK.'USERS as t1 WHERE t1.`user_id` = "'.$this->user_id.'" and t1.`password` = sha1("'.$this->password.'") ' ; 

		 $_result = $_db->query($this->sql) or die('Connect Error (' . $this->sql. ') ' . $_db->connect_error);

		 $results = new stdClass();
		if	($rows=mysqli_affected_rows($_db)){
		while ($row = $_result->fetch_assoc()) {
		$results->user_id = $row['user_id'];
		$results->login	= $row['login'];
		$results->password = $this->password;
		$results->role = $row['role'];
		$results->bank = BANK;		
			$results->success = true;
			}
		} else{
			$results->success = false;
		}
		
		
		}else{
		  $results->success = false;
		}
		return $results;
	}
}
