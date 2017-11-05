    var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : sParameterName[1];
				}
			}
		};
		
var GlobalCode = null;
var GlobalJson = null;
		
function getElements(inFunction) {		
if (getUrlParameter("code")) {
$.getJSON( "./getElements.php?code="+getUrlParameter("code"), function( json ) {
  GlobalCode = getUrlParameter("code");
  
  
  GlobalJson = json;
  if(inFunction) 	inFunction(json);	 
		 
		 
		 
}).fail(function(error) {console.log("Es ist ein Fehler aufgetreten. Es wird ein Datensatz " + code + " erzeugt.")});



}
}