import $ from 'jquery';

class Vendor {

  constructor() {
  	this.listen();
  }


  listen() {
  	$('.edit-vendor').on('click', this.editVendor.bind(this));
  	$('.delete-vendor').on('click', this.deleteVendor.bind(this));
  	$('.toggle-edit-vendor').on('click', this.cancelForm.bind(this));
  	$('.toggle-new-vendor').on('click', this.toggleNewForm.bind(this));
  }

  toggleNewForm() {
    var form = $('#post-new-form');
    if (form.is(':visible')) {
  		$('#post-new-form').hide();
    } else {
    	$('#post-new-form').show();
    }
  }

  editVendor(e) {
  	var element = $(e.target),
  	    id = element.data('id'),
  	    headerElement = element.parent().siblings('header'),
	  	h1Element = headerElement.find('a'),
	  	pageContentElement = element.parent().siblings('.page-content');

  	// change title to input
  	h1Element.hide();

  	// change content to textarea
	pageContentElement.addClass('display-none')

    element.parent().addClass('display-none');
 	element.parent().siblings('.acf_form_content').removeClass('display-none');
  }

  cancelForm(e) {
  	var element = $(e.target),
  	    headerElement = element.parent().siblings('header'),
	  	h1Element = headerElement.find('a');

    element.parent().addClass('display-none');
 	element.parent().siblings('.page-content').removeClass('display-none');
 	element.parent().siblings('.org').removeClass('display-none');

	// show h1 header
	headerElement.find('a').show();

  }

  deleteVendor(e) {
  	var confirmed = confirm('Are you sure?'),
  	id = $(e.target).data('id'),
    url = seventeenData.root_url + '/wp-json/wp/v2/vendors/' + id;
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

  updateVendor(e) {
  	var element = $(e.target),
  	    id = element.data('id'),
  	    headerElement = element.parent().siblings('header'),
	  	inputElement = headerElement.find('input'),
	  	title = inputElement.val(),
	  	content = element.parent().siblings('.page-content').find('textarea').val(),
    	url = seventeenData.root_url + '/wp-json/wp/v2/vendors/' + id;
  	
  	if (typeof title !== 'string' || typeof content !== 'string' || title.length === 0 || content.length === 0) {
		alert('Please enter values for Title and Description');
		return;
  	}
  	var data = {title, content};
	$.ajax({
		beforeSend: function(xhr) {
			xhr.setRequestHeader('X-WP-Nonce', seventeenData.nonce);
		},
		url, 
		data,
		type:'POST',
		success: function(response){
			if (typeof response.id !== 'undefined') {
				alert('Successfully Updated');
				window.location.reload(true);
			}
		},
		error:function(err){
			alert('Something went wrong.');
		}
	});
  }

  createVendor(e) {
  	var element = $(e.target),
  	    headerElement = element.parent().siblings('header'),
	  	inputElement = headerElement.find('input'),
	  	title = inputElement.val(),
	  	content = element.parent().siblings('.page-content').find('textarea').val(),
    	url = seventeenData.root_url + '/wp-json/wp/v2/vendors/';
  	
  	if (typeof title !== 'string' || typeof content !== 'string' || title.length === 0 || content.length === 0) {
		alert('Please enter values for Title and Description');
		return;
  	}
  	var data = {title, content};

	$.ajax({
		beforeSend: function(xhr) {
			xhr.setRequestHeader('X-WP-Nonce', seventeenData.nonce);
		},
		url, 
		data,
		type:'POST',
		success: function(response){
			if (typeof response.id !== 'undefined') {
				alert('Successfully Created. Please allow some time for this vendor to be reviewed.');
				window.location.reload(true);
			}
		},
		error:function(err){
			alert('Something went wrong.');
		}
	});
  }


}
export default Vendor;
