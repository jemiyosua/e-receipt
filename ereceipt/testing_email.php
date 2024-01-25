require_once ("PHPMailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Port = 25;
$mail->Host = "e-receipt.site"; // SMTP server
$mail->Username = "ereceipt"; // SMTP account username
$mail->Password = "password"; // SMTP account password
$mail->From = "sending@yourdomain.com";
$mail->FromName = "Test";
$mail->AddAddress("receive@yourdomain.com"); // Receiving Mail ID, it can be either domain mail id (or ) any other mail id i.e., gmail id
$mail->Subject ="PhpMailer script with basic smtp authentication";
$mail->AltBody = " ";
$mail->WordWrap = 80;
$body = "test message";
$mail->MsgHTML($body);
$mail->IsHTML(true);
if(!$mail->send())
{
echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
echo "Message Sent!";
}