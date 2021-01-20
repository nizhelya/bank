<?php 
function get_client_ip() {
     $ipaddress = '';
     if (isset($_SERVER['HTTP_CLIENT_IP']) AND ($_SERVER['HTTP_CLIENT_IP']))
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND ($_SERVER['HTTP_X_FORWARDED_FOR']))
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if(isset($_SERVER['HTTP_X_FORWARDED']) AND ($_SERVER['HTTP_X_FORWARDED']))
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
     else if(isset($_SERVER['HTTP_FORWARDED_FOR']) AND ($_SERVER['HTTP_FORWARDED_FOR']))
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
     else if(isset($_SERVER['HTTP_FORWARDED']) AND ($_SERVER['HTTP_FORWARDED']))
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
     else if(isset($_SERVER['REMOTE_ADDR']) AND ($_SERVER['REMOTE_ADDR']))
         $ipaddress = $_SERVER['REMOTE_ADDR'];
     else
         $ipaddress = '10.1.0.104';
     return $ipaddress; 
}
$ip = get_client_ip();
			     switch ($ip) {
									case "127.0.0.1"://in use			
									$tbank='MTB_' ;
									$prixod='МАРФІН БАНК' ;
									$admin='адмМАРФИН' ;

									break;
									case "10.0.128.10"://in use			
									$tbank='MTB_' ;
									$prixod='МАРФІН БАНК' ;
									$admin='адмМАРФИН' ;

									break;
									case "10.0.128.12"://in use			
									$tbank='IMEX_' ;
									$prixod='АО ИМЭКСБАНК' ;
									$admin='адмИМЭКСБАНК' ;

									break;
									case "10.0.128.9"://in use			
									$tbank='FIN_' ;
									$prixod='БАНК ОАО ФиК' ;
									$admin='адмФИК' ;

									break;
									case "10.0.128.26"://in use			
									$tbank='PIVDENNYI_' ;
									$prixod='БАНК ПИВДЕННЫЙ' ;
									$admin='адмПИВДЕННЫЙ' ;

									break;
									case "10.0.128.30"://in use			
									$tbank='NADRA_' ;
									$prixod='НАДРА БАНК' ;
									$admin='адмНАДРА' ;

									break;
									case "10.0.128.28"://in use			
									$tbank='OSHAD_' ;
									$prixod='ОЩАДБАНК ' ;
									$admin='адмОЩАДБАНК' ;
									break;
									case "10.1.0.104"://in use			
									$tbank='MTB_' ;
									$prixod='МАРФІН БАНК' ;
									$admin='адмМАРФИН' ;
									// print_r($this->sql); 
									break;

						}
 define('LOGIN',	'cthubq');
 define('PASSWORD',	'hfljyt;crbq');
 define('BANK',	$tbank);
 define('PRIXOD',	$prixod);
 define('ADMIN',	$admin);
?>