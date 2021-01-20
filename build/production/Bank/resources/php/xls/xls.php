<?php
include_once './../yis_config.php';

class XmlCreate
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $sql_callback;
	protected $res_callback;
	public	  $results;

	
	
	public function __construct()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YIS');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
    
		return $_db;
	}


	    public function getResults($sql)
	{

		$_db = $this->__construct();
	
		
		
		$this->result = $_db->query($sql) or die('Connect Error in  ('.$sql.') ' . $_db->connect_error);
		$this->sql_callback='SELECT @content';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results = $this->row['@content'];			
		}
		
		return $this->results;




}

}



      try {
	
		if    (isset($_REQUEST['fname']) && !empty($_REQUEST['fname'])){ //код подтверждения 
			$fname=$_REQUEST['fname'];
//print($fname);
		 } else {           
			$fname='spreadsheet.xls';
		}
		if    (isset($_REQUEST['sql']) && !empty($_REQUEST['sql'])) { //код подтверждения 
			      $sql=$_REQUEST['sql'];
//print($sql)
			      $obj = new XmlCreate();
			      $content=$obj->getResults($sql);
			      if ($content) {
									header("Content-Type: application/vnd.ms-excel charset=utf-8");
									header('Content-disposition: attachment; filename='.$fname.'.xls');
									header("Pragma: no-cache");
									header("Expires: 0");
									$res =$content;
						} else {
		
								throw new Exception("Не удалось выполнить запрос");
						}				
	 } else {     
			
		throw new Exception('Нет данных для запроса!');
	}
		
		  
		
	}
	catch(Exception $e){
		$res = $e->getMessage();
		
	}

	 return print($res);


?>
