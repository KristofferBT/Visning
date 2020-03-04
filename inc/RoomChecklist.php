<?php
 error_reporting(E_ALL);
            ini_set('display_errors', 1);
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

$CheckAccess = CheckAccess();

if($CheckAccess == 'false'){
    
}
else {            
            
?>

<head>
    <script src="/js/RoomCheckList.js"></script>   
    <script src="/js/PictureResize.js"></script>   
    <style>
        .glyphicon-ok {
            color: green;
            margin-left: 15px;
        }
        .glyphicon-minus {
            color: yellow;
            margin-left: 15px;
        }
        .glyphicon-remove {
            color: red;
            margin-left: 15px;
        }
        .glyphicon-camera {
            color: black;
            margin-left: 5px;
            font-size: 1.5em;
        }
        
           .fa-smile-o {
            color: black;
            /*background-color: green;*/
            margin-left: 15px;
            margin-top: 0px;
            font-size: 1.5em;
            font-weight: bold;
            vertical-align: middle;
            
        }
        
        .fa-meh-o {
            color: black;
            /*background-color: yellow;*/
            margin-left: 15px;
            margin-top: 0px;
            font-size: 1.5em;
            font-weight: bold;
            vertical-align: middle;
            
        }
        
        .fa-frown-o {
            color: black;
            /*background-color: red;*/
            margin-left: 15px;
            margin-top: 0px;
            font-size: 1.5em;
            font-weight: bold;
            vertical-align: middle;
            
        }
          
        .panel-heading {
            vertical-align: middle;
            
        }
        
        .btn-group {
            vertical-align: bottom;
        }
        
        .btn:focus {
            border: 5px;
            border-color: black;
}

/* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
.modalupload {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('../img/ajax-loader.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modalupload {
    display: block;
}
        
        
        
    </style>
</head>



<div id='RoomCheckList'>

          <div class="col-sm-5">
              
<?php
if(isset($_SESSION['SelectedRoomID'])){
    $SelectedRoomID = $_SESSION['SelectedRoomID'];    
}


if(isset($_SESSION['SelectedPropertyID'])) {
    $SelectedPropertyID = $_SESSION['SelectedPropertyID'];    
}


echo "<a href='https://www.tryggvisning.no/Properties/Details/".$SelectedPropertyID."' class='btn btn-success' role='button'>Romoversikt</a>";

$sql = "select * from CustomerRoomCheckList where CustomerRoomID = :RoomID";

$stmtcl2 = $dbh->prepare($sql);
$stmtcl2->BindValue(':RoomID', $_REQUEST['RoomID'], PDO::PARAM_INT);
$stmtcl2->Execute();
    
$RoomID = $_REQUEST['RoomID'];

foreach ($stmtcl2 as $row) {
    
    

    echo "<div id='box'>"
            . "<div class='panel panel-default'>"
            . "<div class='panel-heading' id='panelPropertyName'>"
            . "<form class='panel-title' action='/inc/RoomChecklistUpdate.php' method='POST' id='RoomCheckListForm". $row['CustomerRoomCheckListID'] ."'>"
            . "<input type='hidden' name='CustomerRoomCheckListID' value='". $row['CustomerRoomCheckListID']."'>"
            
            . "<div class='btn-group pull-right' data-toggle='buttons'>"
            . "<label class='btn fa fa-smile-o btn-xs'>"
            . "<input type='radio' autocomplete='off' name='tg1' id='tg1'></label>"
            . "<label class='btn fa fa-meh-o btn-xs'>"
            . "<input type='radio' autocomplete='off' name='tg2' id='tg2'></label>"
            . "<label class='btn fa fa-frown-o btn-xs'>"
            . "<input type='radio' autocomplete='off' name='tg3' id='tg3'></label>"
            . "<a href='#NewMedia' class='glyphicon glyphicon-camera' id='cam'></a>"
            . "</div>"
            . "</form>"
            
            . "<p class='panel-title' id='panelPropertyName'>" . $row['CustomerRoomCheckListTitle'] . "";
            if($row['CustomerRoomCheckListEvaluation'] === '1') {
                echo "<i class='fa fa-smile-o'></i>";
            }
                        if($row['CustomerRoomCheckListEvaluation'] === '2') {
                echo "<i class='fa fa-meh-o'></i>";
            }
                        if($row['CustomerRoomCheckListEvaluation'] === '3') {
                echo "<i class='fa fa-frown-o'></i>";
            }
            echo "</p></div>"
            . "<div class='panel-body'>"
            . $row['CustomerRoomCheckListText']
            . "</div>"
            
            . "<div id='cameraupload'><form method='POST' action='/inc/RoomCheckListPicture.php' class='CameraUpload' id='CameraUpload' enctype='multipart/form-data'>"
            . "<input type='hidden' name='RoomID' value='".$row['CustomerRoomID']."'>"
            . "<input type='hidden' name='PropertyID' value='".$row['CustomerPropertyID']."'>"
            . "<input type='hidden' name='CheckListID' value='".$row['CustomerRoomCheckListID']."'>"
            . "<input style='display: none' type='file' name='uploadedfile' accept='image/*' capture='camera' id='camclick' onchange='uploadPhotos()'>"
            . "</form></div>"
            . "</div>"
            . "</div>";
             
}

$sqlcomment = "select Comment from CustomerRoomCheckListComment where RoomID = $RoomID";
$stmtcomment = $dbh->query($sqlcomment);
$Comment = $stmtcomment->fetchColumn();

echo ""
    . "<div class='panel panel-default'>"
        . "<div class='panel-heading'>"
        . "<p class='panel-title'>Kommentar</p>"
        . "</div>"
        . "<div class='panel-body'>"
        . "<a data-type='textarea' data-url='../inc/RoomCheckListComment.php' "
        . "data-pk='".$RoomID."' data-placeholder='' data-title='Enter comments' data-value='".$Comment."' id='RoomCheckListComment'></a>"
        . "</div>";


}
?>
              
          </div>

</div>
<div id='cameraupload'>
    <form>
        <input type='hidden' name='RoomID'>
        <input type='hidden' name='PropertyID'>
        <input type='hidden' name='CheckListID'>
        <input style='opacity: 0' type="file" name="uploadedfile" accept="image/*" capture="camera" id='camclick'>
        
        
    </form>
    
    
</div>

<div class="modalupload"></div>

