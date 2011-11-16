<?php

require_once '../inc/conf.php';
include '../inc/table.php';
include '../inc/Template.php';
include 'ChildrenCombobox.php';
include_once('class.phpmailer.php');

session_start();

$explainAbsence = $_POST['explainAbsence'];
$childId = $_SESSION['childId'];
$parentId = $_SESSION['parentId'];

$q = 'SELECT CONCAT(nazwisko," ", imie) FROM uczniowie WHERE id = ' . $childId;
$result = mysql_query($q);
$row = mysql_fetch_row($result);
$nazwiskoUcznia = $row[0];


$q = 'SELECT n.email email FROM nauczyciele n JOIN klasy k ON n.id = k.id_wychowawcy JOIN uczniowie u ON u.id_klasy = k.id WHERE u.id = ' . $childId;
$result = mysql_query($q) or die('select died');
$row = mysql_fetch_row($result);
$emailWychowawcy = $row[0];


$q = 'SELECT status, data FROM obecnosci WHERE id IN (';
foreach ($explainAbsence as $absenceId) {
	$q.= $absenceId . ',';
}
$q = preg_replace('/(,$)/', ')' , $q);
$q = preg_replace('/(WHERE id IN \($)/', '' , $q);
$result = mysql_query($q);
$message = 'Prosze o usprawiedliwienie godzin ucznia ' . $nazwiskoUcznia . ": \n";
while(($row = mysql_fetch_row($result)) != ''){
	
	$message.= $row[0] . ' ' . $row[1] . "\n";
	
}


$to = 'porlowicz@gmail.com';;
$subject = 'Prosba o usprawiedliwienie nieobecnosci';

$mail = new PHPMailer();
$mail->ClearAddresses();
$mail->AddAddress($to, 'TO');
$mail->From = 'ty@przyklad.com';
$mail->FromName = 'From Me';
$mail->Subject = $subject;
$mail->Body = $message;
$mail->Send() or $mail->ErrorInfo();

$combo = getChildrenCombobox($parentId, $childId);
$content = '<h3>Wyslano do wychowawcy email z prosba o usprawiedliwienie godzin ucznia ' . $nazwiskoUcznia . '</h3>';
$content.= '<input type="button" value="Wstecz" onclick=';
$content.= '"javascript:$(\'body\').append($(\'<a></a>\').attr(\'href\', \'http://localhost:8080/DziennikNauczyciela/parent/attendance.php?childId='.$childId.'\').attr(\'id\', \'backLink\'));document.getElementById(\'backLink\').click();" />';
$tl = new Template('../tls/parent/index.html');

$tl->add('childrenCombobox', $combo);
$tl->add('content', $content);

echo $tl->execute();


?>