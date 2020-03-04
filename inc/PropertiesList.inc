

<?php

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */
$CheckAccess = CheckAccess();

if($CheckAccess == 'false'){
    //echo "Ingen tilgang.";
}
else {
?>


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



<script src="/js/PropertiesList.js"></script>   

<div class="page-header">
        <h1 class='TitleHeader'>Eiendomsoversikt</h1>
      </div>

<!-- Dialog -->
<section id="dialog">
    <p class="dialog-button">
        <button class='btn btn-success' id="btn-dialog-message">Ny eiendom</button>
    </p>
</section>

<?php

        //var_dump($_COOKIE);
    

    echo ""
    . "<div id='PropertyNewProperty' class='container clearfix'>"
            . "<div class='row'>"
            . "<div class='col-md-5'>"
            . "<div class='panel panel-primary'>"
            
            . "<div class='panel-heading'>"
            
            . "<div class='btn-group btn-group-xs pull-right'>
                              <a href='#'
                class='btn btn-danger' id='btn-minimize'><span
                class='glyphicon glyphicon-minus'></span></a>
            </div>"
            . "<h3 class='panel-title'>Legg til ny eiendom</h3>"
            . "</div>"
            
            . "<div class='panel body'>"
            
            . "<form action='/inc/PropertiesNewProperty.php' method='POST' id='NewPropertyForm' name='NewPropertyForm' class='form-horizontal' role='form'>"
                        
            . "<div id='PropertyName' class='form-group'>"
            . "<label for='PropertyName' class='col-sm-3 control-label'>Navn</label>"
            . "<div class='col-sm-9 PropertyName'>"
            . "<input type='text' name='PropertyName' placeholder='Navn' id='PropertyNameInput' class='form-control'>"
                . "</div></div>"
            
            . "<div id='PropertyType' class='form-group'>"
            . "<label for='PropertyType' class='col-sm-3 control-label'>Type</label>"
            . "<div class='col-sm-9'>"
            . "<select name='PropertyTypeID' id='PropertyType' class='form-control'>";
            $stmt = $dbh->Query("select * from [PropertyTypes] Order by PropertyTypeName asc");
            foreach ($stmt as $PropertyType) {
                echo "<option value='" . $PropertyType['PropertyTypeID'] . "'>" . $PropertyType['PropertyTypeName'] . "</option>";
            }
            echo "</select>"
                    . "</div></div>"
            
            . "<div id='StreetAddress' class='form-group'>"
            . "<label for='StreetAddress' class='col-sm-3 control-label'>Adresse</label>"
            . "<div class='col-sm-9'>"
            . "<input type='text' name='StreetAddress' placeholder='Adresse' class='form-control'>"
                    . "</div></div>"
            
            . "<div id='PostalCode' class='form-group'>"
            . "<label for='PostalCode' class='col-sm-3 control-label'>Postnr</label>"
            . "<div class='col-sm-9'>"
            . "<input type='text' name='PostalCode' placeholder='Postnr' class='form-control'>"
                    . "</div></div>"
                       
            . "<div id='City' class='form-group'>"
            . "<label for='City' class='col-sm-3 control-label'>By</label>"
            . "<div class='col-sm-9'>"
            . "<input type='text' name='City' placeholder='By' class='form-control'>"
                    . "</div></div>" 
            
            . "<div id='FinnCode' class='form-group'>"
            . "<label for='FinnCode' class='col-sm-3 control-label'>Finnkode</label>"
            . "<div class='col-sm-9'>"
            . "<input type='text' name='FinnCode' placeholder='Finnkode' class='form-control'>"
                    . "</div></div>" 

            . "<div id='PropertyDescription' class='form-group'>"
            . "<label for='PropertyDescription' class='col-sm-3 control-label'>Beskrivelse</label>"
            . "<div class='col-sm-9'>"
            . "<input type='text' name='PropertyDescription' placeholder='Kort beskrivelse' class='form-control'>"
                    . "</div></div>"
            
            . "<div id='RoomGroup' class='form-group'>";
            
    $stmtr = $dbh->query("select * from [RoomTypes] order by RoomTypeName asc");
    $id = '0';
    foreach ($stmtr as $row) {
        $id++;
        $RoomTypeName = 'RoomTypeName' . $row['RoomTypeID'];
        $RoomTypeName = str_replace(' ', '_', $RoomTypeName);
        //$row['RoomTypeName'] = str_replace(' ', '_', $row['RoomTypeName']);
        echo "<div id='" .$row['RoomTypeName'] . "'>";
        echo "<label for='" . $row['RoomTypeName'] . "'  class='col-sm-3 control-label'>" . $row['RoomTypeName'] . "</label>";
                
        echo "<div class='col-sm-9'>";
        echo "<select name='" . $RoomTypeName . "' class='form-control'>";
                    //Legge inn 0 -> 8 option på alle select
                    for ($i = 0; $i <= 8; $i++){
                        echo "<option value='" . $i . "'>" . $i . "</option>";
                        //end for
                        }
        echo "</select>"
              . "</div>"
                  . "</div>";
        
        //end foreach
        }
            echo "</div>"; //End div id RoomGroup
        echo "<div id='Submit' class='form-group'>";
        echo "<div id='submit' class='col-sm-offset-1 col-sm-3'>"
        . "<button type='submit' class='btn btn-success'>Submit <span class='fa fa-arrow-right'></span></button></div></div>"

        . "</form>"
        . "</div>"
        . "</div>"
        . "</div>"    
        . "</div>"
        . "</div>";
    
    ?>

<div id='PropertiesList'>

          <div class="col-sm-10">
              
<?php
$UserID = $_SESSION['UserID'];
$sql = "select * from [properties] where UserID = $UserID and DeletedDate is null";
$stmtp = $dbh->query($sql);

foreach ($stmtp as $row) {
    //echo var_dump($row);
    echo ""
            . "<div class='panel panel-default'>"
            . "<div class='panel-heading' id='panelPropertyName'>"
           
            . "<div class='btn-group pull-right btn-group-xs'>"
            . "<button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>"
            . "Valg &nbsp"
            . "<span class='glyphicon glyphicon-chevron-down'>"            
            . "</button>"
            . "<ul class='dropdown-menu dropdown-menu-right dropdown-menu-panel-header'>"
                . "<li><a class='dropdown-item' href='/Properties.php?Action=Details&PropertyID=" . $row['PropertyID'] ."'>"
                    . "<span class='glyphicon glyphicon-th-list'></span>"
                    . "&nbsp Rom"
                    . "</a>"
                . "</li>"
            
                . "<li><a class='dropdown-item' href='/Properties.php?action=PropertyCheckList&PropertyID=".$row['PropertyID']."'>"
                    . "<span class='glyphicon glyphicon-check'></span>"
                    . "&nbsp Sjekkliste Eiendom"
                    . "</a>"
                . "</li>"
            
                . "<li><a class='dropdown-item' href='#/Properties.php?action=Report&PropertyID=".$row['PropertyID']."' onclick='CreatePdfReport(".$row['PropertyID'].");' data-target='#create-report' data-toggle='modal'>"
                    . "<span class='glyphicon glyphicon-briefcase'></span>"
                    . "&nbsp Boligrapport"
                    . "</a>"
                . "</li>"
                . "<li><a class='dropdown-item' href='#' id='RoomEdit'>"
                    . "<span class='glyphicon glyphicon-pencil'></span>"
                    . "&nbsp Rediger"
                    . "</a>"
                . "</li>"            
                . "<li><a class='dropdown-item' href='#' onclick='GetPropertyID(this)' id='PropertyDelete' data-href='" . $row['PropertyID'] . "' data-target='#confirm-delete' data-toggle='modal'>"
                    . "<span class='glyphicon glyphicon-remove-circle'></span>"
                    . "&nbsp Slett Eiendom"
                    . "</a>"
                . "</li>"
            . "</ul>"
            . "</div>"
                        
            
            . "<h3 class='panel-title'"
            . " id='panelPropertyName'><a class='link-underline' href='/Properties.php?Action=Details&PropertyID=" . $row['PropertyID'] ."'>" . $row['PropertyName'] . "</a></h3>"
            . "</div>"
            . "<div class='panel-body'>"
            . $row['PropertyShortDescription']
            . "</div>"
            . "</div>";
             
}

}
?>
              
          </div>

</div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Bekreftelse
            </div>
            <div class="modal-body">
                Er du sikker på at du vil slette boligen?
            </div>
            <form id="DeleteProperty" method="POST" action="/inc/PropertiesDelete.php">
            <input type="hidden" value="X" id="PropertyID" name="PropertyID">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
                <button type="submit" name="submit" class="btn btn-danger btn-ok">Slett</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="create-report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Boligvisning rapport</h3>
            </div>
            <div class="modal-body">
                <b>Rapport bestilt!</b>
                <br>Du vil få varsel på mail når den er generert.
                <br>Rapporten er tilgjengelig via 'Mine Rapporter' i hovedmenyen.
            </div>
            <form id="CreateReport">
            
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </form>
        </div>
    </div>
</div>