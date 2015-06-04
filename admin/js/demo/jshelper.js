
 $(document).ready(function() {

	// BOOTBOX - CUSTOM HTML FORM
	// =================================================================
	// Require Bootbox
	// http://bootboxjs.com/
	// =================================================================
	//insert ajax course
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
						if(namagrup != '' && syaratkelulusan != ''){
						$.post( basedomain+"course/ajax_insert", { namagrup: namagrup, syaratkelulusan: syaratkelulusan } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Group " + namagrup + ".<br> Update Successfully",
							container : 'floating',
							timer : 3000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 3000);
						
					}else{
					
						alert( "isi Data" );
					}
					}
				}
			}
		});

		$(".demo-modal-radio").niftyCheck();
	});
	
	//edit ajax course
	$('.demo-bootbox-custom-h-form-edit').on('click', function(){
		var idGrup_kursus = $(this).attr("value");
		// alert(idGrup_kursus);
		$.post(basedomain+"course/ajax_edit", {idGrup_kursus:idGrup_kursus}, function(data){
							// alert(data[0].namagrup);
							// console.log (data);
							$("#namagrupedit").val(data[0].namagrup);
							$("#syaratkelulusanedit").val(data[0].syaratkelulusan);
							$("#idGrup_kursusedit").val(idGrup_kursus);
							
					   },"JSON");
		bootbox.dialog({
			title: "Create Course Group",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="name">Group Name</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="namagrupedit" name="namagrupedit" type="text" placeholder="Enter Group Name" class="form-control input-md" required="required"> ' +
					'<input id="idGrup_kursusedit" name="name" type="hidden" placeholder="Enter Group Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Requirements</label> ' +
					'<div class="col-md-6"><textarea id="syaratkelulusanedit" name="syaratkelulusanedit" placeholder="Course Requirements Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Update",
					className: "btn-info",
					callback: function() {
						var namagrup = $('#namagrupedit').val();
						var syaratkelulusan = $("#syaratkelulusanedit").val();
						var id = $("#idGrup_kursusedit").val();
						//get values
						// alert(namagrup);
						// alert(answer);
						if(namagrup != '' && syaratkelulusan != ''){
						$.post( basedomain+"course/ajax_update", { namagrup: namagrup, syaratkelulusan: syaratkelulusan, id : id } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Group " + namagrup + ".<br> Successfully Created",
							container : 'floating',
							timer : 3000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 3000);
						
					}else{
					
						//alert( "isi Data" );
						bootbox.alert("Data Cannot Empty!", function(){
							//EMPTY
						});
					}
					}
				}
			}
		});

		$(".demo-modal-radio").niftyCheck();
	});
	
	$('.demo-state-btn').on('click', function () {
		var btn = $(this).button('loading')
		// business logic...
		var idGrup_kursus = $(this).attr("value");
		// alert(idGrup_kursus);
		var exp = idGrup_kursus.split("_"); 
		var id = exp[0];
		var status = exp[1];
		
		$.post( basedomain+"course/ajax_update_status", { id: id, status: status } );
		
		// alert(exp[0]);
		var doSomething = setTimeout(function(){
			clearTimeout(doSomething);
			btn.button('reset')
		}, 3000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 3000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 3000);
	});

	$('.update-list-course-btn').on('click', function () {
		var btn = $(this).button('loading')
		// alert(btn);
		// business logic...
		var idGrup_kursus = $(this).attr("value");
		// alert(idGrup_kursus);
		var exp = idGrup_kursus.split("_"); 
		var id = exp[0];
		var status = exp[1];
		
		$.post( basedomain+"course/ajax_update_status_course", { id: id, status: status } );
		
		// alert(exp[0]);
		var doSomething = setTimeout(function(){
			clearTimeout(doSomething);
			btn.button('reset')
		}, 3000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 3000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 3000);
		  // $('#newslist').DataTable().ajax.reload();
		  // $('#newslist').dataTable()._fnAjaxUpdate();
	});
	
	$('.update-list-upload-btn').on('click', function () {
		var btn = $(this).button('loading')
		// alert(btn);
		// business logic...
		var idGrup_kursus = $(this).attr("value");
		// alert(idGrup_kursus);
		var exp = idGrup_kursus.split("_"); 
		var id = exp[0];
		var status = exp[1];
		
		$.post( basedomain+"course/ajax_update_status_upload", { id: id, status: status } );
		
		// alert(exp[0]);
		var doSomething = setTimeout(function(){
			clearTimeout(doSomething);
			btn.button('reset')
		}, 3000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 3000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 3000);
		  // $('#newslist').DataTable().ajax.reload();
		  // $('#newslist').dataTable()._fnAjaxUpdate();
	});
	
	$('#demo-dt-delete-btn-course-group').click( function () {
		//rowDeletion.row('.selected').remove().draw( false );
		//var id = rowDeletion.cell('.selected', 2).data();
		//alert(id);
		 //console.log = id; 
	
		//solusi alternatif
		var vals = [];  // variable vals initialization as array
		//get all the checkboxes that are checked in one variable
		$('input:checkbox[name="check[]"]').each(function() {
			if (this.checked) {
				// push the element into array
				vals.push(this.value);
			}
		});
		var str = vals.join(",");
		//console.log = vals[0];
		 //alert(vals[0]);
		 //alert(str);
		if (!str) {
			//alert('Checked First!');
			bootbox.alert("Checked First!", function(){
				//EMPTY
			});
			return str;
		}else{
			
			//some modification
			bootbox.confirm("Are you sure want to remove data?", function(result) {
				if (result) {
					$.post( basedomain+"course/ajax_delete", { id: str} );
					$.niftyNoty({
						type: 'success',
						icon : 'fa fa-check',
						message : 'Remove Data Successfully.',
						container : 'floating',
						timer : 3000
					});
					setTimeout(
				   function() 
				   {
					location.reload();
				   }, 3000);
				}else{
					$.niftyNoty({
						type: 'danger',
						icon : 'fa fa-minus',
						message : 'Remove Data Failed!',
						container : 'floating',
						timer : 3000
					});
				};


			});
			
		}
	});
	
	$('#demo-dt-delete-btn-course-list').click( function () {
		//rowDeletion.row('.selected').remove().draw( false );
		//var id = rowDeletion.cell('.selected', 2).data();
		//alert(id);
		 //console.log = id; 
	
		//solusi alternatif
		var vals = [];  // variable vals initialization as array
		//get all the checkboxes that are checked in one variable
		$('input:checkbox[name="check[]"]').each(function() {
			if (this.checked) {
				// push the element into array
				vals.push(this.value);
			}
		});
		var str = vals.join(",");
		//console.log = vals[0];
		 //alert(vals[0]);
		 //alert(str);
		if (!str) {
			//alert('Checked First!');
			bootbox.alert("Checked First!", function(){
				//EMPTY
			});
			return str;
		}else{
			
			//some modification
			bootbox.confirm("Are you sure want to remove data?", function(result) {
				if (result) {
					$.post( basedomain+"course/ajax_delete_course_list", { id: str} );
					$.niftyNoty({
						type: 'success',
						icon : 'fa fa-check',
						message : 'Remove Data Successfully.',
						container : 'floating',
						timer : 3000
					});
					setTimeout(
				   function() 
				   {
					location.reload();
				   }, 3000);
				}else{
					$.niftyNoty({
						type: 'danger',
						icon : 'fa fa-minus',
						message : 'Remove Data Failed!',
						container : 'floating',
						timer : 3000
					});
				};


			});
			
		}
	});
	
	$('#demo-dt-delete-btn-course-upload').click( function () {
		//rowDeletion.row('.selected').remove().draw( false );
		//var id = rowDeletion.cell('.selected', 2).data();
		//alert(id);
		 //console.log = id; 
	
		//solusi alternatif
		var vals = [];  // variable vals initialization as array
		//get all the checkboxes that are checked in one variable
		$('input:checkbox[name="check[]"]').each(function() {
			if (this.checked) {
				// push the element into array
				vals.push(this.value);
			}
		});
		var str = vals.join(",");
		//console.log = vals[0];
		 //alert(vals[0]);
		 //alert(str);
		if (!str) {
			//alert('Checked First!');
			bootbox.alert("Checked First!", function(){
				//EMPTY
			});
			return str;
		}else{
			
			//some modification
			bootbox.confirm("Are you sure want to remove data?", function(result) {
				if (result) {
					$.post( basedomain+"course/ajax_delete_course_upload", { id: str} );
					$.niftyNoty({
						type: 'success',
						icon : 'fa fa-check',
						message : 'Remove Data Successfully.',
						container : 'floating',
						timer : 3000
					});
					setTimeout(
				   function() 
				   {
					location.reload();
				   }, 3000);
				}else{
					$.niftyNoty({
						type: 'danger',
						icon : 'fa fa-minus',
						message : 'Remove Data Failed!',
						container : 'floating',
						timer : 3000
					});
				};


			});
			
		}
	});
	
	
	$('#addmaterial').on('click', function(){
		bootbox.dialog({
			title: "Create Course Material",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="order">Material Name</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="namagrup" name="name" type="text" placeholder="Enter Material Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + 
					'<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="order">Sort Order</label> ' +
					'<div class="col-md-2"> ' +
					'<input id="namagrup" name="name" type="text" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + 
					'<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Description</label> ' +
					'<div class="col-md-6"><textarea id="syaratkelulusan" placeholder="Material Description Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Save",
					className: "btn-info",
					callback: function() {
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Group " + namagrup + ".<br> Successfully created",
							container : 'floating',
							timer : 4000
						});
					}
				}
			}
		});

		$(".demo-modal-radio").niftyCheck();
	});
	
	
 })
 

