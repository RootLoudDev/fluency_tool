// JavaScript Document

function showFeedback(text,event){
	var t = document.getElementById(text);
	t.style.display = "block";
	switch (text)
	{
	case 'one_response' :
	hideFeedback('two_response');
	hideFeedback('three_response');
	hideFeedback('four_response');
	hideFeedback('five_response');
	hideFeedback('six_response');
	hideFeedback('seven_response');
	break;
	case 'two_response' :
	hideFeedback('one_response');
	hideFeedback('three_response');
	hideFeedback('four_response');
	hideFeedback('five_response');
	hideFeedback('six_response');
	hideFeedback('seven_response');
	break;
	case 'three_response' :
	hideFeedback('one_response');
	hideFeedback('two_response');
	hideFeedback('four_response');
	hideFeedback('five_response');
	hideFeedback('six_response');
	hideFeedback('seven_response');
	break;
	case 'four_response' :
	hideFeedback('one_response');
	hideFeedback('two_response');
	hideFeedback('three_response');
	hideFeedback('five_response');
	hideFeedback('six_response');
	hideFeedback('seven_response');
	break;
	case 'five_response' :
	hideFeedback('one_response');
	hideFeedback('two_response');
	hideFeedback('three_response');
	hideFeedback('four_response');
	hideFeedback('six_response');
	hideFeedback('seven_response');
	break;
	case 'six_response' :
	hideFeedback('one_response');
	hideFeedback('two_response');
	hideFeedback('three_response');
	hideFeedback('four_response');
	hideFeedback('five_response');
	hideFeedback('seven_response');
	break;
	case 'seven_response' :
	hideFeedback('one_response');
	hideFeedback('two_response');
	hideFeedback('three_response');
	hideFeedback('four_response');
	hideFeedback('five_response');
	hideFeedback('six_response');
	break;
	}
}
	  
function hideFeedback(text,event){
	var t = document.getElementById(text);
	t.style.display = "none";
}

function changeme(id, action) {
       if (action=="hide") {
            document.getElementById(id).style.display = "none";
       } else {
            document.getElementById(id).style.display = "block";
       }
}