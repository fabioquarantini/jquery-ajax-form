$( document ).ready(function() {

	$( '.form' ).on( 'submit', function( event ) {

		event.preventDefault();

		$('.form__row').removeClass('form__row--error');
		$('.form__error, .form__message').remove();

		$.ajax({

			type: $( this ).attr('method'),
			url: $( this ).attr('action'),
			data: $( this ).serialize(),
			dataType: 'json'

		}).done( function( data ) {

			// console.log(data);  // Only for debug

			if ( !data.success ) {

				$.each( data.errors, function( element, message ) {
					$('#' + element).parent('.form__row').addClass('form__row--error').append('<div class="form__error">' + message + '</div>');
				});

			} else {

				$( '.form' ).append('<div class="form__message form__message--success">' + data.message + '</div>');
			}

		}).fail( function( data ) {

			// console.log(data);  // Only for debug

		});

	});

});