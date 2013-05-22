
jQuery(document).ready(function($) {

	var button = $('#load-more');

	var paged  = button.attr('data-paged');
	var cat    = button.attr('data-cat');
	var author = button.attr('data-author');
	var search = button.attr('data-search');

	button.bind('click', function() {

		$(this).attr('data-paged', ++paged);

		$.ajax({
			type: 'POST',
			url: chp.ajaxurl,
			data: {
				paged:  $(this).attr('data-paged'),
				cat:    cat,
				author: author,
				search: search,
				action: 'chp-ajax-pagination'
			},
			success: function(data) {
				if ( data == 'no-posts-found' ) {

					button.html('There are no more posts to show');

					setTimeout(function() {
						$('.pagination').fadeOut(550);
					}, 2000);

				} else {

					$('.articles-list').append( data );

				}
			},
			error: function(error) {
				console.log(error);
			}
		});

		return false;

	});

});