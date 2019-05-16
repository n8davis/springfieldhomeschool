import $ from 'jquery';

class Event {

  constructor() {
  	this.listen();
  }


  listen() {
  	$('.edit-event').on('click', this.editEvent.bind(this));
  	$('.update-event').on('click', this.updateEvent.bind(this));
  	$('.delete-event').on('click', this.deleteEvent.bind(this));
  	$('.cancel-event').on('click', this.cancelForm.bind(this));
  	$('.toggle-new-form').on('click', this.toggleNewForm.bind(this));
  }

  toggleNewForm() {
    var form = $('#post-new-form');
    if (form.is(':visible')) {
  		$('#post-new-form').hide();
    } else {
    	$('#post-new-form').show();
    }
  }

  editEvent(e) {
  	var element = $(e.target),
  	    id = element.data('id'),
  	    headerElement = element.parent().siblings('header'),
	  	h1Element = headerElement.find('a'),
	  	pageContentElement = element.parent().siblings('.page-content');

  	// change title to input
  	h1Element.hide();
  	if (headerElement.find('input').length === 0) {
  		headerElement.append('<input type="text" value="'+h1Element.children('h1').text()+'" />')
  	}

  	// change content to textarea
	pageContentElement.children().hide();
	pageContentElement.append('<textarea class="edit-textarea">'+pageContentElement.children().html()+'</textarea>');

    element.parent().addClass('display-none');
 	element.parent().siblings('.secondary').removeClass('display-none');
  }

  cancelForm(e) {
  	var element = $(e.target),
  	    id = element.data('id'),
  	    deleteButton = element.siblings('.delete-event'),
  		updateButton = element.siblings('.update-event'),
  	    headerElement = element.parent().siblings('header'),
	  	inputElement = headerElement.find('input'),
	  	pageContentElement = element.parent().siblings('.page-content');

    element.parent().addClass('display-none');
 	element.parent().siblings('.org').removeClass('display-none');

	// remove input 
	inputElement.remove();

	// show h1 header
	headerElement.find('a').show();

	// change page content
	pageContentElement.find('.edit-textarea').remove();
	pageContentElement.children().show();


  }

  deleteEvent(e) {
  	var confirmed = confirm('Are you sure?'),
  	id = $(e.target).data('id'),
    url = seventeenData.root_url + '/wp-json/wp/v2/events/' + id;
  	if (confirmed) {
  		$.ajax({
  			beforeSend: function(xhr) {
  				xhr.setRequestHeader('X-WP-Nonce', seventeenData.nonce);
  			},
  			url, 
  			type:'DELETE',
  			success: function(response){
  				if (typeof response.id !== 'undefined') {
  					alert('Successfully Deleted');
  					window.location.reload(true);
  				}
  			},
  			error:function(err){
  				alert('Something went wrong.');
  			}
  		});
  	}
  }

  updateEvent(e) {
  	var element = $(e.target),
  	    id = element.data('id'),
  	    headerElement = element.parent().siblings('header'),
	  	inputElement = headerElement.find('input'),
	  	title = inputElement.val(),
	  	description = element.parent().siblings('.page-content').find('textarea').val();
  	
  	if (typeof title !== 'string' || typeof description !== 'string' || title.length === 0 || description.length === 0) {
		alert('Please enter values for Title and Description');
		return;
  	}
  	var data = {title, description};
  	alert(JSON.stringify(data));
  }


}
export default Event;