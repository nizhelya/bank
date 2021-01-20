<?php
include_once './../yis_config.php';

class csvCreate
{

	private $_db;
	protected $login;
	protected $filename;
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

public function exportSvod($handle,$sql)
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
//print($sql);
			$_result = $_db->query($sql) or die('Connect Error in  ('.$sql.') ' . $_db->connect_error);

	
																$fields_cnt = $_result->field_count;
//print($fields_cnt);
																$csv_terminated = "\n";;
																$csv_separator = "~";
																$csv_enclosed = " ";
																$csv_escaped = "\\";
																$svod ='';
																													
																while ($row = $_result->fetch_array()) {
																				for ($j = 0; $j < $fields_cnt; $j++) {
																							if ($row[$j] == '0' || $row[$j] != '') {
																								if ($csv_enclosed == " ") {
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
																					if (fwrite($handle,$svod.$csv_terminated) === FALSE) {
																							echo 'Не могу записать файл '.$filename;
																							exit;
																					} 
																		}
																		fclose($handle);																	
																		$this->results = true;


																				

	return $this->results;
	}

}

try {
	
 if    (isset($_REQUEST['data']) && !empty($_REQUEST['data'])){ 
			$data=$_REQUEST['data'];
} else {           
			throw new Exception("Не выбран дата свода");
}
if    (isset($_REQUEST['tbank']) && !empty($_REQUEST['tbank'])){ 
			$tbank=$_REQUEST['tbank'];
} else {           
			throw new Exception("Не выбран банк");
}
if    (isset($_REQUEST['otdel_id']) && !empty($_REQUEST['otdel_id'])){ 
			$otdel_id=$_REQUEST['otdel_id'];
} else {           
			throw new Exception("Не выбрано отделение");
}
if    (isset($_REQUEST['pr']) && !empty($_REQUEST['pr'])) { 
			      $pr=$_REQUEST['pr'];
													switch($tbank) {
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

																				$txt='.'.$mesto;
																				$filename ='K'.$T.$hex_kassa.$d.$mec.$god.$txt;

																$sql='SELECT  CONCAT(YISGRAND.IMEX_SVOD.nomer,YISGRAND.IMEX_SVOD.id) as document,'
															.'YISGRAND.IMEX_SVOD.`type` as `type_document`,'
															.'DATE_FORMAT(YISGRAND.IMEX_SVOD.`data`,"%d.%m.%Y") as date_document,'
															.'YISGRAND.IMEX_SVOD.mfo_payer,'
															.'LPAD(YISGRAND.IMEX_SVOD.acc_payer,14," ") as acc_payer,'
															.'YISGRAND.IMEX_SVOD.mfo_receiv ,'
															.'LPAD(YISGRAND.IMEX_SVOD.acc_receiv,14," ") as acc_receiv,'
															.'LPAD(YISGRAND.IMEX_SVOD.summa,14," ") as summa,'
															.'CONVERT(RPAD(YISGRAND.IMEX_SVOD.bank_payer,60," ") using cp866) as bank_payer ,'
															.'CONVERT(RPAD(YISGRAND.IMEX_SVOD.bank_receiv,60," ") using cp866) as bank_receiv,'
  														.'YISGRAND.IMEX_SVOD.symbol_pay ,'
															.'CONVERT(RPAD(YISGRAND.IMEX_SVOD.detali ,160," ") using cp866) as pay_details,'
															.'LPAD(YISGRAND.IMEX_SVOD.okpo_payer,10," ") as okpo_payer,'
															.'LPAD(YISGRAND.IMEX_SVOD.okpo_receiv,10," ") as okpo_receiv  FROM YISGRAND.IMEX_SVOD';

														/*	
															$sql='SELECT  CONCAT(YISGRAND.IMEX_SVOD.nomer,YISGRAND.IMEX_SVOD.id) as document,'
															.'YISGRAND.IMEX_SVOD.`type` as `type_document`,'
															.'DATE_FORMAT(YISGRAND.IMEX_SVOD.`data`,"%d.%m.%Y") as date_document,'
															.'YISGRAND.IMEX_SVOD.mfo_payer,'
															.'LPAD(YISGRAND.IMEX_SVOD.acc_payer,14," ") as acc_payer,'
															.'YISGRAND.IMEX_SVOD.mfo_receiv ,'
															.'LPAD(YISGRAND.IMEX_SVOD.acc_receiv,14," ") as acc_receiv,'
															.'LPAD(YISGRAND.IMEX_SVOD.summa,14," ") as summa,'
															.'CONVERT(RPAD(YISGRAND.IMEX_SVOD.bank_payer,60," ") using cp866) as bank_payer ,'
															.'CONVERT(RPAD(YISGRAND.IMEX_SVOD.bank_receiv,60," ") using cp866) as bank_receiv,'
  														.'YISGRAND.IMEX_SVOD.symbol_pay ,'
															.'CONVERT(RPAD(YISGRAND.IMEX_SVOD.detali ,160," ") using cp866) as pay_details,'
															.'LPAD(YISGRAND.IMEX_SVOD.okpo_payer,10," ") as okpo_payer,'
															.'LPAD(YISGRAND.IMEX_SVOD.okpo_receiv,10," ") as okpo_receiv '
															.' INTO  OUTFILE "'.$filename.'" fields terminated by "~" enclosed by "" escaped by "\\\" lines terminated by "\n" FROM YISGRAND.IMEX_SVOD';
*/
																					break;
}
} else {     
		throw new Exception('Нет выбрана касса (вечерняя или дневная)!');
}
			    
if ($handle = fopen('/tmp/'.$filename, 'w')) {

}else {
		throw new Exception("Cannot open file '.$filename");
				
}
						$obj = new csvCreate();
			      $resultat=$obj->exportSvod($handle,$sql);
						if ($resultat) {
								header("Content-type:vnd.ms-excel");
								header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');    
								header('Content-Disposition: attachment; filename="' . $filename . '"');
         				header("Pragma: no-cache");
								$handle = fopen('/tmp/'.$filename, "r");
								$contents = fread($handle, filesize($filename));
								fclose($handle);
									
						} else {
		
								throw new Exception("Не удалось выполнить экспорт свода");
						}				
}
	catch(Exception $e){
		$res = $e->getMessage();
}
	 return print_r($contents);
?>
