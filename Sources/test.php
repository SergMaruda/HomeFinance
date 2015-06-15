<?php

require_once "Mail.php";
//require_once 'sftmailer/swift_required.php';

$from = '<ukrgo.app@gmail.com>';
$to = '<maruda@ukr.net>';
$subject = 're eew LED strip';
$body = "Hello dear again, I would like to order A NEW led strip. Please call me";

$headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
);

echo "Sergey maruda";

//    $message = Swift_Message::newInstance('Wonderful Subject')
//      ->setFrom(array('ukrgo.app@gmail.com' => 'Evaluaciones'))
//      ->setTo(array('maruda@ukr.net'=> 'A name'))
//      ->setBody('Test Message Body');


//$transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
//  ->setUsername('ukrgo.app@gmail.com')
//  ->setPassword('vfhelf081987');
  
//$mailer = Swift_Mailer::newInstance($transporter);

$smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => '465',
        'auth' => true,
        'username' => 'ukrgo.app@gmail.com',
        'password' => 'vfhelf081987'
        
    ));

echo "sending...";

//$result = $mailer->send($message);
//echo $result;

$smtp->_debug = true;
	
$mail = $smtp->send($to, $headers, $body);

echo $mail;


?>
