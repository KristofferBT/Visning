// magic.js
$(document).ready(function() {
    
   //Setter email input i focus 
   document.getElementById("emailinput").focus();

    
    console.log('UserValidation.js');
    $("#password-group").hide();
    $("#newuser-group").hide();

	// process the form - body index
	$('#login').submit(function(event) {

		$('.form-group').removeClass('has-error'); // remove the error class
		$('.help-block').remove(); // remove the error text

		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
                
                    if($('#password').val()){
                            console.log('Form password is defined');
                                var formData = {
                                                'email'         : $('input[name=email]').val(),
                                                'password' 	: $('input[name=password]').val() 
                                        };               
                        }
                        else {
                            console.log('ELSE')
                            var formData = {
                                'email'         : $('input[name=email]').val(),
                                
                                        };
                        }
                        if($('#firstname').val()){
                            console.log('Form New User is defined')
                                var formData = {
                                                'email'         : $('input[name=email]').val(),
                                                'firstname'         : $('input[name=firstname]').val(),
                                                'lastname'         : $('input[name=lastname]').val(),
                                                'mobile'         : $('input[name=mobile]').val(),
                                                'passwordnewuser' 	: $('input[name=passwordnewuser]').val() 
                                        };
                            
                                        
                        }
		// process the form
                
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: '/UserValidation.php', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true
		})
			// using the done promise callback
			.done(function(data) {

				// log data to the console so we can see
                                console.log('Sjekker data');
				console.log(data);
                                console.log("Errors:" + data.Errors.PasswordError);
                                

				// here we will handle errors and validation messages
                                
                                if (data.success === false) {
                                    console.log('Validation error');
                                        
                                
                                    if (data.Errors.PasswordError){
                                    console.log('Passworderror');
                                    console.log(data.Errors.PasswordError);
                                    $('.passwordnewuser').addClass('has-error');
                                    $('.passwordnewuser').append('<div class="help-block">' + data.Errors.PasswordError + '</div>' );
                                }
                                if (data.Errors.PasswordValidationError){
                                    console.log('PasswordValidationError');
                                    console.log(data.Errors.PasswordValidationError);
                                    $('#password-group').addClass('has-error');
                                    $('#password-group').append('<div class="help-block">' + data.Errors.PasswordValidationError + '</div>' );
                                    $('#password-group').append('<div class="">' + '<a href="/ForgotPassword.php" style="color: black;">Glemt passord</a>' + '</div>' );
                                }
                                    
                                }
                                
                                
                                
				if ( data.EmailCount == '1') {
                                    console.log('Email finnes - vis login');
                                    //Viser password input
                                    $("#password-group").show();
                                    //Setter input i focus
                                    document.getElementById("password").focus();
                                    $("#newuser-group").hide();
                                    $("#headerlogin").text("Logg inn");
                                    
                                    if ( data.LoggedIn == true) {
                                        
                                        
                                        $.ajax({
                                          url: "../inc/SetCookie.php?KakeSpade=" + data.KakeSpade + "&" + "KakeBit=" + data.KakeBit, 
                                          success: function(result){
                                              console.log(result);
                                              console.log(identifier);
                                              //console.log('it worked');
                                          }
                                            });  
                                        
                                        window.location = 'http://www.tryggvisning.no';
                                    }
					
                                        
                                        
					

				} else {
                                    console.log('Email finnes ikke - vis brukerreg.')
                                    //console.log(data)
                                    $("#password-group").hide();
                                    $("#newuser-group").show();
                                    document.getElementById("firstname").focus();
                                    $("#headerlogin").text("Ny bruker");
                                    
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

	$('#formLoginHeader').submit(function(event) {
            console.log('formLoginHeader');

		$('.form-group').removeClass('has-error'); // remove the error class
		$('.help-block').remove(); // remove the error text

		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
                
                    if($('#passwordheader').val()){
                            console.log('Form password is defined');
                                var formData = {
                                                'email'         : $('input[name=emailheader]').val(),
                                                'password' 	: $('input[name=passwordheader]').val() 
                                        };               
                        }
		// process the form
                
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: '/UserValidation.php', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true
		})
			// using the done promise callback
			.done(function(data) {

				// log data to the console so we can see
                                console.log('Sjekker data');
				console.log(data); 
                                console.log("Errors header:" + data.Errors.PasswordError);

				// here we will handle errors and validation messages
                                
                                if (data.success === false) {
                                    console.log('Validation error');
                                        
                                
                                    if (data.Errors.PasswordError){
                                    console.log('Passworderror');
                                    console.log(data.Errors.PasswordError);
                                    $('.passwordnewuser').addClass('has-error');
                                    $('.passwordnewuser').append('<div class="help-block">' + data.Errors.PasswordError + '</div>' );
                                }
                                if (data.Errors.PasswordValidationError){
                                    console.log('PasswordValidationError');
                                    console.log(data.Errors.PasswordValidationError);
                                    $('#passswordheader').addClass('has-error');
                                    $('#passswordheader').append('<div class="help-block">' + data.Errors.PasswordValidationError + '</div>' );
                                    $('#passswordheader').append('<div class="">' + '<a href="/ForgotPassword.php" style="color: black;">Glemt passord</a>' + '</div>' );
                                }
                                    
                                }
                                
                                
                                
				                                   
                                    if ( data.LoggedIn == true) {
                                        window.location = 'http://www.tryggvisning.no';
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

});