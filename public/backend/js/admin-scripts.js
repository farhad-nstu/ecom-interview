/**
 * App Main Scripts
 * ------------------
 * Use only for function calls and Plugin calls.
 */


if ($('#windowmodal').length ) {
	$('.modal').on('shown.bs.modal', function (e) {
		var target = $(e.relatedTarget);
		$.ajax({
			url: target[0].href,
			success: function(response)
			{

				$('#windowmodal .modal-content').html(response);
				$('#windowmodal .modal-title').html('<input type="hidden" id="modal_hidden" value="1">');
			}
		});
		// $(this).find('.modal-content').load(target[0].href);
	});


	$(".modal").on("hide.bs.modal", function (e) {
		if ($('.dismiss').data('reload')) {
			location.reload();
		} else {
			$(".modal-body").html("");
		}

	});
}


$(document).ready(function(){


	//remove empty url params when form submitted by get method
	$('form.filter').submit(function() {
		$(this).find(":input").filter(function(){return !this.value;}).attr("disabled", "disabled");
	});


	// table sorting event.
	if ($('.sort').length ) {

		$('.sort').on('click', function() {
			var order = 1;
			//defin asc or desc
			if(urlParam('order') == 1 ) order = 2;
			else if(urlParam('order') == 2) order = 1;

			window.location.href = pageUrl+"?by="+$(this).data('row')+"&order="+order;
		});
		var modal_status =true;
		if ($('#modal_hidden').length ) {
			if ($('##modal_hidden').val() ==1){
				var modal_status =false;
			}
		}
		if (modal_status == true){
			if(urlParam('order') == 1){
				$("#"+urlParam('by') ).append('&nbsp;<i class="fa fa-arrow-up"><i>');
			}else if(urlParam('order') == 2){
				$("#"+urlParam('by') ).append('&nbsp;<i class="fa fa-arrow-down"><i>');
			}else{
				$("#name" ).append('&nbsp;<i class="fa fa-arrow-up"><i>');
			}
		}
	}
});

  if ($('.editor-min').length ) {
	  tinymce.init({
	    selector: '.editor-min',
	    height: 200,
		menubar:false,
	    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | ' +
	      'bullist numlist',

	  });
  }

 if ($('.editor').length ) {

  tinymce.init({
    selector: '.editor',
    height: 400,
	allow_script_urls: true,
	relative_urls : false,
	remove_script_host: false,
	document_base_url: APP_URL+'images/',
    plugins: [
      'advlist autolink link image imagetools lists charmap print preview hr anchor pagebreak spellchecker',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'table emoticons templates paste help'
    ],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullpage | ' +
      'forecolor backcolor emoticons | help',
    menu: {
      favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | spellchecker | emoticons'}
    },
    menubar: 'favs file edit view insert format tools table help',
    //content_css: base_url+'css/design.css',
 	image_advtab: true,
	image_uploadtab: true,
 	paste_data_images: true,
	automatic_uploads: true,

	file_picker_callback: function(callback, value, meta) {
		// Provide file and text for the link dialog
		if (meta.filetype == 'file') {
			tinymce.activeEditor.windowManager.openUrl({
			   title: 'Link Picker',
			   url: APP_URL+'author/mediamanager/tinymce',
			   onMessage: function (api, data) {
                if (data.mceAction === 'customAction') {
                    callback(data.url);
                    api.close();
                 }
				}
			});
		}

		// Provide image and alt text for the image dialog
		if (meta.filetype == 'image') {
			tinymce.activeEditor.windowManager.openUrl({
			   title: 'Image Picker',
			   url: APP_URL+'author/mediamanager/tinymce',
			   onMessage: function (api, data) {
                	if (data.mceAction === 'customAction') {
                    	callback(data.url);
                    	api.close();
                	}
				}
			});
		}

		// Provide alternative source and posted for the media dialog
		if (meta.filetype == 'media') {
			tinymce.activeEditor.windowManager.openUrl({
			   title: 'Media Picker',
			   url: APP_URL+'author/mediamanager/tinymce',
			   onMessage: function (api, data) {
                	if (data.mceAction === 'customAction') {
                    	callback(data.url);
                    	api.close();
                	}
				}
			});
		}
	  },


  });

 }




$.ajaxPrefilter(function( options, original_Options, jqXHR ) {
    options.async = true;
});


if ( $('.datepicker, .dateOfBirth, .toDayDatePicker, .checkoutDatePicker').length) {

}
// Date Picker
if ( $('.datepicker').length){
	$(function () {
		$(".datepicker").datepicker({
			showAnim: "slide",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			yearRange: "-80:+80"
		});
	});
}
if ( $('.dateOfBirth').length){
	$(function () {
		$(".dateOfBirth").datepicker({
			showAnim: "slide",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			yearRange: "-80:+0",
			maxDate: '0'
		});
	});
}

if ( $('.toDayDatePicker').length){
	$(function () {
		var date = new Date();
		var hours = date.getHours();
		var day = '0';
		if (hours >=0 && hours <8){
			day = '-1'
		}
		$(".toDayDatePicker").datepicker({
			showAnim: "slide",
			dateFormat: 'yy-mm-dd',
			minDate: day
		});
	});
}


if ( $('.checkoutDatePicker').length){
	$(function () {	var date = new Date();
		var hours = date.getHours();
		var day = '1';
		if (hours >=0 && hours <8){
			day = '0'
		}
		$(".checkoutDatePicker").datepicker({
			showAnim: "slide",
			dateFormat: 'yy-mm-dd',
			minDate: day
		});
	});
}


if ($('#display-btn').length) {
	$('#display-btn').click(function () {
		$('.btn-d-none').fadeToggle();
	});
}

if ( $('.timePicker').length) {
	(function($) {
			"use strict";
			$(function(){
				$('.timePicker').timepicker({
					'scrollDefault': 'now',
					'timeFormat': 'h:i A',
					'step':15
				});
			});
		}
	)(jQuery);
}

function printData(print_aria_id_name)
{
	var divContents = $("#"+print_aria_id_name).html();
	var header = $("#header_aria").html();
	var printWindow = window.open('', '', 'left=0,top=0,right=0,bottom=0,width=screen.width,height=screen.height,margin=0,0,0,0');
	var WindowDoc = printWindow.document;
	WindowDoc.write('<html>');
	WindowDoc.write(header);
	WindowDoc.write('<body >');
	WindowDoc.write('<style media="print"> body {font-size: 14pt;font-family:Tahoma,sans-serif;} </style>');
	WindowDoc.write(divContents);
	WindowDoc.write('</body></html>');
	WindowDoc.close();
	printWindow.focus();
	printWindow.print();
	WindowDoc.close();
}


if ( $('.onlyNumber').length) {
	$('.onlyNumber').on('keyup', function (e) {
		if (/\D/g.test(this.value)) {
			this.value = this.value.replace(/\D/g, '');
		}
	});
}