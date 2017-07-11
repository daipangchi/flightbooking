$(document).ready(function() {

	// Namnet på cookien
	var cookiename 	= "flygresor_optin";
	// Klassen som popupen lägger sig i
	var activeclass = ".ui-optin-wrapper";
	// Url för att skicka datan till
	var ajaxurl		= "/nyhetsbrev";

	// Viktigt!!!!!!!!!!!!!!
	//deleteCookie( cookiename ); // Ta bort cookien för testsyfte
	
	var optin 		= checkCookie( cookiename );
	var header		= "Flygresor.com Nyhetsbrev!";
	var saletexts	= new Array(
					  "Kanonerbjudanden helt kostnadsfritt!"
					  );
	var respok		= "Tack, vi har registrerat dig till vårt nyhetsbrev!";
	var resperrmail	= "Du har angett en felaktig epostadress";
	var resperrserv	= "Ett fel har inträffat. Vänligen försök igen";
	var thissite	= "flygresor.com";
	
	createHtml();	// Skapar HTML koden och placerar i dom:en

	if( checkCookie( cookiename ) ){

		setTimeout(function(){
			showOptin();
			setCookieActive( cookiename );
		}, 3000);
	}

	function isElementVisible(elementToBeChecked){

	    var TopView = $(window).scrollTop();
	    var BotView = TopView + $(window).height();
	    var TopElement = $(elementToBeChecked).offset().top;
	    var BotElement = TopElement + $(elementToBeChecked).height();

	    return ((BotElement <= BotView) && (TopElement >= TopView));
	}
	
	function setButtonClicks() {

		// Stänger optin boxen
		$('.ui-optin-overlay, .ui-optin-close').on("click", function(){
			hideOptin();
		});

		// Skickar mailet
		$('.ui-optin-submit').on("click", function(){
			submitMail();
		});

		$('.ui-optin-submit-mobile').on("click", function(){
			submitMail();
		});

		// Stänger boxen med ESC knappen
		$(document).keyup(function(e) {
		  	if (e.keyCode == 27) { 
		  		hideOptin();
			} 
		});
	}

	function createHtml() {
		
		// Skapar html-kodenför optin boxen och lägger ut den i domen

		var uiOverlay = $('<div/>', {
			'class'  : "ui-optin-overlay"
		});
		
		var uiWrapper = $('<div/>', {
			'class' : 'ui-optin'
		});

		var uiClose = $('<div/>', {
			'class' : 'ui-optin-close',
			'html' : 'X'
		}).appendTo( uiWrapper );

		var uiHeader = $('<div/>', {
			'class' : 'ui-optin-header',
			'html' : header
		}).appendTo( uiWrapper );

		var uiList = $('<ul/>', {
			'class' : 'ui-optin-list'
		});

		$.each(saletexts, function(i) {

			var li = $('<li/>', {
				'html' : saletexts[i]
			}).appendTo( uiList );
		});

		uiList.appendTo( uiWrapper );

		var uiInputWrapper = $('<div/>', {
			'class' : 'ui-optin-input'
		});

		var uiInputFieldWrapper = $('<span/>', {
			'class' : 'ui-email-wrapper'
		}).appendTo( uiInputWrapper );

		var uiInputField = $('<input/>', {
			'type'  : 'text',
			'class' : 'ui-email',
			'placeholder' : 'Fyll i din epostadress....'
		}).appendTo( uiInputFieldWrapper );

		var uiInputSubmit = $('<div/>', {
			'class' : 'ui-optin-submit-mobile'
		}).appendTo( uiInputFieldWrapper );

		var uiInputSubmit = $('<div/>', {
			'class' : 'ui-optin-submit',
			'html' : 'Skicka'
		}).appendTo( uiInputFieldWrapper );

		var uiInputSubmit = $('<div/>', {
			'class' : 'ui-option-ok'
		}).appendTo( uiInputWrapper );

		var uiInputSubmit = $('<div/>', {
			'class' : 'ui-option-error'
		}).appendTo( uiInputWrapper );

		uiInputWrapper.appendTo( uiWrapper );
	
		$( activeclass ).append( uiWrapper );
		$( activeclass ).append( uiOverlay );

		// Sätter clicks på knappar efter att fönstret är skapat
		setButtonClicks();
	}

	function checkCookie( name ) {

		// Cookie finns, optin inte visad tidigare. aktivera ej 
		if( $.cookie( name ) == 0 ) {

			return true;
		}
		// Cookie finns, optin är visad tidigare aktivera
		else if( $.cookie( name ) == 1 ) {

			return false;
		}
		// Ingen cookie finns som innehåller optin, skapa en och aktivera optin
		else {

			setCookieInactive( name );
			return true;
		}
	}

	function setCookieInactive( name ) {

	    // Skapar en cookie med långt utgångsdatum
	    $.cookie(name, '0', { expires: 99999, path: '/' });
	}

	function setCookieActive( name ) {

	    // Skapar en cookie med långt utgängsdatum
	    $.cookie(name, '1', { expires: 99999, path: '/' });
	}

	function deleteCookie( name ) {

		// Tar bort cookien som är satt för testsyfte
		$.cookie(name,' 0', { expires: 99999, path: '/' });
	}

	function showOptin() {

		// Visar optin boxen
		$('.ui-optin-overlay').fadeIn("fast", function(){
			$('.ui-optin').fadeIn("fast");
		});
	}
	
	function hideOptin() {

		// Döljer optin boxen
		$('.ui-optin').fadeOut("fast", function(){
			$('.ui-optin-overlay').fadeOut("fast");
		});
	}
	function submitMail(e){

		// Testar och lagrar epostadressen
		$('.ui-option-ok').hide();
		$('.ui-option-error').hide();

		var mail = $('.ui-email').val();

		if( checkMail(mail) ){

			sendMail( mail, thissite );
		}
		else{
			$('.ui-option-error').show();
			$(".ui-option-error").text(resperrmail);
		}
	}

	// Skickarmaildatan till serverk och kontrollerar resultatet
	function sendMail( getmail, getsite ) {

		var security = $('[name=_security]').val();

		$.ajax({

			url: ajaxurl,
			type: 'POST',
			data: { email:getmail, _security: security },

		  	complete: function(){},
		  	success: function( data ){

		  		$('.ui-option-ok').show();
					$(".ui-option-ok").text(respok);
				
					setTimeout(function(){
					   hideOptin();
					}, 2000);

		  	},
		  	error: function(){

		  		 $('.ui-option-error').show();
				$(".ui-option-error").text(resperrserv);
		  	}
		});
	}

	function checkMail(mail) {

		var re = /\S+@\S+\.\S+/;
		return re.test(mail);
	}
});