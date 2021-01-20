<?php
include_once './yis_config.php';

class QueryLoad
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $what_id;
	protected $what;
	protected $type;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $kub;
	protected $data=NULL;
	protected $res=array();	
	public	  $results=array();
	

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

	public function getResults(stdClass $params)
	{

		$_db = $this->connect();

		
		$_db = $this->connect();

		$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$value;}
		  }
		}

		switch ($this->what) {

	
		case "raion":
				$this->sql='SELECT * FROM YIS.RAION ORDER BY raion';
					    //print($_sql); 
		break;
		case "street":
				$this->sql='SELECT * FROM YIS.STREET ';
			    
		break;
		case "house":
				$this->sql='SELECT * FROM YIS.HOUSE';
					    //print($_sql);
		break;
	case "OtdelenieBanka":			
			 
									$this->sql='SELECT * FROM YISGRAND.'.BANK.'OTDELENIE WHERE  1' ;
		break;
		case "OperatorBanka":			
			  	$this->sql='SELECT * FROM YISGRAND.'.BANK.'USERS WHERE  1' ;
			    
		break;

		case "StreetsFromRaion":
				if ($this->what_id==0) {
				    $this->sql='SELECT * FROM YIS.STREET ORDER BY street';
				} else {
				    $this->sql='SELECT YIS.STREET.street_id,'
						.'YIS.STREET.street '
						.' FROM YIS.STREET,YIS.HOUSE '
						.' WHERE YIS.STREET.street_id=YIS.HOUSE.street_id '
						.' AND YIS.HOUSE.raion_id='.$this->what_id.' '
						.' GROUP BY YIS.STREET.street_id '
						.' ORDER BY YIS.STREET.street';
				}
				  // print($this->sql);

		break;
		case "HousesFromRaion":
				$this->sql='SELECT raion_id,street_id,house_id,raion,house,house as item FROM YIS.HOUSE WHERE raion_id= '.$this->what_id.' ORDER BY house';
			    
		break;
		case "HousesFromStreet":
				if ($this->what_id == 0) { 
				    $this->sql='SELECT * FROM YIS.HOUSE ORDER BY house ';
				} else {
				    $this->sql='SELECT * FROM YIS.HOUSE WHERE street_id='.$this->what_id.'';
				}  
				  // print($this->sql);
		break;
		case "AddressFromHouses":
				 $this->sql='SELECT `address_id`, `address`,cast(appartment as unsigned) as app '
						 . 'FROM YIS.ADDRESS '
						 .' WHERE YIS.ADDRESS.`house_id`= '. $this->what_id.' '
						 .' ORDER BY app ';
				//print($this->sql);
			 
		    break;
	
			case "Bank":			
			      $this->sql='SELECT * FROM  YISGRAND.BANKS ORDER BY bname';
			      //print_r($this->sql); 
			break;

		
		} // End of Switch ($what)
		
	
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what. ' (' .  $this->sql . ') ' . $_db->connect_error);

//		$this->result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		
		return $this->results;
	}


/*	public function __destruct()
	{
		$_db = $this->connect($this->login,$this->password);
		$_db->close();
		
		return $this;
	}*/
}