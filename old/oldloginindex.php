<!-- index.html -->

<!doctype html>
<html>
<head>
    <title>Visning</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="VisningMain.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    
    <script src="js/login.js"></script> <!-- load our javascript file -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php include_once 'Header.php'; ?>


<?php
session_start();

//Hvis bruker ikke er logget inn - hvis login form.
if(!isset($_SESSION['LoggedIn'])){
    echo ""
        . "<body>"
            
            . "<div class='col-sm-6 col-sm-offset-3'>"
            . "<h1>Logg inn</h1>"
            . "<form action='/login.php' method='POST'>"
            
            . "<div id='name-group' class='form-group'>"
            . "<label for='email'>Email</label>"
            . "<input type='text' class='form-control' name='email' placeholder='user@mail.com'>"
            . "</div>"
            
            . "<div id='password-group' class='form-group'>"
            . "<label for='password'>Password</label>"
            . "<input type='password' class='form-control' name='password' placeholder='*****'>"
            . "</div>"            
            . "<button type='submit' class='btn btn-success btn-toolbar'>Submit <span class='fa fa-arrow-right'></span></button>"
            
            . "</div>"
            
        . "";
}
else {
    
    Echo "Logget inn";
    
}
    
    
    ?>


</html>
