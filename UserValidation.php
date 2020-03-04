<?php
 error_reporting(E_ALL);
            ini_set('display_errors', 1);
header('content-type: text/json');
include_once 'ConnectDB.php';
include_once 'inc/incFunctions.php';
session_start(); 

//if(!isset($_POST['email']))
//    exit;

$data           = array();      // array to pass back data
$FormErrors     = array();


IF(isset($_POST['email'])){

    
    $sql = "select Count(*) from [User] where UserEmail = :email ";
    $stmt = $dbh->Prepare($sql);
    $stmt->BindValue(':email', $_POST['email']);
    $stmt->Execute();
    $CountEmail = $stmt->FetchColumn();
    
    $data['EmailCount'] = $CountEmail;
    $data['Email'] = $_POST['email'];
    if(isset($_POST['password'])){$data['password'] = $_POST['password'];}
    
}


if(isset($_POST['emailheader']) and isset($_POST['passwordheader'])){

    $_POST['email'] = $_POST['emailheader'];
    $_POST['password'] = $_POST['passwordheader'];
    
}

if(isset($_POST['email']) and isset($_POST['password'])){
    
    $sql = "select UserPassword, UserID, UserDisplayName, secret, UserAccessLevel from [User] where UserEmail = :email";
        
         
        $stmt=$dbh->prepare("$sql");
        $stmt->BindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->Execute();
        IF(isset($_POST['email'])){$UserEmail = $_POST['email'];}
        $CountEmail = $dbh->query("select count(*) from [User] where UserEmail = '$UserEmail'")->FetchColumn();
        //echo "UserEmail: " . $CountEmail;
        foreach ($stmt as $row) {
            $SaltedPass = $_POST['password'] . $row['secret'];
            $HashedPass = hash('sha256', $SaltedPass);
            
            
            if($row['UserPassword'] === $HashedPass){
                //session_start();
                $_SESSION['LoggedIn'] = 'true';
                $_SESSION['UserID'] = $row['UserID'];
                $_SESSION['UserDisplayName'] = $row['UserDisplayName'];
                $_SESSION['UserLevel'] = $row['UserAccessLevel'];
                $data['LoggedIn'] = true;
                
                //Hente ut eiendommene til bruker og legge disse inn ett array.
                $sql = "select PropertyID from Properties where UserID = :UserID";
                $stmt = $dbh->Prepare($sql);
                $stmt->BindValue(':UserID', $_SESSION['UserID']);
                $stmt->Execute();
                $_SESSION['PropertyID'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                //Hente ut RoomID til bruker og legge disse inn i ett array.
                $UserID = $_SESSION['UserID'];
                $sql = "select RoomID from Room where PropertyID in (select PropertyID from properties where UserID = $UserID )";
                $stmt = $dbh->Prepare($sql);
                $stmt->Execute();
                $_SESSION['RoomID'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                
                //Set Cookie
                
                setcookie('KakeBit', $_SESSION['UserID'], time()+60*60*24*365, 'https://www.tryggvisning.no/');
                setcookie('KakeSpade', $HashedPass, time()+60*60*24*365, 'https://www.tryggvisning.no/');
                $data['KakeBit'] = $_SESSION['UserID'];
                $data['KakeSpade'] = $HashedPass;
            
                
            }
            else {
                
                $FormErrors['PasswordValidationError'] = 'Brukernavn eller passord er feil.';
                $data['success'] = false;
            }
            
        }
        if ($CountEmail == '0') {
                
                
                $data['NewUser'] = true;
            }
        if (isset($_POST['firstname'])){
            //echo var_dump($_POST);
            
        }
        
        
        
        //$data['success'] = true;
        //$data['message'] = 'Success!';
        
        //header("Location: http://thygesen.zapto.org");    
    }
    //Ny bruker validering
    if(isset($_POST['firstname']) and isset($_POST['email'])){
        $UserValidation = '1';
        
        if(strlen($_POST['passwordnewuser'])< '6'){
            $FormErrors['PasswordError'] = 'For kort. Minimum 6 tegn.';
            $UserValidation = '0';
        }
        
        $data['firstname'] = $_POST['firstname'];
        $data['lastname'] = $_POST['lastname'];
        $data['mobile'] = $_POST['mobile'];
        //$data['passwordnewuser'] = $_POST['passwordnewuser'];
        $data['email'] = $_POST['email'];
        
       $hash = generateRandomString();
       $SaltedPass = $_POST['passwordnewuser'] . $hash;
       $HashedPass = hash('sha256',$SaltedPass);
        
        if($UserValidation == '1') {
        $sql = "Insert into [User] (UserFirstName, UserLastName, UserEmail, UserPassword, secret) Values "
                . "("
                . ":firstname, "
                . ":lastname, "
                . ":email, "
                . ":password, "
                . ":secret )";
        $stmt = $dbh->prepare($sql);
        $stmt->BindValue(':firstname', $_POST['firstname'], pdo::PARAM_STR);
        $stmt->BindValue(':lastname', $_POST['lastname'], pdo::PARAM_STR);
        $stmt->BindValue(':email', $_POST['email'], pdo::PARAM_STR);
        $stmt->BindValue(':password', $HashedPass, pdo::PARAM_STR);
        $stmt->BindValue(':secret', $hash, PDO::PARAM_STR);
        $stmt->Execute();
        
        $UserID = $dbh->lastInsertId();
        
        $_SESSION['LoggedIn'] = 'true';
        $_SESSION['UserID'] = $UserID;
        $_SESSION['UserDisplayName'] = $_POST['firstname'];
        $data['LoggedIn'] = true;
        $data['NewUser'] = false;
        $data['EmailCount'] = '1';
    }
    else {
        $data['success'] = 'false';
        $data['Errors'] = $FormErrors;
    }
        
    }
    
    $data['Errors'] = $FormErrors;
    

//echo var_dump($data);

echo json_encode($data);
