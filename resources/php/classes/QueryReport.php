<?php
include_once './yis_config.php';

class QueryReport
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $id;
	protected $what;
	protected $nomer;
	protected $type_id;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $kub;
	protected $data=NULL;
	protected $res=array();	
	public	  $results=array();
	
		
public function __construct()
	{
		$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YIS');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
    
		return $_db;
	}


	    public function getResults(stdClass $params)
	{

		
			$_db = $this->__construct();

			$this->prixod = PRIXOD;
		  $this->bank = BANK;
		  $this->admin = ADMIN;

		if(isset($params->what) && ($params->what)) {
		 $this->what = $params->what;
		} else {
		  $this->what = null;
		}

if(isset($params->login) && ($params->login)) {
		  $this->login= addslashes($params->login);
		} else {
		   $this->login= null;
		}		




$array = (array) $params;
foreach ( $array as $key => $value )  {
   if(isset($value)) {  
		  if (is_int($value)) { 
					$this->$key= (int)$value;}
			else if (is_float($value)) { 
					$this->$key= $value;}
			else {
						$this->$key =$_db->real_escape_string($value);
			}
  }
}
		$this->sql='';
		switch ($this->what) {

// ЮТКЭ БЮДЖЕТ

	
	
		
		case "KassaReestr":		
			      $this->sql='CALL YISGRAND.Bank_Kassa_Reestr("'.$this->bank.'","'.$this->prixod.'",'.$this->otdel_id.',"'.$this->pr.'","'.$this->user_id.'", "'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;		
		case "KassaReestrOsmd":		
			      $this->sql='CALL YISGRAND.Bank_Kassa_Osmd("'.$this->bank.'","'.$this->prixod.'",'.$this->otdel_id.',"'.$this->pr.'","'.$this->user_id.'", "'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;		
		case "KassirReestrDay":		
			      $this->sql='CALL YISGRAND.Bank_Kassa_Reestr_Day("'.$this->bank.'","'.$this->prixod.'",'.$this->otdel_id.',"'.$this->pr.'","'.$this->user_id.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			  //print($this->sql);
			break;		
		case "BankReestr":		
			      $this->sql='CALL YISGRAND.Bank_Reestr("'.$this->bank.'","'.$this->prixod.'","'.$this->user_id.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
		case "BankReestrOsmd":		
			      $this->sql='CALL YISGRAND.Bank_Reestr_Osmd("'.$this->bank.'","'.$this->prixod.'","'.$this->user_id.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
		case "OtdelReestr":		
			      $this->sql='CALL YISGRAND.Bank_'.$this->bank.'Reestr_All("'.$this->bank.'","'.$this->prixod.'","'.$this->pr.'","'.$this->user_id.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
		case "BankControl":		
			      $this->sql='CALL YISGRAND.Bank_'.$this->bank.'Control("'.$this->prixod.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			// print($this->sql);
			break;
		}
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @head,@content,@foot,@success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['head'] = $this->row['@head'];
			$this->results['content'] = $this->row['@content'];
			$this->results['sql'] = $this->sql;
			$this->results['foot'] = $this->row['@foot'];
			$this->results['success'] = $this->row['@success'];
			$this->results['msg'] = $this->row['@msg'];

		}
			
		/*include_once('absent_file.php')*/


		return $this->results;

}

 public function printSvod(stdClass $params)
	{

	
			$_db = $this->__construct();

			$this->prixod = PRIXOD;
		  $this->bank = BANK;
		  $this->admin = ADMIN;

		if(isset($params->what) && ($params->what)) {
		 $this->what = $params->what;
		} else {
		  $this->what = null;
		}

if(isset($params->login) && ($params->login)) {
		  $this->login= addslashes($params->login);
		} else {
		   $this->login= null;
		}		




$array = (array) $params;
foreach ( $array as $key => $value )  {
   if(isset($value)) {  
		  if (is_int($value)) { 
					$this->$key= (int)$value;}
			else if (is_float($value)) { 
					$this->$key= $value;}
			else {
						$this->$key =$_db->real_escape_string($value);
			}
  }
}
		$this->sql='';

	
		      $this->sql='CALL YISGRAND.Bank_'.$this->bank.'Print_Svod("'.$this->bank.'","'.$this->prixod.'",'.$this->otdel_id.',"'.$this->pr.'","'.$this->user_id.'","'.$this->data.'",@content,@success,@msg)';
		
			//  print($this->sql);

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @content,@success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['content'] = $this->row['@content'];
			$this->results['success'] = $this->row['@success'];
			$this->results['msg'] = $this->row['@msg'];
			$this->results['sql'] = $this->sql;
		}
		return $this->results;




}
}