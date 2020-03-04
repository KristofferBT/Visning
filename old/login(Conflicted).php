<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'ConnectDB.php';
    // process.php

$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

// validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array

//    echo "<br>";
//    echo var_dump($_POST);
//    echo "<br>";
    if (empty($_POST['email']))
        $errors['email'] = 'Email is required.';

    if (empty($_POST['password']))
        $errors['password'] = 'Password i required.';

// return a response ===========================================================

    // if there are any errors in our errors array, return a success boolean of false
    if ( ! empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process our form, then return a message

        // DO ALL YOUR FORM PROCESSING HERE
        // THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

        // show a message of success and provide a true success variable
        
        $sql = "select UserPassword, UserID, UserDisplayName from [User] where UserEmail = :email";
        
        $stmt=$dbh->prepare("$sql");
        $stmt->BindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->Execute();
        IF(isset($_POST['email'])){$UserEmail = $_POST['email'];}
        $CountEmail = $dbh->query("select count(*) from [User] where UserEmail = '$UserEmail'")->FetchColumn();
        //echo "UserEmail: " . $CountEmail;
        foreach ($stmt as $row) {
            
            
            if($row['UserPassword'] === $_POST['password']){
                session_start();
                $_SESSION['LoggedIn'] = 'TRUE';
                $_SESSION['UserID'] = $row['UserID'];
                $_SESSION['UserDisplayName'] = $row['UserDisplayName'];
            
                
            }
            if ($CountEmail < '1') {
                
                $data['NewUser'] = true;
            }
        }
        
        
        
        $data['success'] = true;
        $data['message'] = 'Success!';
        
        //header("Location: http://thygesen.zapto.org");    
    }

    // return all our data to an AJAX call
    echo json_encode($data);
    
    