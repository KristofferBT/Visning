/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

function GetPropertyID(identifier){
            
             PropertyID = identifier.getAttribute("data-href");
             console.log(PropertyID);
        return false;
        };
        
function CreatePdfReport(identifier){
  $.ajax({
        url: "../inc/PropertiesReport2pdf.php?PropertyID="+identifier, 
        success: function(result){
            //console.log(result);
            console.log(identifier);
            //console.log('it worked');
        }
    });  
};

$(document).ready(function() {
    $('#PropertyNewProperty').hide();
    $('#PropertiesList').show();
    var RoomTypeName = '0';
    
//    //Make whole div clickable
//    console.log('PropertiesList.js');
//    $("#panelPropertyName").click(function(){
//    if($(this).find("a").length){
//        window.location.href = $(this).find("a:first").attr("href");
//    }
//});

$(function() {
  $('#btn-dialog-message').on('click', function() {

  });
});


//$('select').each(function() {
//    RoomTypeName++;
//    var NewName = 'RoomTypeName'+RoomTypeName;
//    console.log(NewName);
//    $(this).attr('name',NewName);
//    console.log($(this));
//});

function setFocusToTextBox(){
    document.getElementById("PropertyNameInput").focus();
    
}

function closeForm(){
    $('#PropertyNewProperty').hide();
    $('#PropertiesList').show();
}

$('#btn-minimize').click(function(){
    console.log('pushy');
    closeForm();
    
});


// Dialog message
$('#btn-dialog-message').click(function () {
    //$('#PropertyNewProperty').dialog('open');
    $('#PropertyNewProperty').show();
    $('#PropertiesList').hide();
    
    setFocusToTextBox();
    return false;
    
    
    
});
 
//$("#PropertyNewProperty").dialog({
//    
//    autoOpen: false,
//    modal: true,
//    width: 600
//    
//    
//
//});

$('#NewPropertyForm').submit(function(event) {
    console.log('Form Submit');
		$('.form-group').removeClass('has-error'); // remove the error class
		$('.help-block').remove(); // remove the error text

		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
                
                var formData = new FormData($('form')[0]); // Create an arbitrary FormData instance
                
//                var formData = {
//                                                'PropertyName'          : $('input[name=PropertyName]').val(),
//                                                'StreetAddress'         : $('input[name=StreetAddress]').val(),
//                                                'PostalCode'            : $('input[name=PostalCode]').val(),
//                                                'City'                  : $('input[name=City]').val(),
//                                                'FinnCode'              : $('input[name=FinnCode]').val(),
//                                                'PropertyDescription'   : $('input[name=PropertyDescription]').val(),
//                                                'PropertyRoomType'      : $('select[class=RoomType]').val()
//                                                
//                                        };
//                formData.append('test','testervalue');
		console.log(formData);

		// process the form
                
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: '/inc/PropertiesNewProperty.php', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true,
                        processData     : false,
                        contentType     : false
		})
			// using the done promise callback
			.done(function(data) {

				// log data to the console so we can see
                                console.log('Sjekker data')
				console.log(data); 
                                
                                if (data.success === 'false') {
                                    console.log('Validation error')
                                        
                                
                                    if (data.Errors.PropertyNameError){
                                    console.log('PropertyNameError name');
                                    $('.PropertyName').addClass('has-error');
                                    $('.PropertyName').append('<div class="help-block">' + data.Errors.PropertyNameError + '</div>' );
                                }
                                    
                                }
                                
                           

				// here we will handle errors and validation messages
				if ( data.success === 'true') {
                                    console.log('Success insert DB');                                 
                                    location.reload();
				} 
			})
			// using the fail promise callback
			.fail(function(data) {

				// show any errors
				// best to remove for production
                                console.log("Fail function")
				console.log(data);
			});
        

		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});

//Slettebekreftelse dialog
$('#confirm-delete').on('show.bs.modal', function(e) {

});    

//Modal vindu Create Report
$('#create-report').on('show.bs.modal', function(e) {

});    


//Prosesser data fra sletting.

$('#DeleteProperty').submit(function(DeleteProperty){
 console.log('Submit DeleteProperty');
  
 //Setter RoomID pÃƒÂ¥ input value
 $("#PropertyID").attr("value", PropertyID);
 //console.log('attr: ' + $('#PropertyID').attr('value'));
 
            var formData = {
                                                'PropertyID'        : PropertyID
                                        };
               		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: '/inc/PropertiesDelete.php', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true
		})
			// using the done promise callback
			.done(function(data2) {

				// log data to the console so we can see
                                if (data2.success === 'true') {
                                    console.log('Deleted!');
                                    location.reload();
                                }
			})
			// using the fail promise callback
			.fail(function(data2) {

                                console.log("Fail function");
				console.log(data2);
                                console.log('shitstorm.')
			});
        

		// stop the form from submitting the normal way and refreshing the page
		DeleteProperty.preventDefault();                         
                            
        
});


//End - Prosesser data fra sletting.


       
// Ãƒâ€¦pner opp nytt rom dialog
$('#btn-dialog-message').click(function () {
    $('#RoomNewRoom').dialog('open');
    return false;
});
 
$("#RoomNewRoom").dialog({
    
    autoOpen: false,
    modal: true

});



});

