        <style type="text/css">
   
   .TitleHeader {
       color: #000000;
   }
   
   .panel-heading {
       background: #38A8FF !important;
       color: #FFFFFF !important;
   }
   .panel-body {
       color: #000 !important;
   }
   
   .container {
       color: #000 !important;
   }
   .form-group {
       color: #000 !important;
   }
   
   .link-underline {
       text-decoration: underline !important;
   }
   
   
   .footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 30px;
  background-color: #f5f5f5;
  text-align: center;
  /*margin-top: 60px;*/
}

.dropdown-menu-panel-header {
    .glyphicon glyphicon-briefcase {
        margin-left: 0;
    }

}
   
 
/*   Custom navbar color*/
 .navbar-default {
    background-color: #0D83DD !important;
    
    
}

.navbar-default .navbar-brand,
.navbar-default .navbar-brand:hover,
.navbar-default .navbar-brand:focus {
    color: #FFF !important;
}

.navbar-default .navbar-nav > li > a {
    color: #FFF !important;
}

.navbar-default .navbar-nav > li > a:hover,
.navbar-default .navbar-nav > li > a:focus {
    background-color: #56b0f5 !important;
}

.navbar-default .navbar-nav > .active > a,
.navbar-default .navbar-nav > .active > a:hover,
.navbar-default .navbar-nav > .active > a:focus {
    color: #FFF !important;
    background-color: #56b0f5 !important;
}

.navbar-default .navbar-text {
    color: #FFF !important;
}

.navbar-default .navbar-toggle .container-fluid .navbar .navbar-header {
    border-color: #56b0f5 !important;
}

.navbar-default .navbar-toggle:hover,
.navbar-default .navbar-toggle:focus {
    background-color: #56b0f5 !important;
}

.navbar-default .navbar-toggle .icon-bar {
    background-color: #FFF !important;
}

.dropdown-menu ul a {
    color: #FFF !important;
    background: #0D83DD !important;
}
   
  .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
    background-color: #0D83DD !important;
    color:#FFF !important;
  } 
   
/* END  Custom navbar color*/   



</style>
<html>
    <head>
<meta name="description" content="Boligvisning APP - sjekklister for alle rom og eiendom." />
<meta name="description" content="Bolig visning APP - sjekklister for alle rom og eiendom." />
<title>Trygg Visning - Visning på den smarte måten</title>

    </head>
</html>

<!--<script type="text/javascript" src="https://ylx-3.com/banner.php?section=General&pub=916381&format=468x60&ga=g&https=1"></script>
<script type="text/javascript" src="https://ylx-3.com/banner.php?section=General&pub=916381&format=468x60&ga=g&https=1"></script>-->
<?php 
 error_reporting(E_ALL);
            ini_set('display_errors', 1);
session_start();
include_once 'inc/incBootstrap.inc';
//include_once 'Debug.php';
include_once 'inc/incFunctions.php';
include_once 'access.php';
include_once 'inc/analyticstracking.php';

?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="http://www.tryggvisning.no">TRYGG VISNING</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
         <?php
         if(isset($_SESSION['LoggedIn'])){
             echo "<li><a href='../Properties.php?Action=ReportList'>Mine rapporter</a></li>";
             
         }
         ?>
      
      </ul>
        <ul class="nav navbar-nav navbar-right">
         <?php
         if(isset($_SESSION['LoggedIn'])){
             
             echo "<li><a href='../UserProfile.php'>Profil</a></li>";
             echo "<li><a href='http://www.tryggvisning.no/logout.php'>Logg ut</a></li>";
         }
         ?>
      
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <?php
        if(!isset($_SESSION['LoggedIn'])){
                echo "</li>"
                    . "<li class='dropdown' id='menuLogin'>"
                    . "<a class='dropdown-toggle' href='#' data-toggle='dropdown' id='navLogin'>Login</a>"
                    . "<div class='dropdown-menu' style='padding:17px;'>"
                    . "<form class='form' id='formLoginHeader' method='post'> "
                        . "<table><tr><td>"
                        . "<label for='emailheader'>Email</label></td>"
                    . "<td><input name='emailheader' id='emailheader' type='text' placeholder='ola@nordmann.no'></td></tr>"
                        . "<div id='passswordheader'><tr><td><label for='passwordheader'>Passord</label></td>"
                    . "<td><input name='passwordheader' id='passwordheader' type='password' placeholder='Password'></td></tr></div>"
                    . "<tr><td></td><td><button type='submit' name='submit'>Logg inn</button></td></tr>"
                        . "</table>"
                    . "</form>"
                    . "</div>"
                    . "</li>";                              
        }
        if(isset($_SESSION['UserLevel'])){
            if($_SESSION['UserLevel'] === '9' ){
            echo "<li class='dropdown'>"
        . "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Admin<span class='caret'></span></a>"
        . "<ul class='dropdown-menu'>";
                echo "<li><a href='/admin/RoomCheckListAdd.php'>RoomCheckList Add<span class='sr-only'></span></a></li>";
                echo "<li><a href='/admin/RoomCheckList.php'>RoomCheckList List<span class='sr-only'></span></a></li>";
                echo "<li><a href='/admin/PropertyCheckListAdd.php'>PropertyCheckList Add<span class='sr-only'></span></a></li>";
                echo "<li><a href='/admin/PropertyCheckList.php'>PropertyCheckList List<span class='sr-only'></span></a></li>";
        echo "</ul>"
        . "</li>";                                      
        }
        }
      ?>
        
      </ul>
    </div>
  </div>
</nav>

<?php
include_once 'Footer.php';

?>