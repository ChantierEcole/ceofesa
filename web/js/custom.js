//  Code Javascript Perso
///////////////////////////////////////

jQuery(document).ready(function() {
      
    // Init Theme Core    
    Core.init();

    var strSelect = document.getElementById("strSelect");

    if (strSelect) {

    	$.ajax({  
    		type: "POST",
        	url: urlAjax2,
        	dataType: 'text',
        	timeout: 30000,
        	success: function(data) {     
          		$(strSelect).prev('button').html(data+'&nbsp;<span class="caret"></span>');
        	},
        	error: function(exception){
          		console.debug(exception);
        	}
        });
    	
    	$.ajax({  
    		type: "POST",
        	url: urlAjax1,
        	dataType: 'json',
        	timeout: 30000,
        	success: function(data) {          		         
          		//on efface la liste des structures
          		$(strSelect).html('');

          		//met à jour la liste des structures
          		$.each(data, function(index){
            		var id      = data[index].id;
            		var name    = data[index].nom;
            		$(strSelect).append('<li class="strSelectItem" data-strid="'+id+'"><a href="#">'+name+'</a></li>');
        		});
        	},
        	error: function(exception){
          		console.debug(exception);
        	}
        });
    }

    $('#strSelect').on('click', '.strSelectItem', function(){
    	var structure_id = $(this).data('strid');
    	var structure_name = $(this).children('a').html();

    	$(this).parent().prev('button').html(structure_name+'&nbsp;<span class="caret"></span>');

    	$.ajax({  
    		type: "POST",
        	url: urlAjax3,
        	data: {'structure_id':structure_id},
        	timeout: 30000,
        	success: function() {
        		window.location.reload();
        	},
        	error: function(exception){
          		console.debug(exception);
        	}
        });
    });

});