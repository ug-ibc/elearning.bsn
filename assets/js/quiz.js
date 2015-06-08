
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
	var dataKlik = this;
	// $('soal_'+soal).removeClass("li.span.active");
	
	$.post(basedomain+'quiz/ajax', {soal:soal, pilihan:pilihan, materi:materi, kursus:kursus}, function(data){

		if (data.status==true){
			
			console.log(dataKlik);
			// $(dataKlik).addClass("active");	
		}
		

	},"JSON")
})

$(document).on('click','#ikutQuiz', function(){

	$.post(basedomain+'quiz/ajax', {param:1}, function(data){

		if (data.status==true){
			
			console.log(dataKlik);
			// $(dataKlik).addClass("active");	
		}
		

	},"JSON")
})

