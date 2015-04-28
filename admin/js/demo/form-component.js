
// Form-Component.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
// - ThemeOn.net -


$(document).ready(function() {

	// CHOSEN
	// =================================================================
	// Require Chosen
	// http://harvesthq.github.io/chosen/
	// =================================================================
	$('#size-multi').chosen({width:'100%'});
	$('#color-multi').chosen({width:'100%'});

	// SUMMERNOTE
	// =================================================================
	// Require Summernote
	// http://hackerwins.github.io/summernote/
	// =================================================================
	$('#deskripsi').summernote({height: 150});
	$('#add-info').summernote({height: 150});
	$('#review').summernote({height: 150});

	// $('#deskripsi').code("tesss");

	// BOOTSTRAP DATEPICKER WITH AUTO CLOSE
	// =================================================================
	// Require Bootstrap Datepicker
	// http://eternicode.github.io/bootstrap-datepicker/
	// =================================================================
	$('.input-group.date').datepicker({
		format: "yyyy-mm-dd",
		autoclose:true
	});




});
