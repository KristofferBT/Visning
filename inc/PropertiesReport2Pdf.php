<?php
 error_reporting(E_ALL);
            ini_set('display_errors', 1);
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

            
// Composer's auto-loading functionality
require "../vendor/autoload.php";
include_once '../ConnectDB.php';
include_once 'incFunctions.php';
use Dompdf\Dompdf;


if(!isset($_REQUEST['PropertyID'])) {
    
    
}

else {
    
    $PropertyID = $_REQUEST['PropertyID'];

    //generate some PDFs!
$dompdf = new DOMPDF();  //if you use namespaces you may use new \DOMPDF()

$html = file_get_contents("https://tryggvisning.no/test/print.php?PropertyID=$PropertyID");
echo $html;
$dompdf->set_option('DOMPDF_ENABLE_REMOTE','true');
$dompdf->setPaper('A4', 'portrait');
$dompdf->loadHtml($html);
$dompdf->render();
//$dompdf->stream("sample.pdf", array("Attachment"=>0));


//Filnavn i blob
       $hash = generateRandomString();
       $HashedFile = hash('sha256',$hash);
       $HashedFile = $HashedFile . "." . 'pdf'; 


$blob_name = $HashedFile;
$content = $dompdf->output();

try {
    //Upload blob
    $blobRestProxy->createBlockBlob("pdf", $blob_name, $content);
    $data['success'] = 'true';
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage(); 
   $error['Ex'] = $code.": ".$error_message;
   $data['success'] = 'false';
}

//SQL Insert PropertyReport
if ($data['success'] == 'true') {
    $sql = "Insert into PropertyReport (PropertyReportPropertyID, PropertyReportCreateDate, PropertyReportFile) "
            . "Values ("
            . " :PropertyReportPropertyID,"
            . " getdate(),"
            . " :PropertyReportFile"
            . ")";
    
    $stmt = $dbh->prepare($sql);
    $stmt->BindValue(':PropertyReportPropertyID', $PropertyID, PDO::PARAM_STR);
    $stmt->BindValue(':PropertyReportFile', $blob_name, PDO::PARAM_STR);
    $stmt->Execute();
}
//Sende mail 
if ($data['success'] == 'true') {
    
    $sqlmail = "select UserEmail from [User] where UserID in (select UserID from Properties where PropertyID = :PropertyID)";
    $stmtemail = $dbh->Prepare($sqlmail);
    $stmtemail->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
    $stmtemail->Execute();
    $email = $stmtemail->fetchColumn();
     //Send mail til bruker med link til passordbytte
       
       $text = "Hei!\n"
               . "Boligrapporten din er ferdig\n"
               . "Logg deg inn på www.tryggvisning.no for å laste ned rapporten.\n"
               . "\nDu finner den under Mine Rapporter."
               . "";
 $html = "<html>
       <head></head>
       <body>
           <p>Hei<br>
               Boligrapporten din er ferdig<br><br>
               Logg deg inn på 
               <a href='https://www.tryggvisning.no/Properties?Action=ReportList'> Trygg Visning </a> for å laste ned rapporten.
               <br><br>Du finner den under Mine Rapporter.
           </p>
       </body>
       </html>";
 // This is your From email address
 $from = array('info@tryggvisning.no' => 'www.tryggvisning.no');
 // Email recipients
 $to = array(
       $email=>$email);
 // Email subject
 $subject = 'Trygg Visning - Boligrapport';

 // Login credentials
 $username = 'azure@azure.com';
 $password = 'password';

 // Setup Swift mailer parameters
 $transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 587);
 $transport->setUsername($username);
 $transport->setPassword($password);
 $swift = Swift_Mailer::newInstance($transport);

 // Create a message (subject)
 $message = new Swift_Message($subject);

 // attach the body of the email
 $message->setFrom($from);
 $message->setBody($html, 'text/html');
 $message->setTo($to);
 $message->addPart($text, 'text/plain');

 // send message 
 if ($recipients = $swift->send($message, $failures))
 {
     // This will let us know how many users received this message
     //echo 'Message sent out to '.$recipients.' users';
     echo "Mail sendt.";
 }
 // something went wrong =(
 else
 {
     echo "Something went wrong - ";
     print_r($failures);
 }
}


    
}

?>