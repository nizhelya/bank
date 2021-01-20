<?php
include_once './yis_config.php';

class QueryExport
{
	private $_db;
	protected $_result;
	protected $_visit;
	protected $_msg;
	protected $_stmt;
	protected $_id;
	protected $login;
	protected $password;
	protected $smtp = "91.192.128.1"; // SMTP сервер
	protected $reply_email ='yis@yuzhny.com';
	protected $name_send='Южненская Коммунальная Информационная Система -ЮКИС';
	protected $msg_html ; 
	protected $msg_txt ; 
	protected $_mphone;
	protected $address;
	protected $address_id;
	protected $user_id;
	protected $sql;
	public $results;

	
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


							

	public function exportSvod(stdClass $params)
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
					if(isset($params->login) && ($params->login)) {
							$this->login= addslashes($params->login);
					} else {
						$this->login= null;
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


											switch($this->tbank)
																{
																case 'IMEX_':
																			switch($this->pr)
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
																			switch($this->otdel_id)
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
																			$m = substr($this->data,5,2);
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

																				$dey=substr($this->data,8,2);
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
																				$god = substr($this->data,2,2);
																				$fterminated = "~";
																				$escaped = "\\";
																				$lterminated = "\\n";
																				$enclosed = "";

																				$txt='.'.$mesto;
																				$txtfile ='/tmp/K'.$T.$hex_kassa.$d.$mec.$god.$txt;
																			
																					$this->sql='SELECT CONCAT(YIS.IMEX_SVOD.nomer,YIS.IMEX_SVOD.id)  as document,'
																											.'YISGRAND.IMEX_SVOD.`type` as `type_document`,'
																											.'YISGRAND.IMEX_SVOD.`data` as date_document,'
																											.'YIS.IMEX_SVOD.mfo_payer,'
																											.'LPAD(YIS.IMEX_SVOD.acc_payer,14," ")  as acc_payer,'
																											.'YIS.IMEX_SVOD.mfo_receiv  ,'
																											.'LPAD(YIS.IMEX_SVOD.acc_receiv,14," ")  as acc_receiv,'
																											.'LPAD(YIS.IMEX_SVOD.summa,14," ")  as summa,'
																											.'RPAD(YIS.IMEX_SVOD.bank_payer,60," ")  as bank_payer ',
																											.'RPAD(YIS.IMEX_SVOD.bank_receiv,60," ")  as bank_receiv,'
																											.'YIS.IMEX_SVOD.symbol_pay ,'
																											.'CONVERT(RPAD(YIS.IMEX_SVOD.pay_details ,160," ") using cp866)  as pay_details,'
																											.'LPAD(YIS.IMEX_SVOD.okpo_payer,10," ") as okpo_payer,'
																											.'LPAD(YIS.IMEX_SVOD.okpo_receiv,10," ") as okpo_receiv  FROM YIS.IMEX_SVOD';

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

															
																$csv_separator = "~";
																$csv_enclosed	= " ";
																$csv_escaped	= "\\";
																$csv_terminated = "AUTO";

																$fields_cnt  =  $_result->field_cnt();
																$svod = '';



					
			$this->results['success'] = $_success;
			$this->results['msg'] = 		$_msg;
					
		return $this->results;
	}



}