
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
	}

 $(document).ready(function() {
	
	// BOOTBOX - CUSTOM HTML FORM
	// =================================================================
	// Require Bootbox
	// http://bootboxjs.com/
	// =================================================================
	//insert ajax glosarium
	$('#glosarium').on('click', function(){
		bootbox.dialog({
			title: "Create Glosarium",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="name">Glosarium</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="judul" name="judul" type="text" placeholder="Enter Glosarium" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Description</label> ' +
					'<div class="col-md-6"><textarea id="keterangan" placeholder="Description Glosarium Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Save",
					className: "btn-info",
					callback: function() {
						var judul = $('#judul').val();
						var keterangan = $("#keterangan").val();
						//get values
						// alert(namagrup);
						// alert(answer);
						if(judul != '' && keterangan != ''){
						$.post( basedomain+"home/ajax_insert", { judul: judul, keterangan: keterangan } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Glosarium : " + judul + ".<br> Successfully Created",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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
	
	//edit ajax glosarium
	$('.glosarium-edit').on('click', function(){
		var idCatatan = $(this).attr("value");
		// alert(idGrup_kursus);
		$.post(basedomain+"home/ajax_edit", {idCatatan:idCatatan}, function(data){
							// alert(data[0].namagrup);
							// console.log (data);
							$("#juduledit").val(data[0].judul);
							$("#keteranganedit").val(data[0].keterangan);
							$("#idCatatanedit").val(idCatatan);
							
					   },"JSON");
		bootbox.dialog({
			title: "Create Course Group",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="name">Glosarium</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="juduledit" name="juduledit" type="text" placeholder="Enter Glosarium" class="form-control input-md" required="required"> ' +
					'<input id="idCatatanedit" name="idCatatanedit" type="hidden" placeholder="Enter Glosarium" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Description</label> ' +
					'<div class="col-md-6"><textarea id="keteranganedit" placeholder="Description Glosarium Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Update",
					className: "btn-info",
					callback: function() {
						var judul = $('#juduledit').val();
						var keterangan = $("#keteranganedit").val();
						var id = $("#idCatatanedit").val();
						//get values
						// alert(namagrup);
						// alert(answer);
						if(judul != '' && keterangan != ''){
						$.post( basedomain+"home/ajax_update", { judul: judul, keterangan: keterangan, id : id } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Glosarium : " + judul + ".<br> Update Successfully",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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
	
	$('.glosarium-btn-status').on('click', function () {
		var btn = $(this).button('loading')
		// business logic...
		var idGrup_kursus = $(this).attr("value");
		// alert(idGrup_kursus);
		var exp = idGrup_kursus.split("_"); 
		var id = exp[0];
		var status = exp[1];
		
		$.post( basedomain+"home/ajax_update_status", { id: id, status: status } );
		
		// alert(exp[0]);
		var doSomething = setTimeout(function(){
			clearTimeout(doSomething);
			btn.button('reset')
		}, 2000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 2000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 2000);
	});
	
	$('.testimoni-btn-status').on('click', function () {
		var btn = $(this).button('loading')
		// business logic...
		var idGrup_kursus = $(this).attr("value");
		// alert(idGrup_kursus);
		var exp = idGrup_kursus.split("_"); 
		var id = exp[0];
		var status = exp[1];
		
		
		$.post( basedomain+"home/ajax_update_status_testimoni", { id: id, status: status } );
		
		// alert(exp[0]);
		var doSomething = setTimeout(function(){
			clearTimeout(doSomething);
			btn.button('reset')
		}, 2000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 2000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 2000);
	});

	$('.glosarium-btn-status-wilayah').on('click', function () {
		var btn = $(this).button('loading')
		// business logic...
		var idGrup_kursus = $(this).attr("value");
		// alert(idGrup_kursus);
		var exp = idGrup_kursus.split("_"); 
		var id = exp[0];
		var status = exp[1];
		
		$.post( basedomain+"home/ajax_update_status", { id: id, status: status, wilayah:1 } );
		
		// alert(exp[0]);
		var doSomething = setTimeout(function(){
			clearTimeout(doSomething);
			btn.button('reset')
		}, 2000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 2000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 2000);
	});

	$('#glosarium-delete-btn').click( function () {
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
					$.post( basedomain+"home/ajax_delete", { id: str} );
					$.niftyNoty({
						type: 'success',
						icon : 'fa fa-check',
						message : 'Remove Data Successfully.',
						container : 'floating',
						timer : 2000
					});
					setTimeout(
				   function() 
				   {
					location.reload();
				   }, 2000);
				}else{
					$.niftyNoty({
						type: 'danger',
						icon : 'fa fa-minus',
						message : 'Remove Data Failed!',
						container : 'floating',
						timer : 2000
					});
				};


			});
			
		}
	});
	
	
	//insert ajax qoutes
	/*$('#link').on('click', function(){
		bootbox.dialog({
			title: "Create link",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="name">Writer</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="judul" name="judul" type="text" placeholder="Enter Writer" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Qoutes</label> ' +
					'<div class="col-md-6"><textarea id="keterangan" placeholder="Qoutes Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Save",
					className: "btn-info",
					callback: function() {
						var judul = $('#judul').val();
						var keterangan = $("#keterangan").val();
						//get values
						// alert(namagrup);
						// alert(answer);
						if(judul != '' && keterangan != ''){
						$.post( basedomain+"home/ajax_insert_quotes", { judul: judul, keterangan: keterangan, type:3 } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Qoutes : " + judul + ".<br> Successfully Created",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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
	});*/


	//insert ajax qoutes
	$('#qoutes').on('click', function(){
		bootbox.dialog({
			title: "Create Qoutes",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="name">Writer</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="judul" name="judul" type="text" placeholder="Enter Writer" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Qoutes</label> ' +
					'<div class="col-md-6"><textarea id="keterangan" placeholder="Qoutes Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Save",
					className: "btn-info",
					callback: function() {
						var judul = $('#judul').val();
						var keterangan = $("#keterangan").val();
						//get values
						// alert(namagrup);
						// alert(answer);
						if(judul != '' && keterangan != ''){
						$.post( basedomain+"home/ajax_insert_quotes", { judul: judul, keterangan: keterangan } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Qoutes : " + judul + ".<br> Successfully Created",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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
	
	
	$('#wilayah').on('click', function(){
		bootbox.dialog({
			title: "Create Qoutes",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="name">Kode Wilayah</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="kode_wilayah" name="kode_wilayah" type="text" placeholder="Enter Writer" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Nama WIlayah</label> ' +
					'<div class="col-md-6"><textarea id="nama_wilayah" placeholder="Qoutes Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Save",
					className: "btn-info",
					callback: function() {
						var judul = $('#kode_wilayah').val();
						var keterangan = $("#nama_wilayah").val();
						//get values
						// alert(namagrup);
						// alert(answer);
						if(judul != '' && keterangan != ''){
						$.post( basedomain+"home/ajax_insert_quotes", { judul: judul, keterangan: keterangan, wilayah:1 } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Qoutes : " + judul + ".<br> Successfully Created",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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
	//edit ajax glosarium
	$('.qoutes-edit').on('click', function(){
		var idCatatan = $(this).attr("value");
		// alert(idGrup_kursus);
		$.post(basedomain+"home/ajax_edit", {idCatatan:idCatatan}, function(data){
							// alert(data[0].namagrup);
							// console.log (data);
							$("#juduledit").val(data[0].judul);
							$("#keteranganedit").val(data[0].keterangan);
							$("#idCatatanedit").val(idCatatan);
							
					   },"JSON");
		bootbox.dialog({
			title: "Create Course Group",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="name">Writer</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="juduledit" name="juduledit" type="text" placeholder="Enter Writer" class="form-control input-md" required="required"> ' +
					'<input id="idCatatanedit" name="idCatatanedit" type="hidden" placeholder="Enter Writer" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Qoute</label> ' +
					'<div class="col-md-6"><textarea id="keteranganedit" placeholder="Qoutes Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Update",
					className: "btn-info",
					callback: function() {
						var judul = $('#juduledit').val();
						var keterangan = $("#keteranganedit").val();
						var id = $("#idCatatanedit").val();
						//get values
						// alert(namagrup);
						// alert(answer);
						if(judul != '' && keterangan != ''){
						$.post( basedomain+"home/ajax_update", { judul: judul, keterangan: keterangan, id : id } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Qoutes : " + judul + ".<br> Update Successfully",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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
	

	$('.wilayah-edit').on('click', function(){
		var idCatatan = $(this).attr("value");
		// alert(idGrup_kursus);
		$.post(basedomain+"home/ajax_edit", {idCatatan:idCatatan, wilayah:1}, function(data){
							// alert(data[0].namagrup);
							// console.log (data);
							$("#kode_wilayah_edit").val(data[0].kode_wilayah);
							$("#nama_wilayah_edit").val(data[0].nama_wilayah);
							
							
					   },"JSON");
		bootbox.dialog({
			title: "Create Course Group",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="name">Kode Wilayah</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="kode_wilayah_edit" name="kode_wilayah_edit" type="text" placeholder="Enter Writer" class="form-control input-md" required="required"> ' +
					'</div> ' +
					'</div> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Nama Wilayah</label> ' +
					'<div class="col-md-6"><input id="nama_wilayah_edit" name="nama_wilayah_edit" type="text" placeholder="Enter Wilayah" class="form-control input-md" required="required"></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Update",
					className: "btn-info",
					callback: function() {
						var judul = $('#kode_wilayah_edit').val();
						var keterangan = $("#nama_wilayah_edit").val();
						var id = $("#kode_wilayah_edit").val();
						//get values
						// alert(namagrup);
						// alert(answer);
						if(judul != '' && keterangan != ''){
						$.post( basedomain+"home/ajax_update", { judul: judul, keterangan: keterangan, id : id, wilayah:1 } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Qoutes : " + judul + ".<br> Update Successfully",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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

	$('.qoutes-btn-status').on('click', function () {
		var btn = $(this).button('loading')
		// business logic...
		var idGrup_kursus = $(this).attr("value");
		// alert(idGrup_kursus);
		var exp = idGrup_kursus.split("_"); 
		var id = exp[0];
		var status = exp[1];
		
		$.post( basedomain+"home/ajax_update_status", { id: id, status: status } );
		
		// alert(exp[0]);
		var doSomething = setTimeout(function(){
			clearTimeout(doSomething);
			btn.button('reset')
		}, 2000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 2000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 2000);
	});
	
	$('#qoutes-delete-btn').click( function () {
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
					$.post( basedomain+"home/ajax_delete", { id: str} );
					$.niftyNoty({
						type: 'success',
						icon : 'fa fa-check',
						message : 'Remove Data Successfully.',
						container : 'floating',
						timer : 2000
					});
					setTimeout(
				   function() 
				   {
					location.reload();
				   }, 2000);
				}else{
					$.niftyNoty({
						type: 'danger',
						icon : 'fa fa-minus',
						message : 'Remove Data Failed!',
						container : 'floating',
						timer : 2000
					});
				};


			});
			
		}
	});
	
	$('#wilayah-delete-btn').click( function () {

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
		// console.log = vals[0];
		 //alert(vals[0]);
		 // alert(str);
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
					$.post( basedomain+"home/ajax_delete", { id: str, kode_wilayah:1} );
					$.niftyNoty({
						type: 'success',
						icon : 'fa fa-check',
						message : 'Remove Data Successfully.',
						container : 'floating',
						timer : 2000
					});
					setTimeout(
				   function() 
				   {
					location.reload();
				   }, 2000);
				}else{
					$.niftyNoty({
						type: 'danger',
						icon : 'fa fa-minus',
						message : 'Remove Data Failed!',
						container : 'floating',
						timer : 2000
					});
				};


			});
			
		}
	});
	
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
							message : "Group " + namagrup + ".<br> Successfully Created",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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
							message : "Group " + namagrup + ".<br> Update Successfully",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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
		}, 2000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 2000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 2000);
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
		}, 2000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 2000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 2000);
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
		}, 2000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 2000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 2000);
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
						timer : 2000
					});
					setTimeout(
				   function() 
				   {
					location.reload();
				   }, 2000);
				}else{
					$.niftyNoty({
						type: 'danger',
						icon : 'fa fa-minus',
						message : 'Remove Data Failed!',
						container : 'floating',
						timer : 2000
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
						timer : 2000
					});
					setTimeout(
				   function() 
				   {
					location.reload();
				   }, 2000);
				}else{
					$.niftyNoty({
						type: 'danger',
						icon : 'fa fa-minus',
						message : 'Remove Data Failed!',
						container : 'floating',
						timer : 2000
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
						timer : 2000
					});
					setTimeout(
				   function() 
				   {
					location.reload();
				   }, 2000);
				}else{
					$.niftyNoty({
						type: 'danger',
						icon : 'fa fa-minus',
						message : 'Remove Data Failed!',
						container : 'floating',
						timer : 2000
					});
				};


			});
			
		}
	});
	
	$('#demo-dt-delete-btn-course-material').click( function () {
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
					$.post( basedomain+"course/ajax_delete_course_material", { id: str} );
					$.niftyNoty({
						type: 'success',
						icon : 'fa fa-check',
						message : 'Remove Data Successfully.',
						container : 'floating',
						timer : 2000
					});
					setTimeout(
				   function() 
				   {
					location.reload();
				   }, 2000);
				}else{
					$.niftyNoty({
						type: 'danger',
						icon : 'fa fa-minus',
						message : 'Remove Data Failed!',
						container : 'floating',
						timer : 2000
					});
				};


			});
			
		}
	});
	
	
	
	$('#addmaterial').on('click', function(){
		
		var idkursus = $(this).attr("value");
		// alert(idGrup_kursus);
		$.post(basedomain+"course/ajax_get_data_material", {idkursus:idkursus}, function(data){
							// alert(data[0].idGrup_kursus);
							// console.log (data);
							$("#idKursus").val(data[0].idKursus);
							$("#jeniskursus").val(data[0].jeniskursus);
							$("#idGrup_kursus").val(data[0].idGrup_kursus);
						},"JSON");
		bootbox.dialog({
			title: "Create Course Material",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="order">Material Name</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="namamateri" name="namamateri" type="text" placeholder="Enter Material Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					
					'<div class="col-md-4"> ' +
					'<input name="idKursus" type="hidden" id="idKursus" placeholder="Enter Material Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					
					'<div class="col-md-4"> ' +
					'<input  name="jenismateri" type="hidden" id="jeniskursus" placeholder="Enter Material Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					
					'<div class="col-md-4"> ' +
					'<input  name="idGrup_kursus" type="hidden" id="idGrup_kursus" placeholder="Enter Material Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					
					
					'</div> ' + 
					'<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="order">Sort Order</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="urutan" name="urutan" type="text" class="form-control input-md" placeholder="number only" onkeypress="return isNumber(event)" required="required"> ' +
					'</div> ' +
					'</div> ' + 
					'<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Description</label> ' +
					'<div class="col-md-6"><textarea id="keterangan" name="keterangan" placeholder="Material Description Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Save",
					className: "btn-info",
					callback: function() {
						var namamateri = $('#namamateri').val();
						var idKursus = $("#idKursus").val();
						var jenismateri = $("#jeniskursus").val();
						var idGrup_kursus = $("#idGrup_kursus").val();
						var urutan = $("#urutan").val();
						var keterangan = $("#keterangan").val();
						//get values
						// alert(namagrup);
						// alert(answer);
						if(namamateri != '' && urutan != ''){
						$.post( basedomain+"course/ajax_insert_material", { namamateri: namamateri, idKursus: idKursus, jenismateri: jenismateri, idGrup_kursus: idGrup_kursus, urutan: urutan, keterangan: keterangan } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Material " + namamateri + ".<br> Successfully Created",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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
	
	$('.demo-state-btn-material').on('click', function () {
		var btn = $(this).button('loading')
		// business logic...
		var idGrup_kursus = $(this).attr("value");
		// alert(idGrup_kursus);
		var exp = idGrup_kursus.split("_"); 
		var id = exp[0];
		var status = exp[1];
		
		$.post( basedomain+"course/ajax_update_status_material", { id: id, status: status } );
		
		// alert(exp[0]);
		var doSomething = setTimeout(function(){
			clearTimeout(doSomething);
			btn.button('reset')
		}, 2000);
		$.niftyNoty({
			type: 'success',
			icon : 'fa fa-check',
			message : 'Update Status Successfully.',
			container : 'floating',
			timer : 2000
		});
		setTimeout(
		  function() 
		  {
			location.reload();
		  }, 2000);
	});
	
	$('.editmaterial').on('click', function(){
		
		var idmateri = $(this).attr("value");
		// alert(idGrup_kursus);
		$.post(basedomain+"course/ajax_get_data_material_edit", {idmateri:idmateri}, function(data){
							// alert(data[0].idGrup_kursus);
							// console.log (data);
							$("#idMateri").val(data[0].idMateri);
							$("#urutan").val(data[0].urutan);
							$("#namamateri").val(data[0].namamateri);
							$("#keterangan").val(data[0].keterangan);
							$("#jenismateri").val(data[0].jenismateri);
							$("#idKursus").val(data[0].idKursus);
							$("#idGrup_kursus").val(data[0].idGrup_kursus);
						},"JSON");
		bootbox.dialog({
			title: "Create Course Material",
			message:'<div class="row"> ' + '<div class="col-md-12"> ' +
					'<form class="form-horizontal"> ' + '<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="order">Material Name</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="namamateri" name="namamateri" type="text" placeholder="Enter Material Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					
					'<div class="col-md-4"> ' +
					'<input name="idKursus" type="hidden" id="idKursus" placeholder="Enter Material Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					
					'<div class="col-md-4"> ' +
					'<input  name="jenismateri" type="hidden" id="jenismateri" placeholder="Enter Material Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					
					'<div class="col-md-4"> ' +
					'<input  name="idGrup_kursus" type="hidden" id="idGrup_kursus" placeholder="Enter Material Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					
					'<div class="col-md-4"> ' +
					'<input  name="idMateri" type="hidden" id="idMateri" placeholder="Enter Material Name" class="form-control input-md" required="required"> ' +
					'</div> ' +
					
					'</div> ' + 
					'<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="order">Sort Order</label> ' +
					'<div class="col-md-4"> ' +
					'<input id="urutan" name="urutan" type="text" class="form-control input-md" placeholder="number only" onkeypress="return isNumber(event)" required="required"> ' +
					'</div> ' +
					'</div> ' + 
					'<div class="form-group"> ' +
					'<label class="col-md-4 control-label" for="syaratkelulusan">Description</label> ' +
					'<div class="col-md-6"><textarea id="keterangan" name="keterangan" placeholder="Material Description Here" rows="5" class="form-control"></textarea></div>' +
					'</div> </div>' + '</form> </div> </div><script></script>',
			buttons: {
				success: {
					label: "Save",
					className: "btn-info",
					callback: function() {
						var namamateri = $('#namamateri').val();
						var idKursus = $("#idKursus").val();
						var jenismateri = $("#jenismateri").val();
						var idGrup_kursus = $("#idGrup_kursus").val();
						var urutan = $("#urutan").val();
						var keterangan = $("#keterangan").val();
						var idMateri = $("#idMateri").val();
						
						//get values
						// alert(namagrup);
						// alert(answer);
						if(namamateri != '' && urutan != ''){
						$.post( basedomain+"course/ajax_update_material", { idMateri : idMateri,namamateri: namamateri, idKursus: idKursus, jenismateri: jenismateri, idGrup_kursus: idGrup_kursus, urutan: urutan, keterangan: keterangan } );
						
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Material " + namamateri + ".<br> Successfully Update",
							container : 'floating',
							timer : 2000
						});
						setTimeout(
						  function() 
						  {
							location.reload();
						  }, 2000);
						
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
	
	
 })
 

