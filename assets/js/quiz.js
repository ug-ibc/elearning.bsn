
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
					alert('waktu anda sudah selesai');
					location.reload();
					$('#countdown').html( 'Habis waktu' );
				}
			}
			
			
			

		},"JSON")
	}, 1000);
}

$(document).ready(function(){

	setTimeout(function(){ 
		countDown();
	}, 1000);

	
})

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
			
			console.log(dataKlik);
			// $(dataKlik).addClass("active");	
		}
		

	},"JSON")
})

$(document).on('click','#ikutQuiz', function(){

	window.location.href=basedomain+"quiz/startQuiz";
})

$(document).on('click','.applykursus', function(){

	$('#is_applykursus').val('1');
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