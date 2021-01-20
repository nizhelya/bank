<?php
include_once './yis_config.php';

class QueryKassa
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
	protected $type;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $kub;
	protected $t; 
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


		if(isset($params->login) && ($params->login)) {
		  $this->login= addslashes($params->login);
		} else {
		   $this->login= null;
		}
		
			$_db = $this->__construct();

			$this->prixod = PRIXOD;
		  $this->bank = BANK;
		  $this->admin = ADMIN;

		
		if(isset($params->what) && ($params->what)) {
		 $this->what = $_db->real_escape_string($params->what);
		} else {
		  $this->what = null;
		}
	
		if(isset($params->tbank) && ($params->tbank)) {
		 $this->tbank = $_db->real_escape_string($params->tbank);
		} else {
		  $this->tbank = "";
		}
		if(isset($params->address_id) && ($params->address_id)) {
		  $this->address_id = (int) $params->address_id;
		} else {
		  $this->address_id = 0;
		}
		if(isset($params->house_id) && ($params->house_id)) {
		  $this->house_id = (int) $params->house_id;
		} else {
		  $this->house_id = 0;
		}
		if(isset($params->user_id) && ($params->user_id)) {
		  $this->user_id = (int) $params->user_id;
		} else {
		  $this->user_id = 0;
		}
		if(isset($params->raion_id) && ($params->raion_id)) {
		  $this->raion_id = (int) $params->raion_id;
		} else {
		  $this->raion_id = 0;
		}
		if(isset($params->role) && ($params->role)) {
		  $this->role = $params->role;
		} else {
		  $this->role = "";
		}
		if(isset($params->data) && ($params->data)) {
		  $this->data =$params->data;
		 // $this->data =preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$params->data);
		} else {
		  $this->data= date("Ymd");
		}
		if(isset($params->what_id) && ($params->what_id)) {
		  $this->id = (int) $params->what_id;
		} else {
		  $this->id = 0;
		}
		$this->t= date('Ymd');
		
		switch ($this->what) {

			
			case "TekNachAllApp":		  
			   if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subs as subs1,t2.subs as subs2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.subs + t2.subs as subs,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.'  AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") ';
				} else {
				if ($this->house_id == 22  ) {

				$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t8.mec,t8.god) as period8,CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5,'
					      .'CONCAT_WS(" ",t6.mec,t6.god) as period6, CONCAT_WS(" ",t7.mec,t7.god) as period7,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t8.zadol as zadol8,t4.zadol as zadol4,t5.zadol as zadol5,'
					      .'t6.zadol -t6.kzadol  as zadol6,t7.zadol as zadol7,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t8.zadol + t4.zadol  + t5.zadol + t6.zadol -t6.kzadol + t7.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,t8.nachisleno as nachisleno8,'
					      .'t4.nachisleno  as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno - t6.knachisleno + t6.koplata as nachisleno6,t7.nachisleno as nachisleno7,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t8.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno + t7.nachisleno as nachisleno,'
					      .'(t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .'(t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,(t7.budjet+t7.pbudjet) as budjet7,'
					      .'((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .'(t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet) + (t7.budjet+t7.pbudjet)) as budjet ,'
					      .'t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, t8.oplacheno as oplacheno8, '
					      .'t4.oplacheno  as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,t7.oplacheno as oplacheno7,'
					      .'t1.oplacheno+t2.oplacheno+t3.oplacheno +t8.oplacheno + t4.oplacheno +t5.oplacheno+t6.oplacheno +t7.oplacheno as oplacheno,'
					      .'t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, t7.subsidia as subsidia7,'
					      .'t1.subs as subs1,t2.subs as subs2,t3.subs as subs3,t4.subs as subs4,t5.subs as subs5,t6.subs as subs6,t7.subs as subs7, '
					      .'t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia +t7.subsidia as subsidia,t1.subs+t2.subs+t3.subs+t4.subs+'
					      .'t5.subs+t6.subs +t7.subs as subs,'
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t8.dolg as dolg8,t4.dolg as dolg4,t5.dolg as dolg5,'
					      .'t6.dolg-t6.kdolg as dolg6 ,t7.dolg as dolg7 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t8.dolg +t4.dolg   +t5.dolg+t6.dolg -t6.kdolg +t7.dolg  as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,OSBB.KVARTPLATA as t3,OSBB.TBO as t4,YIS.PODOGREV as t5,YIS.OTOPLENIE as t6 ,YIS.PTN as t7 ,OSBB.RFOND as t8 '
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.' AND t3.address_id='.$this->address_id.' '
					      .' AND t4.address_id='.$this->address_id.' AND t5.address_id='.$this->address_id.'  AND t6.address_id='.$this->address_id.' AND '
					      .' t7.address_id='.$this->address_id.' AND t8.address_id='.$this->address_id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") AND t7.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") AND '
					      .' t8.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")';
					      
					      }else{
					      $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t3.mec,t3.god) as period8,CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5,'
					      .'CONCAT_WS(" ",t6.mec,t6.god) as period6, CONCAT_WS(" ",t7.mec,t7.god) as period7,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t3.rzadol as zadol8,t4.zadol as zadol4,t5.zadol as zadol5,'
					      .'t6.zadol -t6.kzadol  as zadol6,t7.zadol as zadol7,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t3.rzadol + t4.zadol  + t5.zadol + t6.zadol -t6.kzadol + t7.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,t3.remont as nachisleno8,'
					      .'t4.nachisleno  as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno - t6.knachisleno + t6.koplata as nachisleno6,t7.nachisleno as nachisleno7,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t3.remont + t4.nachisleno + t5.nachisleno + t6.nachisleno + t7.nachisleno as nachisleno,'
					      .'(t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .'(t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,(t7.budjet+t7.pbudjet) as budjet7,'
					      .'((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .'(t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet) + (t7.budjet+t7.pbudjet)) as budjet ,'
					      .'t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, t3.roplacheno as oplacheno8, '
					      .'t4.oplacheno  as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,t7.oplacheno as oplacheno7,'
					      .'t1.oplacheno+t2.oplacheno+t3.oplacheno +t3.roplacheno + t4.oplacheno +t5.oplacheno+t6.oplacheno +t7.oplacheno as oplacheno,'
					      .'t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, t7.subsidia as subsidia7,'
					      .'t1.subs as subs1,t2.subs as subs2,t3.subs as subs3,t4.subs as subs4,t5.subs as subs5,t6.subs as subs6,t7.subs as subs7, '
					      .'t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia +t7.subsidia as subsidia,t1.subs+t2.subs+t3.subs+t4.subs+'
					      .'t5.subs+t6.subs +t7.subs as subs,'
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t3.rdolg as dolg8,t4.dolg as dolg4,t5.dolg as dolg5,t3.fdolg,t3.fdolg as dolg9,t3.ddolg,'
					      .'t3.ddolg as dolg10,t6.dolg-t6.kdolg as dolg6 ,t7.dolg as dolg7 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t3.rdolg +t4.dolg   +t5.dolg+t6.dolg -t6.kdolg +t7.dolg  as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.KVARTPLATA as t3,YIS.TBO as t4,YIS.PODOGREV as t5,YIS.OTOPLENIE as t6 ,YIS.PTN as t7  '
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.' AND t3.address_id='.$this->id.'  AND t4.address_id='.$this->id.' AND '
					      .' t5.address_id='.$this->id.'  AND t6.address_id='.$this->id.' AND t7.address_id='.$this->id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") AND t7.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")';
					      }
			// print_r($this->sql); 

				}
		    break;
		      case "TekNachAllApp1":		  
			   if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subs as subs1,t2.subs as subs2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.subs + t2.subs as subs,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.'  AND '
					      .'t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01") ';
				} else {
				if ($this->house_id == 22  ) {

				$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t8.mec,t8.god) as period8,CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5,'
					      .'CONCAT_WS(" ",t6.mec,t6.god) as period6, CONCAT_WS(" ",t7.mec,t7.god) as period7,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t8.zadol as zadol8,t4.zadol as zadol4,t5.zadol as zadol5,'
					      .'t6.zadol -t6.kzadol  as zadol6,t7.zadol as zadol7,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t8.zadol + t4.zadol  + t5.zadol + t6.zadol -t6.kzadol + t7.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,t8.nachisleno as nachisleno8,'
					      .'t4.nachisleno  as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno - t6.knachisleno + t6.koplata as nachisleno6,t7.nachisleno as nachisleno7,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t8.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno + t7.nachisleno as nachisleno,'
					      .'(t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .'(t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,(t7.budjet+t7.pbudjet) as budjet7,'
					      .'((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .'(t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet) + (t7.budjet+t7.pbudjet)) as budjet ,'
					      .'t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, t8.oplacheno as oplacheno8, '
					      .'t4.oplacheno  as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,t7.oplacheno as oplacheno7,'
					      .'t1.oplacheno+t2.oplacheno+t3.oplacheno +t8.oplacheno + t4.oplacheno +t5.oplacheno+t6.oplacheno +t7.oplacheno as oplacheno,'
					      .'t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, t7.subsidia as subsidia7,'
					      .'t1.subs as subs1,t2.subs as subs2,t3.subs as subs3,t4.subs as subs4,t5.subs as subs5,t6.subs as subs6,t7.subs as subs7, '
					      .'t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia +t7.subsidia as subsidia,t1.subs+t2.subs+t3.subs+t4.subs+'
					      .'t5.subs+t6.subs +t7.subs as subs,'
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t8.dolg as dolg8,t4.dolg as dolg4,t5.dolg as dolg5,'
					      .'t6.dolg-t6.kdolg as dolg6 ,t7.dolg as dolg7 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t8.dolg +t4.dolg   +t5.dolg+t6.dolg -t6.kdolg +t7.dolg  as dolg '					      
					     .'FROM YIS.VODA as t1,YIS.STOKI as t2, OSBB.KVARTPLATA as t3,OSBB.TBO as t4,YIS.PODOGREV as t5,YIS.OTOPLENIE as t6 ,YIS.PTN as t7 ,OSBB.RFOND as t8 '
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.' AND t3.address_id='.$this->address_id.' '
					      .' AND t4.address_id='.$this->address_id.' AND t5.address_id='.$this->address_id.'  AND t6.address_id='.$this->address_id.' AND '
					      .' t7.address_id='.$this->address_id.' AND t8.address_id='.$this->address_id.' AND '
					      .'t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01") AND '
					      .'t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t7.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t8.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")';
				}else{	      
				$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t3.mec,t3.god) as period8,CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5,'
					      .'CONCAT_WS(" ",t6.mec,t6.god) as period6, CONCAT_WS(" ",t7.mec,t7.god) as period7,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t3.rzadol as zadol8,t4.zadol as zadol4,t5.zadol as zadol5,'
					      .'t6.zadol -t6.kzadol  as zadol6,t7.zadol as zadol7,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t3.rzadol + t4.zadol  + t5.zadol + t6.zadol -t6.kzadol + t7.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,t3.remont as nachisleno8,'
					      .'t4.nachisleno  as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno - t6.knachisleno + t6.koplata as nachisleno6,t7.nachisleno as nachisleno7,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t3.remont + t4.nachisleno + t5.nachisleno + t6.nachisleno + t7.nachisleno as nachisleno,'
					      .'(t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .'(t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,(t7.budjet+t7.pbudjet) as budjet7,'
					      .'((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .'(t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet) + (t7.budjet+t7.pbudjet)) as budjet ,'
					      .'t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, t3.roplacheno as oplacheno8, '
					      .'t4.oplacheno  as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,t7.oplacheno as oplacheno7,'
					      .'t1.oplacheno+t2.oplacheno+t3.oplacheno +t3.roplacheno + t4.oplacheno +t5.oplacheno+t6.oplacheno +t7.oplacheno as oplacheno,'
					      .'t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, t7.subsidia as subsidia7,'
					      .'t1.subs as subs1,t2.subs as subs2,t3.subs as subs3,t4.subs as subs4,t5.subs as subs5,t6.subs as subs6,t7.subs as subs7, '
					      .'t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia +t7.subsidia as subsidia,t1.subs+t2.subs+t3.subs+t4.subs+'
					      .'t5.subs+t6.subs +t7.subs as subs,'
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t3.rdolg as dolg8,t4.dolg as dolg4,t5.dolg as dolg5,t3.fdolg,t3.fdolg as dolg9,t3.ddolg,'
					      .'t3.ddolg as dolg10,t6.dolg-t6.kdolg as dolg6 ,t7.dolg as dolg7 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t3.rdolg +t4.dolg   +t5.dolg+t6.dolg -t6.kdolg +t7.dolg  as dolg '		      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.KVARTPLATA as t3,YIS.TBO as t4,YIS.PODOGREV as t5,YIS.OTOPLENIE as t6 ,YIS.PTN as t7  '
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.' AND t3.address_id='.$this->id.'  AND t4.address_id='.$this->id.' AND '
					      .' t5.address_id='.$this->id.'  AND t6.address_id='.$this->id.' AND t7.address_id='.$this->id.' AND '
					      .'t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01") AND '
					      .'t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t7.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")';
				}	      
			 //  print_r($this->sql); 

				}
		    break;
		    case "TekNachAllApp2":		  
			    if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subs as subs1,t2.subs as subs2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.subs + t2.subs as subs,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.'  AND '
					      .'t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01") ';
				} else {
				if ($this->house_id == 22  ) {

				$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t8.mec,t8.god) as period8,CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5,'
					      .'CONCAT_WS(" ",t6.mec,t6.god) as period6, CONCAT_WS(" ",t7.mec,t7.god) as period7,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t8.zadol as zadol8,t4.zadol as zadol4,t5.zadol as zadol5,'
					      .'t6.zadol -t6.kzadol  as zadol6,t7.zadol as zadol7,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t8.zadol + t4.zadol  + t5.zadol + t6.zadol -t6.kzadol + t7.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,t8.nachisleno as nachisleno8,'
					      .'t4.nachisleno  as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno - t6.knachisleno + t6.koplata as nachisleno6,t7.nachisleno as nachisleno7,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t8.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno + t7.nachisleno as nachisleno,'
					      .'(t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .'(t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,(t7.budjet+t7.pbudjet) as budjet7,'
					      .'((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .'(t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet) + (t7.budjet+t7.pbudjet)) as budjet ,'
					      .'t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, t8.oplacheno as oplacheno8, '
					      .'t4.oplacheno  as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,t7.oplacheno as oplacheno7,'
					      .'t1.oplacheno+t2.oplacheno+t3.oplacheno +t8.oplacheno + t4.oplacheno +t5.oplacheno+t6.oplacheno +t7.oplacheno as oplacheno,'
					      .'t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, t7.subsidia as subsidia7,'
					      .'t1.subs as subs1,t2.subs as subs2,t3.subs as subs3,t4.subs as subs4,t5.subs as subs5,t6.subs as subs6,t7.subs as subs7, '
					      .'t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia +t7.subsidia as subsidia,t1.subs+t2.subs+t3.subs+t4.subs+'
					      .'t5.subs+t6.subs +t7.subs as subs,'
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t8.dolg as dolg8,t4.dolg as dolg4,t5.dolg as dolg5,'
					      .'t6.dolg-t6.kdolg as dolg6 ,t7.dolg as dolg7 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t8.dolg +t4.dolg   +t5.dolg+t6.dolg -t6.kdolg +t7.dolg  as dolg '					      
					       .'FROM YIS.VODA as t1,YIS.STOKI as t2, OSBB.KVARTPLATA as t3,OSBB.TBO as t4,YIS.PODOGREV as t5,YIS.OTOPLENIE as t6 ,YIS.PTN as t7 ,OSBB.RFOND as t8 '
					      .' WHERE t1.address_id='.$this->address_id.'  AND t2.address_id='.$this->address_id.' AND t3.address_id='.$this->address_id.' '
					      .' AND t4.address_id='.$this->address_id.' AND t5.address_id='.$this->address_id.'  AND t6.address_id='.$this->address_id.' AND '
					      .' t7.address_id='.$this->address_id.' AND t8.address_id='.$this->address_id.' AND '
					      .'t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01") AND '
					      .'t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t7.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t8.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")';
				}else{	      
				$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t3.mec,t3.god) as period8,CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5,'
					      .'CONCAT_WS(" ",t6.mec,t6.god) as period6, CONCAT_WS(" ",t7.mec,t7.god) as period7,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t3.rzadol as zadol8,t4.zadol as zadol4,t5.zadol as zadol5,'
					      .'t6.zadol -t6.kzadol  as zadol6,t7.zadol as zadol7,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t3.rzadol + t4.zadol  + t5.zadol + t6.zadol -t6.kzadol + t7.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,t3.remont as nachisleno8,'
					      .'t4.nachisleno  as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno - t6.knachisleno + t6.koplata as nachisleno6,t7.nachisleno as nachisleno7,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t3.remont + t4.nachisleno + t5.nachisleno + t6.nachisleno + t7.nachisleno as nachisleno,'
					      .'(t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .'(t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,(t7.budjet+t7.pbudjet) as budjet7,'
					      .'((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .'(t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet) + (t7.budjet+t7.pbudjet)) as budjet ,'
					      .'t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, t3.roplacheno as oplacheno8, '
					      .'t4.oplacheno  as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,t7.oplacheno as oplacheno7,'
					      .'t1.oplacheno+t2.oplacheno+t3.oplacheno +t3.roplacheno + t4.oplacheno +t5.oplacheno+t6.oplacheno +t7.oplacheno as oplacheno,'
					      .'t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, t7.subsidia as subsidia7,'
					      .'t1.subs as subs1,t2.subs as subs2,t3.subs as subs3,t4.subs as subs4,t5.subs as subs5,t6.subs as subs6,t7.subs as subs7, '
					      .'t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia +t7.subsidia as subsidia,t1.subs+t2.subs+t3.subs+t4.subs+'
					      .'t5.subs+t6.subs +t7.subs as subs,'
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t3.rdolg as dolg8,t4.dolg as dolg4,t5.dolg as dolg5,t3.fdolg,t3.fdolg as dolg9,t3.ddolg,'
					      .'t3.ddolg as dolg10,t6.dolg-t6.kdolg as dolg6 ,t7.dolg as dolg7 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t3.rdolg +t4.dolg   +t5.dolg+t6.dolg -t6.kdolg +t7.dolg  as dolg '				      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.KVARTPLATA as t3,YIS.TBO as t4,YIS.PODOGREV as t5,YIS.OTOPLENIE as t6 ,YIS.PTN as t7  '
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.' AND t3.address_id='.$this->id.'  AND t4.address_id='.$this->id.' AND '
					      .' t5.address_id='.$this->id.'  AND t6.address_id='.$this->id.' AND t7.address_id='.$this->id.' AND '
					      .'t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01") AND '
					      .'t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t7.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")';
					      }
			 //  print_r($this->sql); 
			  }
		    break;
				case "AppTekOplata":

			 $this->sql=' SELECT t4.`rec_id`,t4.`address_id`,t4.`address`,t4.`god`,t4.`data`,t4.`kvartplata`,t4.`remont`,t4.`otoplenie`,t4.`podogrev`,t4.`ptn`,t4.`voda`,t4.`stoki`, '
			 .' t4.`tbo`,t4.`summa`,t4.`prixod`,t4.`kassa`,t4.`nomer`,t4.`operator`,t4.`data_in` ,chek  from '
			 .' (SELECT t1.`rec_id`,t1.`address_id`,t1.`address`,t1.`god`,t1.`data`,t1.`kvartplata`,t1.`remont`,t1.`otoplenie`,t1.`podogrev`,t1.`ptn`,t1.`voda`,t1.`stoki`,'
			 .' t1.`tbo`,t1.`summa`,t1.`prixod`,t1.`kassa`,t1.`nomer`,t1.`operator`,t1.`data_in` ,  CASE WHEN (t1.`data` = "'.$this->t.'" AND t1.`operator` = "'.$this->login.'") OR  '
			 .' (((SELECT t2.`role` FROM YISGRAND.'.$this->tbank.'USERS as t2  WHERE t2.`user_id` = '.$this->user_id.') = "Админ") AND  EXTRACT(YEAR_MONTH FROM t1.`data`) = EXTRACT(YEAR_MONTH FROM curdate())) '
			 .' THEN 1 ELSE 0 END as chek  FROM YIS.OPLATA as t1  WHERE t1.`address_id`='.$this->id.''
			 .' UNION ALL '
			 .' SELECT t3.`rec_id`,t3.`address_id`,t3.`address`,t3.`god`,t3.`data`,t3.`kvartplata`,t3.`rfond`,t3.`otoplenie`,t3.`podogrev`,t3.`ptn`,t3.`voda`,t3.`stoki`, '
			 .' t3.`tbo`,t3.`summa`,t3.`prixod`,t3.`kassa`,t3.`nomer`,t3.`operator`,t3.`data_in` ,  CASE WHEN (t3.`data` = "'.$this->t.'" AND t3.`operator` = "'.$this->login.'") OR  '
			 .' (((SELECT t5.`role` FROM YISGRAND.'.$this->tbank.'USERS as t5  WHERE t5.`user_id` = '.$this->user_id.') = "Админ") AND  EXTRACT(YEAR_MONTH FROM t3.`data`) = EXTRACT(YEAR_MONTH FROM curdate()))  '
			 .' THEN 1 ELSE 0 END as chek  FROM OSBB.OPLATA as t3  WHERE t3.`address_id`='.$this->id.' ) AS t4 ORDER BY t4.`data` DESC LIMIT 2';
			
		//print($this->sql);   
		    break;
			case "AppTekOplataFive":

			  $this->sql=' SELECT t4.`rec_id`,t4.`address_id`,t4.`address`,t4.`god`,t4.`data`,t4.`kvartplata`,t4.`remont`,t4.`otoplenie`,t4.`podogrev`,t4.`ptn`,t4.`voda`,t4.`stoki`, '
			 .' t4.`tbo`,t4.`summa`,t4.`prixod`,t4.`kassa`,t4.`nomer`,t4.`operator`,t4.`data_in` ,chek  from '
			 .' (SELECT t1.`rec_id`,t1.`address_id`,t1.`address`,t1.`god`,t1.`data`,t1.`kvartplata`,t1.`remont`,t1.`otoplenie`,t1.`podogrev`,t1.`ptn`,t1.`voda`,t1.`stoki`,'
			 .' t1.`tbo`,t1.`summa`,t1.`prixod`,t1.`kassa`,t1.`nomer`,t1.`operator`,t1.`data_in` ,  CASE WHEN (t1.`data` = "'.$this->t.'" AND t1.`operator` = "'.$this->login.'") OR  '
			 .' (((SELECT t2.`role` FROM YISGRAND.'.$this->tbank.'USERS as t2  WHERE t2.`user_id` = '.$this->user_id.') = "Админ") AND  EXTRACT(YEAR_MONTH FROM t1.`data`) = EXTRACT(YEAR_MONTH FROM curdate())) '
			 .' THEN 1 ELSE 0 END as chek  FROM YIS.OPLATA as t1  WHERE t1.`address_id`='.$this->id.''
			 .' UNION ALL '
			 .' SELECT t3.`rec_id`,t3.`address_id`,t3.`address`,t3.`god`,t3.`data`,t3.`kvartplata`,t3.`rfond`,t3.`otoplenie`,t3.`podogrev`,t3.`ptn`,t3.`voda`,t3.`stoki`, '
			 .' t3.`tbo`,t3.`summa`,t3.`prixod`,t3.`kassa`,t3.`nomer`,t3.`operator`,t3.`data_in` ,  CASE WHEN (t3.`data` = "'.$this->t.'" AND t3.`operator` = "'.$this->login.'") OR  '
			 .' (((SELECT t5.`role` FROM YISGRAND.'.$this->tbank.'USERS as t5  WHERE t5.`user_id` = '.$this->user_id.') = "Админ") AND  EXTRACT(YEAR_MONTH FROM t3.`data`) = EXTRACT(YEAR_MONTH FROM curdate()))  '
			 .' THEN 1 ELSE 0 END as chek  FROM OSBB.OPLATA as t3  WHERE t3.`address_id`='.$this->id.' ) AS t4 ORDER BY t4.`data` DESC LIMIT 10';
		//print($this->sql);   
		    break;
			case "AppVodomerKassa"://применяется
				  $this->sql='SELECT YIS.VODOMER.vodomer_id,'
					    .'YIS.VODOMER.address_id,'
					    .'YIS.VODOMER.address,'
					    .'YIS.VODOMER.house_id,'
					    .'YIS.VODOMER.out,'
					    .'YIS.VODOMER.voda,'
					    .'YIS.VODOMER.st,'
					    .'YIS.VODOMER.place,'
					    .'YIS.VODOMER.nomer,'
					    .'YIS.VODOMER.model_id,'
					    .'YIS.VODOMER.model,'
					    .'YIS.VODOMER.note,'
					    .'YIS.VODOMER.position '
					    .' FROM YIS.VODOMER '
					    .' WHERE YIS.VODOMER.address_id='.$this->id.'  AND YIS.VODOMER.spisan=0 AND YIS.VODOMER.out=0';
			break;

			case "TekPokTeplomerov":			
			      $this->sql='SELECT YIS.VODOMER.address_id,YIS.VODOMER.type,UCASE(YIS.VODOMER.place) as place,YIS.VODOMER.nomer,YIS.VODOMER.model,DATE_FORMAT(max(YIS.WATER.data),"%d-%m-%Y") as fdate,'
				      .'max(YIS.WATER.pred) as pred,max(YIS.WATER.tek) as tek,YIS.WATER.operator FROM YIS.VODOMER,YIS.WATER  WHERE YIS.VODOMER.address_id='.$this->id.' AND YIS.VODOMER.nomer= YIS.WATER.nomer AND '
				      .'YIS.WATER.address_id='.$this->id.' GROUP BY YIS.VODOMER.nomer,data ORDER BY YIS.WATER.pok_id DESC ';
			       //print_r($this->sql); 
			break;
		} // End of Switch ($what)
		
	
		

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		
		return $this->results;
	}

public function newOplata(stdClass $params)
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

		$_db = $this->__construct();

		if(isset($params->what) && ($params->what)) {
		 $this->what = $params->what;
		} else {
		  $this->what = null;
		}
		if(isset($params->cbDo1) && ($params->cbDo1)) {
		  $this->cbDo1 = (int) $params->cbDo1;
		} else {
		  $this->cbDo1 = 0;
		}
		if(isset($params->cbDo2) && ($params->cbDo2)) {
		  $this->cbDo2 = (int) $params->cbDo2;
		} else {
		  $this->cbDo2 = 0;
		}
		if(isset($params->cbDo3) && ($params->cbDo3)) {
		  $this->cbDo3 = (int) $params->cbDo3;
		} else {
		  $this->cbDo3 = 0;
		}
		if(isset($params->cbDo4) && ($params->cbDo4)) {
		  $this->cbDo4 = (int) $params->cbDo4;
		} else {
		  $this->cbDo4 = 0;
		}
		if(isset($params->cbDo5) && ($params->cbDo5)) {
		  $this->cbDo5 = (int) $params->cbDo5;
		} else {
		  $this->cbDo5 = 0;
		}
		if(isset($params->cbDo6) && ($params->cbDo6)) {
		  $this->cbDo6 = (int) $params->cbDo6;
		} else {
		  $this->cbDo6 = 0;
		}
		if(isset($params->cbDo7) && ($params->cbDo7)) {
		  $this->cbDo7 = (int) $params->cbDo7;
		} else {
		  $this->cbDo7 = 0;
		}
		if(isset($params->cbDo8) && ($params->cbDo8)) {
		  $this->cbDo8 = (int) $params->cbDo8;
		} else {
		  $this->cbDo8 = 0;
		}
		if(isset($params->cbNext1) && ($params->cbNext1)) {
		  $this->cbNext1 = (int) $params->cbNext1;
		} else {
		  $this->cbNext1 = 0;
		}
		if(isset($params->cbNext2) && ($params->cbNext2)) {
		  $this->cbNext2 = (int) $params->cbNext2;
		} else {
		  $this->cbNext2 = 0;
		}
		if(isset($params->cbNext3) && ($params->cbNext3)) {
		  $this->cbNext3 = (int) $params->cbNext3;
		} else {
		  $this->cbNext3 = 0;
		}
		if(isset($params->cbNext4) && ($params->cbNext4)) {
		  $this->cbNext4 = (int) $params->cbNext4;
		} else {
		  $this->cbNext4 = 0;
		}
		if(isset($params->cbNext5) && ($params->cbNext5)) {
		  $this->cbNext5 = (int) $params->cbNext5;
		} else {
		  $this->cbNext5 = 0;
		}
		if(isset($params->cbNext6) && ($params->cbNext6)) {
		  $this->cbNext6 = (int) $params->cbNext6;
		} else {
		  $this->cbNext6 = 0;
		}
		if(isset($params->cbNext7) && ($params->cbNext7)) {
		  $this->cbNext7 = (int) $params->cbNext7;
		} else {
		  $this->cbNext7 = 0;
		}
		if(isset($params->cbNext8) && ($params->cbNext8)) {
		  $this->cbNext8 = (int) $params->cbNext8;
		} else {
		  $this->cbNext8 = 0;
		}
		if(isset($params->zadol1) && ($params->zadol1)) {
		  $this->zadol1 =  $params->zadol1;
		} else {
		  $this->zadol1 = 0;
		}
		if(isset($params->zadol2) && ($params->zadol2)) {
		  $this->zadol2 =  $params->zadol2;
		} else {
		  $this->zadol2 = 0;
		}
		if(isset($params->zadol3) && ($params->zadol3)) {
		  $this->zadol3 =  $params->zadol3;
		} else {
		  $this->zadol3 = 0;
		}
		if(isset($params->zadol4) && ($params->zadol4)) {
		  $this->zadol4 =  $params->zadol4;
		} else {
		  $this->zadol4 = 0;
		}
		if(isset($params->zadol5) && ($params->zadol5)) {
		  $this->zadol5 =  $params->zadol5;
		} else {
		  $this->zadol5 = 0;
		}
		if(isset($params->zadol6) && ($params->zadol6)) {
		  $this->zadol6 =  $params->zadol6;
		} else {
		  $this->zadol6 = 0;
		}
		if(isset($params->zadol7) && ($params->zadol7)) {
		  $this->zadol7 =  $params->zadol7;
		} else {
		  $this->zadol7 = 0;
		}
		if(isset($params->zadol8) && ($params->zadol8)) {
		  $this->zadol8 =  $params->zadol8;
		} else {
		  $this->zadol8 = 0;
		}
		if(isset($params->dolg1) && ($params->dolg1)) {
		  $this->dolg1 =  $params->dolg1;
		} else {
		  $this->dolg1 = 0;
		}
		if(isset($params->dolg2) && ($params->dolg2)) {
		  $this->dolg2 =  $params->dolg2;
		} else {
		  $this->dolg2 = 0;
		}
		if(isset($params->dolg3) && ($params->dolg3)) {
		  $this->dolg3 =  $params->dolg3;
		} else {
		  $this->dolg3 = 0;
		}
		if(isset($params->dolg4) && ($params->dolg4)) {
		  $this->dolg4 =  $params->dolg4;
		} else {
		  $this->dolg4 = 0;
		}
		if(isset($params->dolg5) && ($params->dolg5)) {
		  $this->dolg5 =  $params->dolg5;
		} else {
		  $this->dolg5 = 0;
		}
		if(isset($params->dolg6) && ($params->dolg6)) {
		  $this->dolg6 =  $params->dolg6;
		} else {
		  $this->dolg6 = 0;
		}
		if(isset($params->dolg7) && ($params->dolg7)) {
		  $this->dolg7 =  $params->dolg7;
		} else {
		  $this->dolg7 = 0;
		}
		if(isset($params->dolg8) && ($params->dolg8)) {
		  $this->dolg8 =  $params->dolg8;
		} else {
		  $this->dolg8 = 0;
		}
		if(isset($params->dolg9) && ($params->dolg9)) {
		  $this->dolg9 =  $params->dolg9;
		} else {
		  $this->dolg9 = 0;
		}
		if(isset($params->dolg10) && ($params->dolg10)) {
		  $this->dolg10 =  $params->dolg10;
		} else {
		  $this->dolg10 = 0;
		}
		if(isset($params->newOplata) && ($params->newOplata)) {
		  $this->newOplata =  $params->newOplata;
		} else {
		  $this->newOplata = 0;
		}
		if(isset($params->address_id) && ($params->address_id)) {
		  $this->address_id = (int) $params->address_id;
		} else {
		  $this->address_id = 0;
		}

		  $this->prixod = PRIXOD;
		  $this->bank = BANK;

	
		if(isset($params->user_id) && ($params->user_id)) {
		  $this->user_id = (int) $params->user_id;
		} else {
		  $this->user_id = 0;
		}
	if(isset($params->otdel_id) && ($params->otdel_id)) {
		  $this->otdel_id = (int) $params->otdel_id;
		} else {
		  $this->otdel_id = 0;
		}
		if(isset($params->date_oplata) && ($params->date_oplata)) {
		  $this->date_oplata= $params->date_oplata;
		} else {
		   $this->date_oplata='';
		}	

		
//print( $this->sql);
switch ($this->what) {

			case "AppTekOplata":			
			      $this->sql='CALL YISGRAND.Bank_'.$this->bank.'Oplata_App("'
					.$this->address_id.'","'
					.$this->cbDo1.'","'
					.$this->cbDo2.'","'
					.$this->cbDo3.'","'
					.$this->cbDo4.'","'
					.$this->cbDo5.'","'
					.$this->cbDo6.'","'
					.$this->cbDo7.'","'
					.$this->cbDo8.'","'
					.$this->cbNext1.'","'
					.$this->cbNext2.'","'
					.$this->cbNext3.'","'
					.$this->cbNext4.'","'
					.$this->cbNext5.'","'
					.$this->cbNext6.'","'
					.$this->cbNext7.'","'
					.$this->cbNext8.'","'
					.$this->zadol1.'","'
					.$this->zadol2.'","'
					.$this->zadol3.'","'
					.$this->zadol4.'","'
					.$this->zadol5.'","'
					.$this->zadol6.'","'
					.$this->zadol7.'","'
					.$this->zadol8.'","'
					.$this->dolg1.'","'
					.$this->dolg2.'","'
					.$this->dolg3.'","'
					.$this->dolg4.'","'
					.$this->dolg5.'","'
					.$this->dolg6.'","'
					.$this->dolg7.'","'
					.$this->dolg8.'","'
					.$this->otdel_id.'","'
					.$this->newOplata.'","'
					.$this->user_id.'","'
					.$this->prixod.'","'
					.$this->bank.'","'
					.$this->login.'","'
					.$this->date_oplata.'",'
					.' @success, @msg)';
					//print( $this->sql);

			break;
		case "OplataDolgMgkc":			
			      $this->sql='CALL YISGRAND.Bank_'.$this->bank.'OplataDolgMgkc("'
					.$this->address_id.'","'					
					.$this->dolg9.'","'
					.$this->otdel_id.'","'
					.$this->user_id.'","'
					.$this->prixod.'","'
					.$this->bank.'","'
					.$this->login.'","'
					.$this->date_oplata.'",'
					.' @success, @msg)';
					//print( $this->sql);

			break;
		case "OplataDolgDobrobut":			
			      $this->sql='CALL YISGRAND.Bank_'.$this->bank.'OplataDolgDobrobut("'
					.$this->address_id.'","'					
					.$this->dolg10.'","'
					.$this->otdel_id.'","'
					.$this->user_id.'","'
					.$this->prixod.'","'
					.$this->bank.'","'
					.$this->login.'","'
					.$this->date_oplata.'",'
					.' @success, @msg)';
					//print( $this->sql);

			break;
			
		}
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		}			
		return $this->results;
	      }
public function delOplata(stdClass $params)
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

		$_db = $this->__construct();

	     
		$array = (array) $params;
		
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}

		$this->prixod = PRIXOD;
		$this->bank = BANK;

	      
			$this->sql='CALL YISGRAND.Bank_Del_Oplata_App('.$this->rec_id.',"'.$this->tbank.'",'.$this->user_id.',@success, @msg)';
		
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		}			
		return $this->results;
	      }
	    public function getRaspechatka(stdClass $params)
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

		$_db = $this->__construct();
	
		
		$array = (array) $params;
		
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}
		$this->prixod = PRIXOD;
		 $this->bank = BANK;
		 switch ($this->what) {
			case "raspechatkaOplataApp":
			      if($this->raion_id == 2 || $this->raion_id == 5 || $this->raion_id == 10){ 
				      $this->sql='CALL YISGRAND.Bank_'.$this->bank.'Raspechatka_Oplata_Voda('.$this->address_id.',@success,@content)';
			      } else {
				      $this->sql='CALL YISGRAND.Bank_'.$this->bank.'Raspechatka_Oplata('.$this->address_id.','.$this->user_id.',@success,@content)';
			      }
			break;
			
			case "raspechatkaOplataDolgMgkc":			
				      $this->sql='CALL YISGRAND.Bank_'.$this->bank.'RaspechatkaOplataDolgMgkc('.$this->address_id.',@success,@content)';
//print( $this->sql);

			break;
			
			}
	
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @content,@success';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['content'] = $this->row['@content'];
			$this->results['success'] = $this->row['@success'];
			$this->results['sql'] = $this->sql;
		}
		return $this->results;




}
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}