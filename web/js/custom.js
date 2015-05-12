//  Author: Louis Holladay
//  Website: AdminDesigns.com
//  Last Updated: 01/01/14 
// 
//  This file is reserved for changes made by the user 
//  as it's often a good idea to seperate your work from 
//  the theme. It makes modifications, and future theme
//  updates much easier 
// 

//  Place custom styles below this line 
///////////////////////////////////////

jQuery(document).ready(function() {
      
    // Init Theme Core    
    Core.init();

    $(".confirmjq").on("click",function(event){
    	event.stopPropagation();
    	if (confirm("Confirmer la suppression de cet élément ?")){
    		this.click;
	    } else {
	    	event.preventDefault();
	    }
    });

    $(".modif-alert").on("click",function(event){
    	event.stopPropagation();
    	if (confirm("Attention : si vous quittez cette page, tout élément non enregistré sera perdu. Etes-vous sur de vouloir continuer ?")){
    		this.click;
	    } else {
	    	event.preventDefault();
	    }
    });

});