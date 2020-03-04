
<?php

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */
$CheckAccess = CheckAccess();

if($CheckAccess == 'false'){
    echo "Ingen tilgang.";
}
else {
    


?>
<head>
    <script src="/js/PropertiesDetails.js"></script>   
 <style>
        .glyphicon-remove-circle {
            color: red;
            margin-left: 5px;
        }
        .glyphicon-pencil {
            color: black;
            margin-left: 5px;
        }
        .glyphicon-th-list {
            color: green;
            margin-left: 5px;
        }
        .glyphicon-briefcase {
            color: black;
            margin-left: 5px;
        }
        
        .glyphicon-cog{
            margin-left: 5px;
        }
        
        .glyphicon-check {
            color: green;
            margin-left: 5px;
        }
        
        
        
    </style>
    
</head>

<body>
    
<div class="page-header">
    <h1 class='TitleHeader'>Rom</h1>
      </div>
<!-- Dialog -->
<section id="dialog">
    <p class="dialog-button">
        <button class='btn btn-success' id="btn-dialog-message">Nytt rom</button>
    </p>
</section>
    <?php 
    echo "<a href='https://www.tryggvisning.no' class='btn btn-success' role='button'>Eiendomsoversikt</a>";
    echo ""
        . "<div id='RoomNewRoom' class='form-inline' title='Legg til nytt rom'>"
            
            . "<form action='/inc/RoomNewRoom.php' method='POST' id='NewRoomForm' name='NewRoomForm'>"
            . "<input type='hidden' name='PropertyID' value='" . $_REQUEST['PropertyID'] . "'>"
            
            . "<div id='RoomName' class='form-group'><label for='RoomName'>Navn</label>"
            . "<input type='text' name='RoomName' placeholder='Romnavn' class='form-control'></div>"
            
            . "<div id='RoomFloor' class='form-group RoomFloor'><label for='RoomFloor'>Etasje</label>"
            . "<input type='text' name='RoomFloor' placeholder='Etasjenummer' class='form-control'></div>"
            
            . "<div id='RoomType' class='form-group'><label for='RoomType'>Romtype</label>"
            . "<br/><select name='RoomType' id='RoomType' class='form-control'>";
            $stmt = $dbh->Query("select * from [RoomTypes] Order by RoomTypeName asc");
            foreach ($stmt as $roomtype) {
                echo "<option value='" . $roomtype['RoomTypeID'] . "'>" . $roomtype['RoomTypeName'] . "</option>";
            }
            echo "</select></div>";
            echo "<div id='RoomDescription' class='form-group'><label for='RoomDescription'>Beskrivelse</label>"
            . "<input type='text' name='RoomDescription' placeholder='Kort beskrivelse' class='form-control'></div>"
            . "<button type='submit' class='btn btn-success btn-toolbar'>Submit <span class='fa fa-arrow-right'></span></button>"
            . "</form></div>"
    
    ?>
    
    <!--Panels-->
          <div class="col-sm-8">


<?php
$UserID = $_SESSION['UserID'];
$sql = "SELECT
	*
FROM
	 [Properties] P
		left join
	[Room] R on P.PropertyID = R.PropertyID
		left join
	[RoomTypes] RT on R.RoomType = RT.RoomTypeID where P.PropertyID = :PropertyID and P.UserID = $UserID and P.DeletedDate is null and R.DeletedDate is null order by RoomType asc";

 $stmt = $dbh->Prepare($sql);
 $stmt->BindValue(':PropertyID', $_REQUEST['PropertyID'], PDO::PARAM_INT);
 $stmt->Execute();
 
 
 
     
 
 
      foreach ($stmt as $row) {
 
    echo "<div class='box'>"
            . "<div class='panel panel-default'>"
            . "<div class='panel-heading'>"
   
            . "<div class='btn-group pull-right btn-group-xs'>"
            . "<button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>"
            . "Valg &nbsp"
            . "<span class='glyphicon glyphicon-chevron-down'>"            
            . "</button>"
            . "<ul class='dropdown-menu dropdown-menu-right dropdown-menu-panel-header'>"

            
                . "<li><a class='dropdown-item' href='/Properties.php?Action=RoomCheckList&RoomID=" . $row['RoomID'] ."''>"
                    . "<span class='glyphicon glyphicon-check'></span>"
                    . "&nbsp Sjekkliste Rom"
                    . "</a>"
                . "</li>"

                . "<li><a class='dropdown-item' data-href='" . $row['RoomID'] . "' id='RoomEdit" . $row['RoomID'] ."'>"
                    . "<span class='glyphicon glyphicon-pencil'></span>"
                    . "&nbsp Rediger"
                    . "</a>"
                . "</li>"            
            
                . "<li><a class='dropdown-item' href='#' onclick='GetRoomID(this);' id='RoomDelete' data-href='" . $row['RoomID'] . "' data-target='#confirm-delete' data-toggle='modal'>"
                    . "<span class='glyphicon glyphicon-remove-circle'></span>"
                    . "&nbsp Slett Rom"
                    . "</a>"
                . "</li>"
            
            . "</ul>"
            . "</div>"
                . "<h3 class='panel-title' data-type='text' data-url='/inc/RoomUpdateRoom.php' id='RoomName' data-value='" . $row['RoomName'] . "' data-pk='" . $row['RoomID'] ."'>" . $row['RoomName'] . "</h3>"
            . "</div>"

            . "<div class='panel-body'>"
            . "<a class='RoomDescription' id='RoomDescription' data-type='textarea' data-url='/inc/RoomUpdateRoom.php' "
            . "data-pk='" . $row['RoomID'] ."' "
            . "data-placeholder='Rombeskrivelse' data-title='Enter comments' data-value='" . $row['RoomDescription'] ."'>" . $row['RoomDescription'] ."</a>"
            
            . "</div>"
            
            . "</div>"
            . "</div>"
            . "<br>";
             
}
}
?>
</div>

    
 <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Bekreftelse
            </div>
            <div class="modal-body">
                Er du sikker på at du vil slette rommet?
            </div>
            <form id="DeleteRoom" method="POST" action="/inc/RoomDeleteRoom.php">
            <input type="hidden" value="1000" id="RoomID" name="RoomID">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
                <button type="submit" name="submit" class="btn btn-danger btn-ok">Slett</button>
            </div>
        </form>
        </div>
    </div>
</div>
    
</body>