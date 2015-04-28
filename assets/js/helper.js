
/* global helper JS */


function log(data)
{
	console.log(data);
}

function wow(data)
{
	alert(data);
}

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