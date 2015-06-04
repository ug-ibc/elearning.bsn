
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