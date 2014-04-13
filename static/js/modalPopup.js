/**
 * Open a new popup window. Need to include "packages/base/view/modalPopup.tpl"
 * 
 * @author: Salvi
 * @param: String sectionparent, parent of the images element, to move next/back
 * @param: String accesskey, current element number, to move next/back
 * @param: String title, title to display in the header  
 * @param: String image, path to a valid image file
 * */
function popUpOpen(sectionparent, accesskey, title, image){
	// rules for the title
	if(!title) title = "Paper Bag";
	if(title) title = title.substring(0,80); // cutting the title so it fit in the header

	// popuplating the popup with new data 
	$('#image-configs').attr('section-parent', sectionparent);
	$('#image-configs').attr('access-key', accesskey);
    $('#thumbnailViewer-title').html(title);
    $('#thumbnailViewer-image').attr('src',image).attr('alt',title);

    // showing the modal window
    $('#thumbnailViewer').modal('show');
}


/**
 * Move to the next image in the row. Needs include "packages/base/view/modalPopup.tpl"
 * 
 * @author: Salvi
 * */
function popUpNext(){
	var sectionparent = $('#image-configs').attr('section-parent');
	var nextaccesskey = $('#image-configs').attr('access-key')*1 + 1;
	var thumbnail = $('#'+sectionparent).find('.accesskey-'+nextaccesskey);
	if(thumbnail.length<1) return; // protect agains errors in the last image

	var image = thumbnail.find('.image').attr('src');
	var title = thumbnail.find('.title').html();
	if(title) title = title.substring(0,80); // cutting the title so it fit in the header

	$('#thumbnailViewer-image').attr('src', image);
	$('#thumbnailViewer-title').html(title);
	$('#image-configs').attr('access-key', nextaccesskey);
}


/**
 * Move to the previous image in the row. Needs include "packages/base/view/modalPopup.tpl"
 * 
 * @author: Salvi
 * */
function popUpPrevious(){
	var sectionparent = $('#image-configs').attr('section-parent');
	var previousaccesskey = $('#image-configs').attr('access-key')*1 - 1;
	if(previousaccesskey < 0) return; // protect agains errors in the first image
	var thumbnail = $('#'+sectionparent).find('.accesskey-'+previousaccesskey);

	var image = thumbnail.find('.image').attr('src');
	var title = thumbnail.find('.title').html();
	if(title) title = title.substring(0,80); // cutting the title so it fit in the header

	$('#thumbnailViewer-image').attr('src', image);
	$('#thumbnailViewer-title').html(title);
	$('#image-configs').attr('access-key', previousaccesskey);
}