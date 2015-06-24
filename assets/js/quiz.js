
function countDown()
{

	setTimeout(function(){ 
		$.post(basedomain+'quiz/countDown', {param:true}, function(data){

			if (data){

				if (data.status==true){
					var minute = data.end_date.minute;
					var second = data.end_date.second;

					$('#countdown').html( minute + ' menit ' + second + ' detik');
					countDown();
				}else{

					$.post(basedomain+'quiz/updateNilaiOnLogout', {param:true}, function(data){

						if (data.status==true){
							alert('waktu anda sudah selesai');
							window.location.href = basedomain+'kursus';
						}
					}, "JSON")
					
					// location.reload();
					// $('#countdown').html( 'Habis waktu' );
				}
			}
			
			
			

		},"JSON")
	}, 1000);
}



// send data quiz via ajax script


$(document).on('click','.chooseAnswer', function(){

	var soal = $(this).attr('data-soal');
	var pilihan = $(this).attr('data-pilihan');
	var materi = $(this).attr('data-materi');
	var kursus = $(this).attr('data-kursus');
	var idGrup_kursus = $(this).attr('data-idGrup_kursus');
	
	var dataKlik = this;
	// $('soal_'+soal).removeClass("li.span.active");
	
	$.post(basedomain+'quiz/ajax', {soal:soal, pilihan:pilihan, materi:materi, kursus:kursus, idGrup_kursus:idGrup_kursus}, function(data){

		if (data.status==true){
			
			// console.log(dataKlik);
			// $(dataKlik).addClass("active");	
		}
		

	},"JSON")
})

$(document).on('click','#ikutQuiz', function(){

	window.location.href=basedomain+"quiz/startQuiz";
})

$(document).on('click','.applykursus', function(){

	$('#is_applykursus').val($(this).attr('data-kursus'));

})

$(document).on('change','.pilihKursus', function(){

	var idKursus = $(this).val();
	$.post(basedomain+'quiz/getMateri', {idKursus:idKursus}, function(data){

		console.log(data);
		if (data.status==true){
			
			
			// $(dataKlik).addClass("active");	
		}
		

	},"JSON")
})

$(document).on('change','#pilihKursus', function(){

	var grupid = $(this).val();
	var template = "";

	$.post(basedomain+'quiz/getMateri', {idKursus:grupid,param:2}, function(data){

		if (data.status==true){
			
			template += "<option value='0'>Pilih Materi</option>";
			$.each(data.res, function(i,e){

				template += "<option value='"+e.idMateri+"'>"+e.namamateri+"</option>"
			})
			
			$('#pilihMateri').html(template).selectpicker('refresh');
		}
		
	},"JSON")
	
})

$(document).on('click','#finishQuiz', function(){

	var userid = $(this).attr('data-token');
	var quizId = $(this).attr('data-quiz');
	var template = "";

	$.post(basedomain+'quiz/finishQuiz', {userid:userid,quizId:quizId}, function(data){

		if (data.status==true){
			
			window.location.href=basedomain+'quiz/hasil';	
		}
		
	},"JSON")
	
})


function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}  

function compare(data1, data2)
{
	if (data1==data2) return true;
	return false;
}

function validateNumber(evt){
     evt.value = evt.value.replace(/[^0-9]/g,"");
}