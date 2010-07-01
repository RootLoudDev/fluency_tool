/**
*
*  This is the main js file for the flueny backend
*
*
*/




var count = 0;

function addresource(count){
	count++;
	var refid = 'ref' + count + '';
	//alert (refid);
	
	$('.resources').append("<tr id=" + refid + "><td>Resource Text</td><td><input type=\"text\" name=\"res_text"+ count +"\" id="+ refid +" /></td><td>Resource Type</td><td><select name=\"res_type"+ count +"\" id=\"res_type\"><option value=\"1\">Public</option><option value=\"2\">Private</option></select></td><td><a href=\"javascript:void(0)\" onclick=\"delref('#"+ refid +"')\">Remove</a></tr>");
	return count;
}

function delref(element){
	var element = element;
	//alert (element);
	$(element).remove();
}

function sendForm(){
	  var formData = $('form').serialize();
	
	$.ajax({
	   type: "GET",
	   url: "add_scenario.php",
	   data: formData,
	   success: function(msg){alert(formData + 'we did it!' + msg);}
	 });
	
}