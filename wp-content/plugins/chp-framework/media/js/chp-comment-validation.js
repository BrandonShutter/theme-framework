/* This handy little script validates the comment form */

jQuery(document).ready(function( $ ) {

	form = $('#comment-form');

	var placeholders = {
		author:  form.find('#author').val(),
		email:   form.find('#email').val(),
		comment: form.find('#comment').val()
	};

	var errorColor = '#e17060';

	form.submit(function() {

		var values = {
			author:  $(this).find('#author').val(),
			email:   $(this).find('#email').val(),
			comment: $(this).find('#comment').val()
		};

		/* Validation */
		var errors = {};

		$('.error').removeClass('error');

		// Only validate the name and email field if the user is not logged in
		if ( ! $(this).hasClass('logged-in') ) {

			// Name
			if ( values.author.length < 2 || values.author == placeholders.author ) {
				$(this).find('#author').parent().addClass('error');
				errors.author = 'Please enter your name.';
			}

			// Email
			if ( values.email.length == 0 || values.email == placeholders.email || !validate(values.email) ) {
				$(this).find('#email').parent().addClass('error');
				errors.email = 'Please enter a valid email.';
			}

		}

		// Comment 
		if ( values.comment.length < 10 || values.comment == placeholders.comment ) {
			$(this).find('#comment').parent().addClass('error');
			errors.comment = 'Please enter your message (at least 10 characters).';
		}


		// If there were errors
		if ( $.isEmptyObject( errors ) == false ) {

			$('.errors').fadeOut(700).remove();

			var output = '<ul class="errors">';

				$.each( errors, function() {

					output += '<li>' + this + '</li>';

				});

			output += '</ul>';

			$(this).append( output );

			$('.errors').fadeIn(700);

			return false;

		}

		return true;

	});

});