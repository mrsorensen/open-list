/*
 * This function is triggered when the checkbox
 * by a list item is checked. It will then
 * ask a php script to remove said item
 * based on id, which is unique in the db
 */

function checklistener(id){
	var l = document.getElementById("checkbox-id-"+id);
	if(l.checked){
		
		var row = document.getElementById("row-id-"+id);


		var opacity = 100;
		var pos = 0;
		var f = setInterval(frame, 5);
		function frame(){

			if(opacity === 0) {
				clearInterval(f);
				row.remove();
			}
			else {
				opacity--;
				pos++;
				row.style.marginLeft= (pos * 1)+"%";
				row.style.opacity = (opacity / 100);
				document.getElementById("newInput").focus();
				document.getElementById("newInput").value = "";

			}

		}

		var http = new XMLHttpRequest();
		var url = 'remove.php';
		var params = id;
		http.open('POST', url, true);

		//Send the proper header information along with the request
		http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200) {
				var response = http.responseText;
				if(response == 1){

					var fadeIn = 0;
					var f = setInterval(frame, 5);
					function frame(){

						if(opacity === 1){
							clearInterval(f);
						}
						else{
							fadeIn++;
							document.getElementById("noitems").style.opacity = (fadeIn / 100);
						}
					}



				}
			}
		}
		http.send(params);



	}
}


/*
 * This listen for an enter keypress
 * in the text input field. When that
 * happens it will be inserted to database
 * and adde to the list by javascript.
 */
var fadeOut = 100;
var input = document.getElementById("newInput");
input.addEventListener("keyup", function(e){
	var val = input.value;
	if(e.keyCode == 13 && val !== ""){

		var http = new XMLHttpRequest();
		var url = 'insert.php';
		var params = val;
		http.open('POST', url, true);

		//Send the proper header information along with the request
		http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200) {
				//alert(http.responseText);
				var newId = http.responseText;
				var row = document.createElement("p");
				row.setAttribute("id", "row-id-"+newId);
				row.style.opacity = 0;
				row.style.width = "95%";
				row.innerHTML = " " + val;
				var listings = document.getElementById("listings");
				listings.insertBefore(row, listings.childNodes[0]);
				var row = document.getElementById("row-id-"+newId);

				var checkbox = document.createElement("input");
				checkbox.setAttribute("type", "checkbox");
				checkbox.setAttribute("id", "checkbox-id-"+newId);
				checkbox.style.left = "-40%";
				checkbox.style.opacity= 0;
				checkbox.setAttribute("onclick", "checklistener("+newId+");");
				row.insertBefore(checkbox, row.childNodes[0]);
				var fadeIn= 0;
				var margin = 40;
				var f = setInterval(frame, 5);
				function frame(){

					if(fadeIn === 100) {
						clearInterval(f);
						//document.getElementById("noitems").remove();
					}
					else {

						fadeOut--;
						document.getElementById("noitems").style.opacity = (fadeOut / 100);
						fadeIn++;
						if(margin > 0) margin--;
						row.style.opacity = (fadeIn/ 100);
						checkbox.style.opacity = (fadeIn/ 100);
						row.style.marginLeft= margin+"%";
marginLeft 

					}

				}
			}
		}
		http.send(params);





		


		input.value = "";


	}
});





