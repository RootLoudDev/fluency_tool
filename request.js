function createRequest() 
{
	var ajaxRequest = null; 
//Browser Support Code	
	try {
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try {
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				ajaxRequest = null;
			}
		}
	}

	if (ajaxRequest == null) {
		alert("You must update your browser to use this application");
		return false;
	} else {
		return ajaxRequest;
	}
}