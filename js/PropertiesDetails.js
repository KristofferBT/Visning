/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

//Henter ut RoomID fra data-href attr. Trigges av onclick pÃƒÂ¥ <a>.
function GetRoomID(identifier){

             RoomID = identifier.getAttribute("data-href");
             //console.log(RoomID);
             
        return false;
        };

$(document).ready(function() {

 $.fn.editable.defaults.mode = 'inline';

 $('[id^=RoomEdit]').click(function(){
           var tempScrollTop = $(document).scrollTop();
            console.log(tempScrollTop);
    
    $(this).parentsUntil('.box').find('.RoomDescription').editable();
    
    $(this).closest('.panel-heading').children('h3').editable();

    console.log('x-edit in action');
    $("html").scrollTop(tempScrollTop);
    
 });
 
    
//Slettebekreftelse dialog
$('#confirm-delete').on('show.bs.modal', function(e) {
    //var RoomID = $(this)('data-href').getAttribute;
    console.log(RoomID);
    
    //$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));


});    

//Prosesser data fra sletting.

$('#DeleteRoom').submit(function(DeleteRoom){
 console.log('Submit DeleteRoom');
  
 //Setter RoomID pÃƒÂ¥ input value
 $("#RoomID").attr("value", RoomID);
 console.log('attr: ' + $('#RoomID').attr('value'));
 
            var formData = {
                                                'RoomID'        : $('input[name=RoomID]').val()
                                        };
               		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: '/inc/RoomDeleteRoom.php', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true
		})
			// using the done promise callback
			.done(function(data) {

				// log data to the console so we can see
                                if (data.success === 'true') {
                                    console.log('Deleted!');
                                    location.reload();
                                }
			})
			// using the fail promise callback
			.fail(function(data) {
                                console.log(data);
                                console.log("Fail function");
				//console.log(data);
			});
        

		// stop the form from submitting the normal way and refreshing the page
		DeleteRoom.preventDefault();                         
                            
        
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
//End - Ãƒâ€¦pner opp nytt rom dialog






	// process the form
	$('#NewRoomForm').submit(function(event) {

		$('.form-group').removeClass('has-error'); // remove the error class
		$('.help-block').remove(); // remove the error text

		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
                
                var formData = {
                                                'PropertyID'        : $('input[name=PropertyID]').val(),
                                                'RoomName'          : $('input[name=RoomName]').val(),
                                                'RoomFloor'         : $('input[name=RoomFloor]').val(),
                                                'RoomType'          : $('select[name=RoomType]').val(),
                                                'RoomDescription'   : $('input[name=RoomDescription]').val()
                                        };
		

		// process the form
                
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: '/inc/RoomNewRoom.php', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true
		})
			// using the done promise callback
			.done(function(data) {

				// log data to the console so we can see
                                console.log('Sjekker data')
				console.log(data); 
                                
                                if (data.success === 'false') {
                                    console.log('Validation error');
                                        
                                
                                    if (data.Errors.RoomFloorError){
                                    console.log('RoomFloorError int')
                                    $('.RoomFloor').addClass('has-error');
                                    $('.RoomFloor').append('<div class="help-block">' + data.Errors.RoomFloorError + '</div>' );
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
                                console.log("Fail function");
				console.log(data);
			});
        

		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});
               
});

