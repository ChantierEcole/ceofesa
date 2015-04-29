//  Code Javascript Perso
///////////////////////////////////////

jQuery(document).ready(function() {
      
    // Init Theme Core    
    Core.init();

    var strSelect = document.getElementById("strSelect");

    if (strSelect) {
    	
    	$.ajax({  
    		type: "POST",
        	url: urlAjax1,
        	dataType: 'json',
        	timeout: 30000,
        	success: function(data) {
          		console.log(data);
          		         
          		//on efface la liste des structures
          		$(strSelect).html('');

          		//met à jour la liste des joueurs
          		$.each(data, function(index){
            		var id      = data[index].id;
            		var name    = data[index].nom;
            		$(strSelect).append('<li><a href="#">'+name+'</a></li>');
        		});
        	},
        	error: function(exception){
          		console.debug(exception);
        	}
        });
    }

});