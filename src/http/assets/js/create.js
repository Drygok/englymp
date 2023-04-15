$(document).ready(function(){ 
	function create_menu (counter){
		for(var i = 1; i <= counter; i++){
			var list = document.getElementById("create");
			var listElement = document.createElement("li");
			var text = document.createTextNode(i);
			var link = document.createElement("a");
			var a.href = ""
			listElement.appendChild(text);
			listElement.className = "nav-item";
			listElement.appendChild();
			list.appendChild(listElement);
			}
	}
	
	
	var counter = 10;
	create_menu(counter);

});