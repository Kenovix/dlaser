$(function() {        
	 
	//callback function to bring a hidden box back
	function callback() {
	  setTimeout(function() {
	    $( "#effectClip:visible" ).removeAttr( "style" ).fadeOut();
	  }, 20000 );
	};
    
	// set effect from select menu value
	$( "#medicamentoHc" ).click(function() {
	  $( "#effectClip" ).show( 'clip', 500, callback );// run the effect
	  return false;
	});
    
	$( "#effectClip" ).hide();
    }); 
