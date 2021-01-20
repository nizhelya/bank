<?php
include_once './yis_config.php';

class QueryAddress
{
	private $_db;
	protected $_result;
	protected $address_id;
	protected $private;
	protected $appartment;
	protected $_total;
	protected $_count;
	protected $_sql;
	protected $_sql_total;
	protected $_limit;
	protected $login;
	protected $password;
	protected $_array;
	protected $_id;
	protected $_what;	
	protected $_place;
	protected $_type;
	public $results;
	


	public function connect()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YIS');
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

		if(isset($params->what) && ($params->what)) {
		 $_what = $params->what;
		} else {
		  $_what = null;
		}
		if(isset($params->what_id) && ($params->what_id)) {
		  $_id = (int) $params->what_id;
		} else {
		  $_id = 0;
		}

		if(isset($params->address_id) && ($params->address_id)) {
		 $this->address_id = $params->address_id;
		} else {
		  $this->address_id = null;
		}
		if(isset($params->privat) && ($params->privat)) {
		 $this->privat = $params->privat;
		} else {
		  $this->privat = 0;
		}
		if(isset($params->appartment) && ($params->appartment)) {
		 $this->appartment = $params->appartment;
		} else {
		  $this->appartment = null;
		}

		switch ($_what) {
	//inuse
		   case "raion":
			  $_sql_total=null; 
				$_sql='SELECT * FROM YIS.RAION WHERE YIS.RAION.raion_id not in(10,8,9)  ORDER BY raion';
			   //print($_sql); 
		    break;
		     case "street":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM YIS.STREET WHERE YIS.STREET.street_id not in(21,22,23,24,25,26,27,28,29,30,31,32) ';
			    
		    break;
		      case "house":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM YIS.HOUSE';
	      //print($_sql);
			    
		    break;

		  case "StreetsFromRaion":
			$_sql_total=null; 
			if ($_id==0) {
			  $_sql='SELECT * FROM YIS.STREET ORDER BY street';
			} else {
			  $_sql='SELECT YIS.STREET.street_id, YIS.STREET.street FROM YIS.STREET, YIS.HOUSE WHERE YIS.STREET.street_id=YIS.HOUSE.street_id AND YIS.HOUSE.raion_id='.$_id.' GROUP BY YIS.STREET.street_id ORDER BY YIS.STREET.street';
			}
			    
		    break;

		    case "HousesFromRaion":
			  $_sql_total=null; 
			  $_sql='SELECT raion_id,street_id,house_id,raion,house,house as item FROM YIS.HOUSE WHERE raion_id= '.$_id.' ORDER BY house';
			    
		    break;

		   case "HousesFromStreet":
			  $_sql_total=null; 
			  if ($_id == 0) {
			    $_sql='SELECT raion_id,street_id,house_id,house,raion,house,house as item FROM YIS.HOUSE ORDER BY house';
			  }  else if($this->privat) {
			    $_sql='SELECT raion_id,street_id,house_id,address_id,house,raion,house,street,address,appartment,address as item,cast(appartment as unsigned) as app FROM YIS.ADDRESS WHERE street_id= '.$_id.' ORDER BY app';
			   } else {
			    $_sql='SELECT raion_id,street_id,house_id,house,raion,house,house as item FROM YIS.HOUSE WHERE street_id= '.$_id.' ORDER BY house';
			  }   
//print($_sql);
		    break;

		       case "AddressFromHouses":
			  $_sql_total=null; 
			  if ($_id == 0) { $_sql='SELECT address_id, address FROM YIS.ADDRESS ORDER BY address';
			  } else {
			  $_sql='SELECT * FROM YIS.ADDRESS WHERE house_id= '.$_id.'';
			    //print($_sql);
			  }
		    break;
		     case "address":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM YIS.ADDRESS  WHERE address_id='.$_id.' LIMIT 1';
			    
		    break;


		    case "CheckFlat":

			  $_sql_total=null; 
			  $_sql='SELECT raion_id,street_id,house_id,address_id,house,raion,house,street,address,appartment FROM YIS.ADDRESS WHERE house_id='.$_id.' AND appartment="'.$this->appartment.'" LIMIT 1';
			// print($_sql);  
		    break;
		  
		    case "Appartment":
			  $_sql_total=null; 
			  $_sql= 'SELECT * FROM YIS.APPARTMENT as t1  WHERE t1.`address_id`='.$_id.''; 
//print($_sql);  
		 break;
		    case "Lgotnik"://применяется
			 // $_sql_total='SELECT * FROM VODOMER WHERE address_id='.$_id.''; 
			   $_sql='SELECT YIS.LGOTAMEN.`lgotnik_id`,YIS.LGOTAMEN.`lgota_id`,YIS.LGOTAMEN.`address_id`, YIS.LGOTAMEN.`address`, YIS.LGOTAMEN.`kartochka`, YIS.LGOTAMEN.`inn`, YIS.LGOTAMEN.`passport`, '
				  .' CONCAT(YIS.LGOTAMEN.`surname`,\' \', SUBSTRING(YIS.LGOTAMEN.`firstname`,1,1),\'.\',SUBSTRING(YIS.LGOTAMEN.`lastname`,1,1),\'.\') as fio, '
				  .' YIS.LGOTAMEN.`surname`, YIS.LGOTAMEN.`firstname`, YIS.LGOTAMEN.`lastname`, YIS.LGOTAMEN.`surname_ua`, YIS.LGOTAMEN.`firstname_ua`, YIS.LGOTAMEN.`lastname_ua`, '
				  .' YIS.LGOTAMEN.`document`, YIS.LGOTAMEN.`lgota`, YIS.LGOTAMEN.`category`, YIS.LGOTAMEN.`people`, YIS.LGOTAMEN.`percent`, YIS.LGOTAMEN.`given`, YIS.LGOTAMEN.`data`, '
				  .' DATE_FORMAT(YIS.LGOTAMEN.data,"%d-%m-%Y") as fdate, YIS.LGOTAMEN.`gr`, YIS.LGOTAMEN.`vkl`, YIS.LGOTAMEN.`raion`, YIS.LGOTAMEN.`operator`, YIS.LGOTAMEN.`data_in` '
				  .' FROM YIS.LGOTAMEN WHERE  YIS.LGOTAMEN.address_id='.$_id.' AND YIS.LGOTAMEN.vkl = "да"';
			break;
	    case "HistoryLgotnik"://применяется
			   $_sql='SELECT YIS.LGOTAMEN.`lgotnik_id`,YIS.LGOTAMEN.`lgota_id`,YIS.LGOTAMEN.`address_id`, YIS.LGOTAMEN.`address`, YIS.LGOTAMEN.`kartochka`, YIS.LGOTAMEN.`inn`, YIS.LGOTAMEN.`passport`, '
				  .' CONCAT(YIS.LGOTAMEN.`surname`,\' \', SUBSTRING(YIS.LGOTAMEN.`firstname`,1,1),\'.\',SUBSTRING(YIS.LGOTAMEN.`lastname`,1,1),\'.\') as fio, '
				  .' YIS.LGOTAMEN.`surname`, YIS.LGOTAMEN.`firstname`, YIS.LGOTAMEN.`lastname`, YIS.LGOTAMEN.`surname_ua`, YIS.LGOTAMEN.`firstname_ua`, YIS.LGOTAMEN.`lastname_ua`, '
				  .' YIS.LGOTAMEN.`document`, YIS.LGOTAMEN.`lgota`, YIS.LGOTAMEN.`category`, YIS.LGOTAMEN.`people`, YIS.LGOTAMEN.`percent`, YIS.LGOTAMEN.`given`, YIS.LGOTAMEN.`data`, '
				  .' DATE_FORMAT(YIS.LGOTAMEN.data,"%d-%m-%Y") as fdate, YIS.LGOTAMEN.`gr`, YIS.LGOTAMEN.`vkl`, YIS.LGOTAMEN.`raion`, YIS.LGOTAMEN.`operator`, YIS.LGOTAMEN.`data_in` '
				  .' FROM YIS.LGOTAMEN WHERE  YIS.LGOTAMEN.address_id='.$_id.'';
	//print($_sql);  

		    break;
		     case "TekNach":			  
			  $_sql_total='SELECT * FROM YIS.KVARTPLATA  WHERE address_id='.$_id.''; 
			   $_sql='(SELECT 1 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.VODA  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 2 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.STOKI  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 ) UNION '
				  .' (SELECT 3 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,gkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.PODOGREV  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 ) UNION '    
				  .' (SELECT 4 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN gkal=0 THEN "м2" ELSE "Гкал" END as edizm,CASE WHEN gkal=0 THEN square ELSE gkal END as qty,CASE WHEN gkal=0 THEN tarif ELSE tarif_gkal END as tarif,'
				  .'nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg '
				   .'FROM YIS.OTOPLENIE  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 ) UNION '    
				  .' (SELECT 5 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,"м2" as edizm,square as qty,tarif,'
				   .'nachisleno-perer-raznoe as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.KVARTPLATA  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 ) UNION '    
				  .' (SELECT 6 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'"чел" as edizm,people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.TBO  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 )  ORDER BY data DESC ,p';
//print($_sql);
		    break;
		       case "YearNachisleno":
			  $_sql_total=null; 
			  $_sql='SELECT god FROM YIS.VODA    GROUP BY god DESC'; 
					    
		    break;
		       case "NachDetail":
			 //print_r($_period); 
			  $_sql_total=null; 
			  $_sql='SELECT * FROM '.$_table.' WHERE address_id='.$_id.' and data=DATE_FORMAT("'.$_period.'","%Y-%m-%d")'; 
				//	      print($_sql);
		    break;

		} // End of Switch ($what)
		
	
		if($_db){
		

		$_result = $_db->query($_sql) or die('Connect Error in '. $_what .'  (    ' .  $_sql . '    ) ' . $_db->connect_error);

		$_array=array();
		while ($row = $_result->fetch_assoc()) {
			array_push($_array, $row);
		}
		$results = array();
		$results['success']= true;


		//if ($results['total']	= $_total;
		$results['total']= null;
		/*if(isset($results['total') && ($results['total')) {
		 $results['total' = $results['total';
		} else {
		   $results['total'= null;
		}*/


		$results['data']= $_array;
		}else{
		 $results['success']= false;
		}
		return $results;
	}
	public function updateRecords(stdClass $params)      // ================================= UPDATE RECORDS
		{

		if(isset($params->login) && ($params->login)) {
		  $this->login= addslashes($params->login);
		} else {
		   $this->login= null;
		}		
		if(isset($params->password) && ($params->password)) {
		  $this->password= $params->password;
		} else {
		   $this->password= null;
		}

		$_db = $this->connect($this->login,$this->password);
	
		if(isset($params->what) && ($params->what)) {
		 $this->what = $params->what;
		} else {
		  $this->what = null;
		}

		$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}
		$this->sql='';
		switch ($this->what) {

		    case "Appartment":
		 $this->sql='CALL YISGRAND.AppartmentUpdate('
		.$this->address_id.','
		.$this->house_id.',"'
		.$this->address.'", '
		.$this->tenant.','
		.$this->absent.', '
		.$this->podnan.','
		.$this->lgotchik.',"'
		.$this->subsidia.'",'
		.$this->area_balk.','
		.$this->area_dop.','
		.$this->area_full.','
		.$this->area_life.','
		.$this->room.',"'
		.$this->lift.'","'
		.$this->teplomer.'",'
		.$this->teplomer_id.','
		.$this->dteplomer_id.',"'
		.$this->boiler.'", "'
		.$this->nanim.'", "'
		.$this->owner.'", "'
		.$this->inn.'", "'
		.$this->passport.'", "'
		.$this->vidan.'", "'
		.$this->viddata.'", "'
		.$this->privat.'", "'
		.$this->order.'", "'
		.$this->data_ordera.'","'
		.$this->vgvoda.'", "'
		.$this->vxvoda.'", "'
		.$this->voda.'", "'
		.$this->stoki.'", "'
		.$this->podogrev.'", "'
		.$this->otoplenie.'", "'
		.$this->kvartplata.'", "'
		.$this->tbo.'", "'
		.$this->what_change.'", "'
		.$this->data_change.'", "'
		.$this->info.'", "'
		.$this->chdata.'", '
		.' @success, @msg)';
			 // print($this->sql);
		break;
			case "AppVodaIns":
				 $this->sql='UPDATE YIS.VODA SET zadol='
				.$this->zadol.',YIS.VODA.people='
				.$this->people.',YIS.VODA.xkub='
				.$this->xkub.',YIS.VODA.gkub='
				.$this->gkub.',YIS.VODA.tarif='
				.$this->tarif.',YIS.VODA.norma='
				.$this->norma.',YIS.VODA.xvoda='
				.$this->xvoda.',YIS.VODA.gvoda='
				.$this->gvoda.',YIS.VODA.perer='
				.$this->perer.',YIS.VODA.nachisleno='
				.$this->nachisleno.',YIS.VODA.xkub_lg='
				.$this->xkub_lg.',YIS.VODA.gkub_lg='
				.$this->gkub_lg.',YIS.VODA.budjet='
				.$this->budjet.',YIS.VODA.pbudjet='
				.$this->pbudjet.',YIS.VODA.oplacheno='
				.$this->oplacheno.',YIS.VODA.dolg='
				.$this->dolg.',YIS.VODA.operator="'
				.$this->login.'",YIS.VODA.data_in= CURDATE() WHERE YIS.VODA.address_id='
				.$this->address_id.' AND YIS.VODA.data = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1';
			    //print_r($this->sql); 
			break;
	case "AppStokiIns":
				 $this->sql='UPDATE YIS.STOKI SET zadol='
				.$this->zadol.',YIS.STOKI.people='
				.$this->people.',YIS.STOKI.xkub='
				.$this->xkub.',YIS.STOKI.gkub='
				.$this->gkub.',YIS.STOKI.tarif='
				.$this->tarif.',YIS.STOKI.norma='
				.$this->norma.',YIS.STOKI.xvoda='
				.$this->xvoda.',YIS.STOKI.gvoda='
				.$this->gvoda.',YIS.STOKI.perer='
				.$this->perer.',YIS.STOKI.nachisleno='
				.$this->nachisleno.',YIS.STOKI.xkub_lg='
				.$this->xkub_lg.',YIS.STOKI.gkub_lg='
				.$this->gkub_lg.',YIS.STOKI.budjet='
				.$this->budjet.',YIS.STOKI.pbudjet='
				.$this->pbudjet.',YIS.STOKI.oplacheno='
				.$this->oplacheno.',YIS.STOKI.dolg='
				.$this->dolg.',YIS.STOKI.operator="'
				.$this->login.'",YIS.STOKI.data_in= CURDATE() WHERE YIS.STOKI.address_id='
				.$this->address_id.' AND YIS.STOKI.data = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1';
			    //print_r($this->sql); 
			break;
case "AppPodogrevIns":
				 $this->sql='UPDATE YIS.PODOGREV SET zadol='
				.$this->zadol.',YIS.PODOGREV.people='
				.$this->people.',YIS.PODOGREV.kub='
				.$this->kub.',YIS.PODOGREV.gkal='
				.$this->gkal.',YIS.PODOGREV.tarif='
				.$this->tarif.',YIS.PODOGREV.norma='
				.$this->norma.',YIS.PODOGREV.podogrev='
				.$this->podogrev.',YIS.PODOGREV.perer='
				.$this->perer.',YIS.PODOGREV.nachisleno='
				.$this->nachisleno.',YIS.PODOGREV.gkub_lg='
				.$this->gkub_lg.',YIS.PODOGREV.budjet='
				.$this->budjet.',YIS.PODOGREV.pbudjet='
				.$this->pbudjet.',YIS.PODOGREV.oplacheno='
				.$this->oplacheno.',YIS.PODOGREV.dolg='
				.$this->dolg.',YIS.PODOGREV.operator="'
				.$this->login.'",YIS.PODOGREV.data_in= CURDATE() WHERE YIS.PODOGREV.address_id='
				.$this->address_id.' AND YIS.PODOGREV.data = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1';
			    //print_r($this->sql); 
			break;
	case "AppOtoplenieIns":
				 $this->sql='UPDATE YIS.OTOPLENIE SET zadol='
				.$this->zadol.',YIS.OTOPLENIE.square='
				.$this->square.',YIS.OTOPLENIE.gkal='
				.$this->gkal.',YIS.OTOPLENIE.gkm2='
				.$this->gkm2.',YIS.OTOPLENIE.gkm2_mop='
				.$this->gkm2_mop.',YIS.OTOPLENIE.gkal_mop='
				.$this->gkal_mop.',YIS.OTOPLENIE.tarif='
				.$this->tarif.',YIS.OTOPLENIE.mop='
				.$this->mop.',YIS.OTOPLENIE.otoplenie='
				.$this->otoplenie.',YIS.OTOPLENIE.perer='
				.$this->perer.',YIS.OTOPLENIE.nachisleno='
				.$this->nachisleno.',YIS.OTOPLENIE.square_lg='
				.$this->square_lg.',YIS.OTOPLENIE.budjet='
				.$this->budjet.',YIS.OTOPLENIE.pbudjet='
				.$this->pbudjet.',YIS.OTOPLENIE.budjet_mop='
				.$this->budjet_mop.',YIS.OTOPLENIE.oplacheno='
				.$this->oplacheno.',YIS.OTOPLENIE.dolg='
				.$this->dolg.',YIS.OTOPLENIE.operator="'
				.$this->login.'",YIS.OTOPLENIE.data_in= CURDATE() WHERE YIS.OTOPLENIE.address_id='
				.$this->address_id.' AND YIS.OTOPLENIE.data = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1';
			    //print_r($this->sql); 
			break;
	case "AppKvartplataIns":
				 $this->sql='UPDATE YIS.KVARTPLATA SET zadol='
				.$this->zadol.',YIS.KVARTPLATA.square='
				.$this->square.',YIS.KVARTPLATA.kvartplata='
				.$this->kvartplata.',YIS.KVARTPLATA.dop='
				.$this->dop.',YIS.KVARTPLATA.tarif='
				.$this->tarif.',YIS.KVARTPLATA.perer='
				.$this->perer.',YIS.KVARTPLATA.nachisleno='
				.$this->nachisleno.',YIS.KVARTPLATA.square_lg='
				.$this->square_lg.',YIS.KVARTPLATA.budjet='
				.$this->budjet.',YIS.KVARTPLATA.pbudjet='
				.$this->pbudjet.',YIS.KVARTPLATA.oplacheno='
				.$this->oplacheno.',YIS.KVARTPLATA.dolg='
				.$this->dolg.',YIS.KVARTPLATA.operator="'
				.$this->login.'",YIS.KVARTPLATA.data_in= CURDATE() WHERE YIS.KVARTPLATA.address_id='
				.$this->address_id.' AND YIS.KVARTPLATA.data = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1';
			    //print_r($this->sql); 
			break;
	case "AppTboIns":
				 $this->sql='UPDATE YIS.TBO SET zadol='
				.$this->zadol.',YIS.TBO.people='
				.$this->people.',YIS.TBO.tbo='
				.$this->tbo.',YIS.TBO.tarif='
				.$this->tarif.',YIS.TBO.perer='
				.$this->perer.',YIS.TBO.nachisleno='
				.$this->nachisleno.',YIS.TBO.people_lg='
				.$this->people_lg.',YIS.TBO.budjet='
				.$this->budjet.',YIS.TBO.pbudjet='
				.$this->pbudjet.',YIS.TBO.oplacheno='
				.$this->oplacheno.',YIS.TBO.dolg='
				.$this->dolg.',YIS.TBO.operator="'
				.$this->login.'",YIS.TBO.data_in= CURDATE() WHERE YIS.TBO.address_id='
				.$this->address_id.' AND YIS.TBO.data = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1';
			    //print_r($this->sql); 
			break;
	case "addLgotaVoda":
			      $this->sql='CALL YISGRAND.addLgotaVoda('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->chekInput.'","'
										      .$this->chekVoda.'","'
										      .$this->checkType.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "addLgotaStoki":
			      $this->sql='CALL YISGRAND.addLgotaStoki('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->chekInput.'","'
										      .$this->chekVoda.'","'
										      .$this->checkType.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "addLgotaPodogrev":
			      $this->sql='CALL YISGRAND.addLgotaPodogrev('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->chekInput.'","'
										      .$this->chekVoda.'","'
										      .$this->checkType.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "addLgotaOtoplenie":
			      $this->sql='CALL YISGRAND.addLgotaOtoplenie('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->chekInput.'","'
										      .$this->checkType.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "addLgotaKvartplata":
			      $this->sql='CALL YISGRAND.addLgotaKvartplata('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->chekInput.'","'
										      .$this->checkType.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "addLgotaTbo":
			      $this->sql='CALL YISGRAND.addLgotaTbo('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->chekInput.'","'
										      .$this->checkType.'","'
										      .$this->info.'",'
										      .'@success,@msg)';

			break;
	case "addLgotaPererVoda":
			      $this->sql='CALL YISGRAND.addLgotaPererVoda('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "addLgotaPererStoki":
			      $this->sql='CALL YISGRAND.addLgotaPererStoki('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "addLgotaPererPodogrev":
			      $this->sql='CALL YISGRAND.addLgotaPererPodogrev('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "addLgotaPererOtoplenie":
			      $this->sql='CALL YISGRAND.addLgotaPererOtoplenie('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "addLgotaPererKvartplata":
			      $this->sql='CALL YISGRAND.addLgotaPererKvartplata('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "addLgotaPererTbo":
			      $this->sql='CALL YISGRAND.addLgotaPererTbo('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';

			break;
	case "editLgotaVoda":
			      $this->sql='CALL YISGRAND.editLgotaVoda('
										      .$this->rec_id.','
										      .$this->address_id.',"'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "editLgotaStoki":
			      $this->sql='CALL YISGRAND.editLgotaStoki('
										      .$this->rec_id.','
										      .$this->address_id.',"'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			  // print_r($this->sql); 

			break;

	case "editLgotaPodogrev":
			      $this->sql='CALL YISGRAND.editLgotaPodogrev('
										      .$this->rec_id.','
										      .$this->address_id.',"'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "editLgotaOtoplenie":
			      $this->sql='CALL YISGRAND.editLgotaOtoplenie('
										      .$this->rec_id.','
										      .$this->address_id.',"'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "editLgotaKvartplata":
			      $this->sql='CALL YISGRAND.editLgotaKvartplata('
										      .$this->rec_id.','
										      .$this->address_id.',"'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	case "editLgotaTbo":
			      $this->sql='CALL YISGRAND.editLgotaTbo('
										      .$this->rec_id.','
										      .$this->address_id.',"'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';

			break;
		case "addLgotnik":
			      $this->sql='CALL YISGRAND.addLgotnik('
										      .$this->lgota_id.','
										      .$this->address_id.',"'
										      .$this->address.'","'
										      .$this->surname.'","'
										      .$this->firstname.'","'
										      .$this->lastname.'","'
										      .$this->surname_ua.'","'
										      .$this->firstname_ua.'","'
										      .$this->lastname_ua.'","'
										      .$this->kartochka.'","'
										      .$this->inn.'","'
										      .$this->passport.'","'
										      .$this->document.'","'
										      .$this->data.'","'
										      .$this->given.'","'
										      .$this->people.'","'
													.$this->percent.'","'
										      .$this->vkl.'",'
										      .'@success,@msg)';
			break;
			case "editLgotnik":
			      $this->sql='CALL YISGRAND.editLgotnik('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.',"'
										      .$this->surname.'","'
										      .$this->firstname.'","'
										      .$this->lastname.'","'
										      .$this->surname_ua.'","'
										      .$this->firstname_ua.'","'
										      .$this->lastname_ua.'","'
										      .$this->kartochka.'","'
										      .$this->inn.'","'
										      .$this->passport.'","'
										      .$this->document.'","'
										      .$this->data.'","'
										      .$this->given.'","'
										      .$this->people.'","'
													.$this->percent.'","'
										      .$this->vkl.'",'
										      .'@success,@msg)';
			break;
			case "delLgotaVodaPerer":
			      $this->sql='CALL YISGRAND.delLgotaVodaPerer('.$this->rec_id.',@success,@msg)';
			break;
   			case "delLgotaStokiPerer":
			      $this->sql='CALL YISGRAND.delLgotaStokiPerer('.$this->rec_id.',@success,@msg)';
			break;
			case "delLgotaPodogrevPerer":
			      $this->sql='CALL YISGRAND.delLgotaPodogrevPerer('.$this->rec_id.',@success,@msg)';
			break;
			case "delLgotaOtopleniePerer":
			      $this->sql='CALL YISGRAND.delLgotaOtopleniePerer('.$this->rec_id.',@success,@msg)';
			break;
   			case "delLgotaKvartplataPerer":
			      $this->sql='CALL YISGRAND.delLgotaKvartplataPerer('.$this->rec_id.',@success,@msg)';
			break;
			case "delLgotaTboPerer":
			      $this->sql='CALL YISGRAND.delLgotaTboPerer('.$this->rec_id.',@success,@msg)';
			break;
			case "delLgotaVoda":
			      $this->sql='CALL YISGRAND.delLgotaVoda('.$this->rec_id.',@success,@msg)';
			break;
   			case "delLgotaStoki":
			      $this->sql='CALL YISGRAND.delLgotaStoki('.$this->rec_id.',@success,@msg)';
			break;
			case "delLgotaPodogrev":
			      $this->sql='CALL YISGRAND.delLgotaPodogrev('.$this->rec_id.',@success,@msg)';
			break;
			case "delLgotaOtoplenie":
			      $this->sql='CALL YISGRAND.delLgotaOtoplenie('.$this->rec_id.',@success,@msg)';
			break;
   			case "delLgotaKvartplata":
			      $this->sql='CALL YISGRAND.delLgotaKvartplata('.$this->rec_id.',@success,@msg)';
			break;
			case "delLgotaTbo":
			      $this->sql='CALL YISGRAND.delLgotaTbo('.$this->rec_id.',@success,@msg)';
			break;
		case "nachislenie_voda":
			       $this->sql='CALL YISGRAND.nachislenie_voda(@success,@msg)';				    
			break;
		case "pereraschet_voda_stoki":
			      $this->sql='CALL YISGRAND.pereraschet_voda_stoki("'
										      .$this->house_id.'","'
										      .$this->allkv.'","'
										      .$this->tarif_manual.'","'
										      .$this->address_ot.'","'
										      .$this->address_do.'","'
													.$this->xv9.'","'
										      .$this->ch_xv9.'","'
													.$this->st9.'","'
													.$this->ch_st9.'","'
										      .$this->xv16.'","'
										      .$this->ch_xv16.'","'
										      .$this->st16.'","'
										      .$this->ch_st16.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			  //  print_r($this->sql); 

			break;
			case "nachislenie_kvartplata":
			       $this->sql='CALL YISGRAND.nachislenie_kvartplata(@success,@msg)';				    
			break;
			
			case "pereraschet_kvartplata":
			      $this->sql='CALL YISGRAND.pereraschet_kvartplata("'
										      .$this->house_id.'","'
										      .$this->allkv.'","'
										      .$this->tarif_manual.'","'
										      .$this->address_ot.'","'
										      .$this->address_do.'","'
													.$this->kv9.'","'
										      .$this->ch_kv9.'","'
													.$this->kv9f1.'","'
													.$this->ch_kv9f1.'","'
										      .$this->kv16.'","'
										      .$this->ch_kv16.'","'
										      .$this->kv16f1.'","'
										      .$this->ch_kv16f1.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			  //  print_r($this->sql); 

			break;
			case "nachislenie_tbo":
			       $this->sql='CALL YISGRAND.nachislenie_tbo(@success,@msg)';				    
			break;
			
			case "pereraschet_tbo":
			      $this->sql='CALL YISGRAND.pereraschet_tbo("'
										      .$this->house_id.'","'
										      .$this->allkv.'","'
										      .$this->tarif_manual.'","'
										      .$this->address_ot.'","'
										      .$this->address_do.'","'
													.$this->tbo.'","'
										      .$this->ch_tbo.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			  //  print_r($this->sql); 

			break;
		case "newAddress":
			      $this->sql='CALL YISGRAND.newAddress("'
										      .$this->qtykv.'","'
										      .$this->nomerkv.'","'
										      .$this->raion_id.'","'
										      .$this->street_id.'","'
													.$this->house_id.'","'
													.$this->kvartplata.'","'
													.$this->tbo.'","'
										      .$this->voda.'","'
										      .$this->stoki.'","'
										      .$this->podogrev.'","'
										      .$this->otoplenie.'",'
										      .'@success,@msg)';
			    //print_r($this->sql); 

			break;
		case "newHouse":
			      $this->sql='CALL YISGRAND.newHouse("'
										      .$this->newhouse.'","'
										      .$this->nomer.'","'
										      .$this->raion_id.'","'
										      .$this->street_id.'",'
 									       .'@new_id,@new_name,@success,@msg)';
			    //print_r($this->sql); 

			break;
	case "newStreet":
			      $this->sql='CALL YISGRAND.newStreet("'
										      .$this->newStreet.'","'
										      .$this->abbr.'",'
										      .$this->privat.','
 									       .'@new_id,@new_name,@success,@msg)';
			    //print_r($this->sql); 

			break;
case "newRaion":
			      $this->sql='CALL YISGRAND.newRaion("'
										      .$this->newRaion.'",'
 									       .'@new_id,@new_name,@success,@msg)';
			    //print_r($this->sql); 

			break;
case "ExportBudjetEmail":
			      $this->sql='CALL YISGRAND.ExportBudjetEmail("'
										      .$this->rbUsluga.'","'
										      .$this->data.'",'
 									       .'@success,@msg)';
			    //print_r($this->sql); 

			break;

		} // End of Switch ($what)  

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @new_id,@new_name,@success, @msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg'] = $this->row['@msg'];
			$this->results['new_id'] = $this->row['@new_id'];
			$this->results['new_name'] = $this->row['@new_name'];
		}
		
		return $this->results;

	} // ================================= UPDATE RECORDS


	}