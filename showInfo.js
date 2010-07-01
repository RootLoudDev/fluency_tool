// JavaScript Document
function showPanel(panel,event){
	var p = document.getElementById(panel);
		
	//get positioning coordinates
	var w = self.screen.width;
	var h = self.screen.height;
	var s = document.body.scrollTop;
		
	//set left and top properties
	var x = w - (w-30);
	var y = s+130;
		
	p.style.display = "block";
	p.style.left = x.toString() +"px";
	p.style.top = y.toString() + "px";
}
	  
function hidePanel(panel,event){
	p = document.getElementById(panel);
	p.style.display = "none";
		
}
