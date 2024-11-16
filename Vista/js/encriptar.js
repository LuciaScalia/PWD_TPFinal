function formSubmit(form)
{
    var password =  document.getElementById("uspass").value;
   
    var passhash = CryptoJS.MD5(password).toString();

    document.getElementById("uspass").value = passhash;

    setTimeout(function(){ 
        document.getElementById(form).submit();
        
	}, 500);
}