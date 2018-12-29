function ajax(sendUrl, formData, returnFunction = function(){})
{
	var xmlhttp;
	if (window.XMLHttpRequest) // code for IE7+, Firefox, Chrome, Opera, Safari
	{
		xmlhttp = new XMLHttpRequest();
	}
	else // code for IE6, IE5
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function()
	{
		if(xmlhttp.readyState === 4 && xmlhttp.status === 200)
		{
			returnFunction(xmlhttp.responseXML);
		}
		else if(xmlhttp.readyState === 4) // any error message by the server, try again in a sec.
		{
			setTimeout(function(){
				ajax(sendUrl, formData, returnFunction);
			}, 1000);
		}
	}

	xmlhttp.open("post", sendUrl, true);
	xmlhttp.send(formData);
}