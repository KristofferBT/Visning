<?php

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */
include_once 'Header.php';
include_once 'ConnectDB.php';
//var_dump($_POST);
if(isset($_POST['submit'])){
    
    $email = $_POST['email'];
    
       
       $SaltedPass =  generateRandomString();
       $urlHash = hash('sha256',$SaltedPass);
       //echo $urlHash;
    
       $sql = "Insert into url (urlHash, urlExpire, urlinfo)"
               . "Values ("
               . " :urlHash, "
               . " dateadd(hour,1,getdate()), "
               . " :urlinfo"
               . ")";
       $stmt = $dbh->prepare($sql);
       $stmt->BindValue(':urlHash', $urlHash, PDO::PARAM_STR);
       $stmt->BindValue(':urlinfo', $email, PDO::PARAM_STR);
       $stmt->Execute();
       
       //Send mail til bruker med link til passordbytte
       
       $text = "Hei!\n"
               . "Følg denne linken for å sette nytt passord\n"
               . "https://www.tryggvisning.no/ForgotPassword.php?url=".$urlHash."'\n"
               . "";
 $html = "<html>
       <head></head>
       <body>
           <p>Hei<br>
               Følg denne linken for å sette nytt passord på Trygg Visning<br><br>
               <a href='https://www.tryggvisning.no/ForgotPassword.php?url=".$urlHash."'>Nytt Passord</a>
           </p>
       </body>
       </html>";
 // This is your From email address
 $from = array('info@tryggvisning.no' => 'www.tryggvisning.no');
 // Email recipients
 $to = array(
       $_POST['email']=>$_POST['email']);
 // Email subject
 $subject = 'Nytt passord på www.tryggvisning.no';

 // Login credentials
 $username = 'azureaccount@azure.com';
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

//Behandle Form endre passord
if(isset($_POST['submitpassword'])){
   
    $email = $_POST['email'];
    $urlhash = $_POST['urlhash'];
    
    
    $sqlurl = "select count(*) from url where urlinfo = '$email' and urlHash = '$urlhash' and urlExpire >= getdate()";
    $stmturl = $dbh->prepare($sqlurl);
    $stmturl->Execute();
    
    $stmturlCount = $stmturl->fetchColumn();
    if($stmturlCount >= '1') {
        
        
        
         $sql = "select UserPassword, UserID, UserDisplayName, secret, UserAccessLevel from [User] where UserEmail = :email";
         $stmt = $dbh->prepare($sql);
        $stmt->BindValue(':email', $email, PDO::PARAM_STR);
        $stmt->Execute();
        
        foreach ($stmt as $row) {
            
            $SaltedPass = $_POST['password'] . $row['secret'];
            $HashedPass = hash('sha256', $SaltedPass);
            
            $UserID = $row['UserID'];
            
            $sqlupdate = "update [User] set UserPassword = '$HashedPass', UserLastUpdated = getdate() where UserID = $UserID";
            $stmtpwd = $dbh->query($sqlupdate);
            
        }
       echo "Passord endret<br>"
        . "<a href='https://www.tryggvisning.no'>Logg inn</a>";
        
    }
    
    
}

//END Behandle Form endre passord

//Sjekke urlhash
else {
    if(isset($_REQUEST['url'])){
    //Echo "Her kan du sette nytt passord.";
    
    $url = $_REQUEST['url'];
    
    $sqlurl = "select count(*) from url where urlHash = :url and urlExpire >= getdate()";
    $stmturl = $dbh->prepare($sqlurl);
    $stmturl->BindValue(':url', $url, PDO::PARAM_STR);
    $stmturl->Execute();
    
    $stmturlCount = $stmturl->fetchColumn();
    
    //Om link har utløpt(60 minutter)
    if($stmturlCount != '1') {
        echo "Link har utløpt.";
    }
    //Link har ikke utløpt - passord kan byttes.
    else {
        
        $sqluser = "select * from url where urlHash = '$url'";
        echo $sqluser;
        $stmtuser = $dbh->query($sqluser);
        
        foreach ($stmtuser as $row) {
            
            
        echo ""
         . "<form action='../ForgotPassword.php' method='POST' id='login'>"
                
            ."<input type='hidden' name='urlhash' value='".$url."'>"
                
            . "<div id='name-group' class='form-group'>"
            . "<label for='email'>Email</label>"
            . "<input type='text' class='form-control' name='email' id='emailinput' value='".$row['urlinfo']."' readonly='true'>"
            
            . "</div>"
            
            . "<div id='password-group' class='form-group'>"
            . "<label for='password'>Password</label>"
            . "<input type='password' class='form-control passwordmain' name='password' placeholder='*****' id='password'>"
            . "</div>"
            . "<input type='submit' name='submitpassword'>"
                . "</form>";
            
        }
        
    }
    
    }
    else {
        echo ""
    . "<form action='/ForgotPassword.php' method='POST'>"
     . "<div id='name-group' class='form-group'>"
            . "<label for='email'>Email</label>"
            . "<input type='text' class='form-control' name='email' id='emailinput' placeholder='user@mail.com'>"
            
            . "</div>"         
            . "<div>"            

            . "<input type='submit' name='submit'>"
            
            . "</div>"
    . "</form>";
    
    }
    
}