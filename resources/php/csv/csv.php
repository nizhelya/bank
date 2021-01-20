<?php

class csvCreate
{

	private $_db;
	protected $login;
	protected $txtfile;
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

public function exportSvod($tbank,$otdel_id,$pr,$data)
	{
						function utf8_2_win1251 ($str_src)
							{
							$str_dst = "";
							$i = 0;
							while ($i<strlen($str_src))
							{
							$code_dst = 0;
							$code_src1 = ord($str_src[$i]);
							$i++;

							if ($code_src1<=127)
							{
							$str_dst .= chr($code_src1);
							continue;
							}
							else
							if (($code_src1 & 0xE0) == 0xC0)
							{
							$code_src2 = ord($str_src[$i++]);
							if (($code_src2 & 0xC0) != 0x80)
							continue;

							$code_dst = ( ($code_src1 & 0x1F) << 6) + ($code_src2 & 0x3F);
							}
							else
							if (($code_src1 & 0xF0) == 0xE0)
							{
							$code_src2 = ord($str_src[$i++]);
							if (($code_src2 & 0xC0) != 0x80)
							continue;

							$code_src3 = ord($str_src[$i++]);
							if (($code_src3 & 0xC0) != 0x80)
							continue;

							$code_dst = ( ($code_src1 & 0x1F) << 12) + ( ($code_src2 & 0x3F) << 6) + ($code_src3 & 0x3F);
							}
							else
							if (($code_src1 & 0xF8) == 0xF0)
							{
							$code_src2 = ord($str_src[$i++]);
							if (($code_src2 & 0xC0) != 0x80)
							continue;

							$code_src3 = ord($str_src[$i++]);
							if (($code_src3 & 0xC0) != 0x80)
							continue;

							$code_src4 = ord($str_src[$i++]);
							if (($code_src4 & 0xC0) != 0x80)
							continue;

							$code_dst = ( ($code_src1 & 0x1F) << 18) + ( ($code_src2 & 0x3F) << 12) + ( ($code_src3 & 0x3F) << 6) + ($code_src4 & 0x3F);
							}
							else
							{
							continue;
							}

							if ($code_dst)
							{
							if ($code_dst==0x401)
							{ 
							$str_dst .= "";
							} 
							else
							if ($code_dst==0x451)
							{ 
							$str_dst .= "";
							} 
							else 
							if ( ($code_dst>=0x410) && ($code_dst<=0x44F) )
							{ 
							$str_dst .= chr ($code_dst-848);
							}
							else
							$str_dst .= "&#{$code_dst};";
							}
							}
							return $str_dst;
							} 
					
			
		$_db = $this->__construct();




											switch($tbank)
																{
																case 'IMEX_':
																			switch($pr)
																			{
																				case 'D':
																				$T='P';
																				break;
																				case 'W':
																				$T='E';
																				break;
																				default:
																				$T='P';	
																			}
																			switch($otdel_id)
																			{
																				case 471:
																				$hex_kassa='2F';
																				$mesto='471';
																				break;
																				case 472:
																				$hex_kassa='2F';
																				$mesto='472';
																				break;
																				case 473:
																				$hex_kassa='2F';
																				$mesto='473';
																				break;
																				case 197:
																				$hex_kassa='C5';
																				$mesto='197';
																				break;
																				case 238:
																				$hex_kassa='EE';
																				$mesto='238';
																				break;
																				case 289:
																				$hex_kassa='121';
																				$mesto='289';
																				break;
																				case 271:
																				$hex_kassa='10F';
																				$mesto='271';
																				break;
																				default:
																				$hex_kassa='2F';
																				$mesto='471';
																			}
																			$m = substr($data,5,2);
																			switch($m)
																			{
																				case "01":
																				$mec='1';
																				break;
																				case "02":
																				$mec='2';
																				break;
																				case "03":
																				$mec='3';
																				break;
																				case "04":
																				$mec='4';
																				break;
																				case "05":
																				$mec='5';
																				break;
																				case "06":
																				$mec='6';
																				break;
																				case "07":
																				$mec='7';
																				break;
																				case "08":
																				$mec='8';
																				break;
																				case "09":
																				$mec='9';
																				break;
																				case "10":
																				$mec='a';
																				break;
																				case "11":
																				$mec='b';
																				break;
																				case "12":
																				$mec='c';
																				break;
																				
																			}
																//print('мес '.$mec);

																				$dey=substr($data,8,2);
																				//print('dey '.$dey);
																				switch($dey)
																				{
																					case '01':
																					$d='1';
																					break;
																					case '02':
																					$d='2';
																					break;
																					case '03':
																					$d='3';
																					break;
																					case '04':
																					$d='4';
																					break;
																					case '05':
																					$d='5';
																					break;
																					case '06':
																					$d='6';
																					break;
																					case '07':
																					$d='7';
																					break;
																					case '08':
																					$d='8';
																					break;
																					case '09':
																					$d='9';
																					break;
																					case '10':
																					$d='a';
																					break;
																					case '11':
																					$d='b';
																					break;
																					case '12':
																					$d='c';
																					break;
																					case '13':
																					$d='d';
																					break;
																					case '14':		 
																					$d='e';
																					break;
																					case '15':
																					$d='f';
																					break;
																					case '16':
																					$d='g';
																					break;
																					case '17':
																					$d='h';
																					break;
																					case '18':
																					$d='i';
																					break;
																					case '19':
																					$d='j';
																					break;
																					case '20':
																					$d='k';
																					break;
																					case '21':
																					$d='l';
																					break;
																					case '22':
																					$d='m';
																					break;
																					case '23':
																					$d='n';
																					break;
																					case '24':
																					$d='o';
																					break;
																					case '25':
																					$d='p';
																					break;
																					case '26':
																					$d='q';
																					break;
																					case '27':
																					$d='r';
																					break;
																					case '28':
																					$d='s';
																					break;
																					case '29':
																					$d='t';
																					break;
																					case '30':
																					$d='u';
																					break;
																					case '31':
																					$d='v';
																					case '32':
																					$d='w';
																					break;
																					
																				}
																				$god = substr($data,2,2);
																				$fterminated = "~";
																				$escaped = "\\";
																				$lterminated = "\\n";
																				$enclosed = "";

																				$txt='.'.$mesto;
																				$this->txtfile ='/tmp/K'.$T.$hex_kassa.$d.$mec.$god.$txt;
																				$this->sql='SELECT  YISGRAND.IMEX_SVOD.`nomer` as document,'
																											.'YISGRAND.IMEX_SVOD.`type` as `type_document`,'
																											.'YISGRAND.IMEX_SVOD.`data` as date_document,'
																											.'YISGRAND.IMEX_SVOD.`mfo_payer`,'
																											.'YISGRAND.IMEX_SVOD.`acc_payer`,' 
																											.'YISGRAND.IMEX_SVOD.`mfo_receiv`,'
																											.'YISGRAND.IMEX_SVOD.`acc_receiv`,'
																											.'YISGRAND.IMEX_SVOD.`summa`,'
																											.'YISGRAND.IMEX_SVOD. `bank_payer`,'
																											.'YISGRAND.IMEX_SVOD.`bank_receiv`,'
																											.'YISGRAND.IMEX_SVOD.`symbol_pay`,'
																											.'YISGRAND.IMEX_SVOD.`detali` as pay_details,'
																											.'YISGRAND.IMEX_SVOD.`okpo_payer`,'
																											.'YISGRAND.IMEX_SVOD.`okpo_receiv` '
																											.'INTO  OUTFILE "'.$txtfile.'" fields terminated by "'.$fterminated.'" enclosed by "" escaped by "'.$escaped.'" lines terminated by '.$lterminated.' FROM YISGRAND.IMEX_SVOD';

																break;
																case 'otoplenie':
																$lgota = "/tmp/otoplen.dbf";
																$this->sql='SELECT * FROM YISGRAND.DBF_OTOPLENIE';
																break;
																case 'voda':
																$lgota = "/tmp/voda.dbf";
																$this->sql='SELECT * FROM YISGRAND.DBF_VODA';
																break;
																case 'kvartplata1':
																$lgota = "/tmp/gek1.dbf";
																$this->sql='SELECT * FROM YISGRAND.DBF_KVARTPLATA1';
																break;
																case 'kvartplata3':
																$lgota = "/tmp/gek3.dbf";
																$this->sql='SELECT * FROM YISGRAND.DBF_KVARTPLATA3';
																break;
																case 'kvartplata4':
																$lgota = "/tmp/gek4.dbf";
																$this->sql='SELECT * FROM YISGRAND.DBF_KVARTPLATA4';
																break;
																case 'tbo':
																$lgota = "/tmp/tbo.dbf";
																$this->sql='SELECT * FROM YISGRAND.DBF_TBO';

																break;
																}
																$_result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
																$fields_cnt
																while ($row = $_result->fetch_assoc()) {
																				for ($j = 0; $j < $fields_cnt; $j++) {
																							if (!isset($row[$j]) || is_null($row[$j])) {
																									$svod .= $GLOBALS[$what . '_null'];
																							} elseif ($row[$j] == '0' || $row[$j] != '') {
																								if ($csv_enclosed == '') {
																											$svod .= convert_cyr_string(utf8_2_win1251($row[$j]),"w","a");

																									} else {
																											$svod .= $csv_enclosed
																																		. str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, convert_cyr_string(utf8_2_win1251($row[$j]),"w","a"))
																																		. $csv_enclosed;
																									}
																							} else {
																									$svod .= '';
																							}
																							if ($j < $fields_cnt-1) {
																									$svod .= $csv_separator;
																							}
																					} // end for
																		}

																			if (is_writable($this->txtfile)) {

																					// In our example we're opening $filename in append mode.
																					// The file pointer is at the bottom of the file hence
																					// that's where $somecontent will go when we fwrite() it.
																					if (!$handle = fopen($this->txtfile, 'w')) {
																							echo 'Cannot open file '.$this->txtfile;
																							exit;
																					}

																					// Write $somecontent to our opened file.
																					if (fwrite($handle, $svod) === FALSE) {
																							echo 'Не могу записать файл '.$filename);
																							exit;
																					} else {
																							$this->results['success'] = 1;
																					fclose($handle);
																					}
																			} else {
																					echo 'В файл '.$filename.' нельзя записать'
																			}

		return $this->results;
	}

}



      try {
	
 if    (isset($_REQUEST['data']) && !empty($_REQUEST['data'])){ //код подтверждения 
			$tbank=$_REQUEST['data'];
		 } else {           
			throw new Exception("Не выбран дата свода");
		}
		 if    (isset($_REQUEST['tbank']) && !empty($_REQUEST['tbank'])){ //код подтверждения 
			$tbank=$_REQUEST['tbank'];
		 } else {           
			throw new Exception("Не выбран банк");
		}
		if    (isset($_REQUEST['otdel_id']) && !empty($_REQUEST['otdel_id'])){ //код подтверждения 
			$otdel_id=$_REQUEST['otdel_id'];
		 } else {           
			throw new Exception("Не выбрано отделение");
		}
		if    (isset($_REQUEST['pr']) && !empty($_REQUEST['pr'])) { //код подтверждения 
			      $pr=$_REQUEST['pr'];
//print($sql)
			      $obj = new csvCreate();
			      $content=$obj->exportSvod($tbank,$otdel_id,$pr,$user_id);
			      if ($content) {
									header("Content-Type: application/vnd.ms-excel charset=utf-8");
									header('Content-disposition: attachment; filename='.$this->filename);
									$res =$content;
						} else {
		
								throw new Exception("Не удалось выполнить экспорт свода");
						}				
	 } else {     
			
		throw new Exception('Нет выбрана касса (вечерняя или дневная)!');
	}
		
		  
		
	}
	catch(Exception $e){
		$res = $e->getMessage();
		
	}

	 return print($res);


?>
