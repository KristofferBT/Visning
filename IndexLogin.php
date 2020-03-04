<?php


//Hvis bruker ikke er logget inn - vis login form.
if(!isset($_SESSION['LoggedIn'])){
    echo ""
           
            
            . "<div class='col-sm-6 col-sm-offset-2'>"
            . "<div class='jumbotron'>"
            . "<div class='container'>"
            . "<dl>"
            . "<dt><h2 id='headerlogin'>Boligvisning på den smarte måten</h2></dt>"
            . "<h4>- Boligoversikt</h4>"
            . "<h4>- Detaljerte sjekklister for rom og eiendom</h4>"
            . "<h4>- Boligrapport med bilder</h4>"
            . "<h4>- Gratis</h4>"
            . "</dl>"
            . "</div>"
            . "</div>"
            . "<form action='../UserValidation.php' method='POST' id='login'>"
            
            . "<div id='name-group' class='form-group'>"
            . "<label for='email'>Email</label>"
            . "<input type='text' class='form-control' name='email' id='emailinput' placeholder='user@mail.com'>"
            
            . "</div>"
            
            . "<div id='password-group' class='form-group'>"
            . "<label for='password'>Password</label>"
            . "<input type='password' class='form-control passwordmain' name='password' placeholder='*****' id='password'>"
            . "</div>"
            . ""
            . "<div id ='newuser-group' class='form-group'>"
            . "<label for='Fornavn'>Fornavn</label>"
            . "<input type='text' class='form-control' name='firstname' id='firstname' placeholder='Ola'>"
            . "<label for='Etternavn'>Etternavn</label>"
            . "<input type='text' class='form-control' name='lastname' placeholder='Nordmann'>"
            . "<label for='Mobil'>Mobil</label>"
            . "<input type='text' class='form-control' name='mobile' placeholder='99999999'>"
            
            . "<div id='passwordnewuser' class='form-group'>"
            . "<label for='Passord'>Passord</label>"
            . "<div class='passwordnewuser'>"
            . "<input type='password' class='form-control passwordnewuser' name='passwordnewuser' id='passwordnewuser' placeholder='******'>"
            . "</div>"
          
            . "</div></div>"            
            

            . "<button type='submit' class='btn btn-success btn-toolbar'>Submit <span class='fa fa-arrow-right'></span></button>"
            
            
            . "</form>"
            . "</div>"
            
        . "";
}

else {
    
    Echo "Logget inn";
    
}

    
    ?>
