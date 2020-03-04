<!-- index.php -->
<?php

//if($_SERVER["HTTPS"] != 'on')
//{
//    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
//    exit();
//}

include_once './Header.php'; 
?>
<!doctype html>
<html>
<head>
    <title>Trygg visning</title>
    <script src="/js/UserValidation.js"></script> <!-- load our javascript file -->

</head>

    <style>
        
        /* Show in Large desktops and laptops */
@media (min-width: 1200px) {

.bgimg {
        background: url('https://tryggvisning.no/bgindexkey.jpg');
        background-repeat: no-repeat;

        background-size:100% auto;
    margin: 0;
     
     
      
     
    }

}

/*Hide in Other Small Devices */


/* Landscape tablets and medium desktops */
@media (min-width: 992px) and (max-width: 1199px) {

      .bgimg {
        background-image: none;
    }

}

/* Portrait tablets and small desktops */
@media (min-width: 768px) and (max-width: 991px) {

          .bgimg {
        background-image: none;
    }

}

/* Landscape phones and portrait tablets */
@media (max-width: 767px) {

          .bgimg {
        background-image: none;
    }

}

/* Portrait phones and smaller */
@media (max-width: 480px) {

          .bgimg {
        background-image: none;
    }

}
        
        .bodylanding {

}
    </style>    
<!--<body class='bgimg'>-->
<body>

<?php 

if(isset($_SESSION['LoggedIn'])){
    
        if($_SESSION['LoggedIn'] === 'true') {
                include_once 'inc/PropertiesList.inc';
                
                
        }
    
    
}
    else {
    include_once 'IndexLogin.php';
    
    }


?>    
    
    
    


</body>
</html>
