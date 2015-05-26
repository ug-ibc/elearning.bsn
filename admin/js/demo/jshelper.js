
 $(document).ready(function() {

	// BOOTBOX - CUSTOM HTML FORM
	// =================================================================
	// Require Bootbox
	// http://bootboxjs.com/
	// =================================================================
	$('#demo-bootbox-custom-h-form').on('click', function(){
		bootbox.dialog({
			title: "Create Course Group",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="name">Group Name</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="namagrup" name="name" type="text" placeholder="Enter Group Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Requirements</label> ' +
					'<div class="col-md-6"><textarea id="syaratkelulusan" placeholder="Course Requirements Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Save",
					className: "btn-info",
					callback: function() {
						var namagrup = $('#namagrup').val();
						var syaratkelulusan = $("#syaratkelulusan").val();
						//get values
						// alert(namagrup);
						// alert(answer);
						if(namagrup != '' || syaratkelulusan != ''){
						$.post( basedomain+"course/ajax_insert", { namagrup: namagrup, syaratkelulusan: syaratkelulusan } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Group " + namagrup + ".<br> Successfully created",
							container : 'floating',
							timer : 4000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 5000);
						
					}else{
					
						alert( "isi Data" );
					}
					}
				}
			}
		});

		$(".demo-modal-radio").niftyCheck();
	});


 })
