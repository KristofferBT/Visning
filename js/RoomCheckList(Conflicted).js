/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */


$(document).ready(function() {
   console.log('RoomCheckList.js');

    //Åpne fildialog/camera input ved trykk på camera icon
    $('a[href="#NewMedia"]').click(function(){
        console.log('cam click');
       $('#camclick').trigger('click');
       
       //Submit form her - finne riktig form.
       
     //Håndtere filinput her. Ajax post til RoomCheckListPicture.php her - json respons på data variabel.  
       
    });
    
    $(this).parentsUntil('.box').find('#camclick').onchange = function() {
    console.log('found change');
    $(this).parentsUntil('.box').find('.CameraUpload').submit();
};  

//$('#camclick').change(function(event){
//   console.log('Bilde er lastet inn - fortsetter');
//   
//   //
//   //$(this).form().submit();
//   
//   form = $(this).form();
//   
//   var formData = new FormData($(form)[0]);
//   
//   
//   
//   
//   		$.ajax({
//			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
//			url 		: '/inc/RoomCheckListPicture.phpX', // the url where we want to POST
//			data 		: formData, // our data object
//			dataType 	: 'json', // what type of data do we expect back from the server
//			encode 		: true,
//                        processData     : false,
//                        contentType     : false
//		})
//   
//   .done(function(data) {
//
//				// log data to the console so we can see
//                                
//				console.log(data); 
//                                
//                                if (data.success === 'true') {
//                                    console.log('Success');
//
//                                    console.log(data.post);
//                                    console.log(data.files);
//                                    location.reload();
//                                  
//                                }
//                                else {
//                                    console.log('error');
//                                    console.log(data);
//                                    
//                                }
//			})
//			// using the fail promise callback
//			.fail(function(data) {
//
//				// show any errors
//				// best to remove for production
//                                console.log("Fail function");
//				console.log(data);
//			});
//        
//
//		// stop the form from submitting the normal way and refreshing the page
//		event.preventDefault();
//   
//});
    
    

    //Overvåke endring på radiobutton
    $('[id^=tg]').change(function(event){    
        form = $(this).parents('form:first');
                
        //$(form).submit();
        
        var formData = new FormData($(form)[0]); // Create an arbitrary FormData instance
                
		console.log(formData);

		// process the form
                
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: '/inc/RoomChecklistUpdate.php', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true,
                        processData     : false,
                        contentType     : false
		})
			// using the done promise callback
			.done(function(data) {

				// log data to the console so we can see
                                
				console.log(data); 
                                
                                
                                if (data.success === 'true') {
                                    console.log('Success');
                                    location.reload();
                                  
                                }
                                else {
                                    console.log('error');
                                    console.log(data);
                                    
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