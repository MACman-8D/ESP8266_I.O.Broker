<?php
$gas=gg("ESP8266009b63a3.gpioint");
//say($gas);
if ($gas==1) {
say ('Сработал датчик газа в котельной',2);
function smtpmail($mail_to, $subject, $message, $service='mail') {
$config['smtp_charset']  = 'UTF-8';  //кодировка сообщений. (или UTF-8, итд)
$config['smtp_from']     = 'SmartHoume'; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"
$config['smtp_debug']   = true;  //Если Вы хотите видеть сообщения ошибок, укажите true вместо false
$config['smtp_port']     = '465'; // Порт работы. Не меняйте, если не уверены.
$config['smtp_searcher'] = 'mail.ru';
$config['smtp_email'] = 'xxx@bk.ru';
$config['smtp_username'] = 'xxx@bk.ru';  //Смените на имя своего почтового ящика.
$config['smtp_host']     = 'ssl://smtp.mail.ru';  //сервер для отправки почты
$config['smtp_password'] = 'pass';  //Измените пароль
    $header="Date: ".date("D, j M Y G:i:s")." +0300\r\n";
	$header.="From: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode(''.$config['smtp_from'].'')))."?= <".$config['smtp_email'].">\r\n";
	$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n";
	$header.="Reply-To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode(''.$config['smtp_from'].'')))."?= <".$config['smtp_email'].">\r\n";
	$header.="X-Priority: 3 (Normal)\r\n";
	$header.="Message-ID: <172562218.".date("YmjHis")."@".$config['smtp_searcher'].">\r\n";
	$header.="To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('')))."?= <$mail_to>\r\n";
	$header.="Subject: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode(''.$subject.'')))."?=\r\n";
	$header.="MIME-Version: 1.0\r\n";
	$header.="Content-Type: text/html; charset=utf-8\r\n";
	$header.="Content-Transfer-Encoding: 8bit\r\n";
$smtp_conn = fsockopen("".$config['smtp_host']."", $config['smtp_port'],$errno, $errstr, 10);
	if(!$smtp_conn) {print "соединение с серверов не прошло"; fclose($smtp_conn); exit;}
	$data = get_data($smtp_conn);
	
	fputs($smtp_conn,"EHLO ".$config['smtp_searcher']."\r\n");
	$code = substr(get_data($smtp_conn),0,3000);
	if($code != 250) {print "ошибка приветсвия EHLO"; fclose($smtp_conn); exit;}
	
	fputs($smtp_conn,"AUTH LOGIN\r\n");
	$code = substr(get_data($smtp_conn),0,3000);
	if($code != 334) {print "сервер не разрешил начать авторизацию"; fclose($smtp_conn); exit;}

	fputs($smtp_conn,base64_encode("".$config['smtp_username']."")."\r\n");
	$code = substr(get_data($smtp_conn),0,3000);
	if($code != 334) {print "ошибка доступа к такому юзеру"; fclose($smtp_conn); exit;}


	fputs($smtp_conn,base64_encode("".$config['smtp_password']."")."\r\n");
	$code = substr(get_data($smtp_conn),0,3000);
	if($code != 235) {print "не правильный пароль"; fclose($smtp_conn); exit;}

	fputs($smtp_conn,"MAIL FROM: <".$config['smtp_email'].">\r\n");
	$code = substr(get_data($smtp_conn),0,3000);
	if($code != 250) {print "сервер отказал в команде MAIL FROM"; fclose($smtp_conn); exit;}

	fputs($smtp_conn,"RCPT TO: <".$mail_to.">\r\n");
	$code = substr(get_data($smtp_conn),0,3000);
	if($code != 250 AND $code != 251) {print "Сервер не принял команду RCPT TO"; fclose($smtp_conn); exit;}

	fputs($smtp_conn,"DATA\r\n");
	$code = substr(get_data($smtp_conn),0,3000);
	if($code != 354) {print "сервер не принял DATA"; fclose($smtp_conn); exit;}

	fputs($smtp_conn,$header."\r\n".$message."\r\n.\r\n");
	$code = substr(get_data($smtp_conn),0,3000);
	
	if($code != 250) {print "ошибка отправки письма"; fclose($smtp_conn); exit;}

	fputs($smtp_conn,"QUIT\r\n");
	fclose($smtp_conn);
}

function get_data($smtp_conn)
	{
		$data="";
		while($str = fgets($smtp_conn,515))
			{
				$data .= $str;
				if(substr($str,3,1) == " ") { break; }
			}
		return $data;
	}

$text_email = '<html><head></head><body>
Вам отправлено сообщение системой SmartHoume <a href="http://mashintop.ru/announcement_number.php?id='.$myrow['id'].'">здесь</a><br>
Сработал датчик газа в котельной: '.$key.'<br>                                                        
С помощью данного ключа вы сможете управлять своим объявлением.<br>        
</body></html>';
                                       
smtpmail('xx@bk.ru', 'Сработка датчика газа!', $text_email, 'mail'); //используем майл
}
?>
