  function remove_last_input(elm) {
var val = $(elm).val();
var cursorPos = elm.selectionStart;
$(elm).val( val.substr(0,cursorPos-1) + // before cursor - 1
val.substr(cursorPos,val.length) // after cursor
)
elm.selectionStart = cursorPos-1; // replace the cursor at the right place
elm.selectionEnd = cursorPos-1;
}
jQuery(function($){
 


    var urlselection = location.href.replace(/http?:\/\/.*?\//i , '/');  
	
	
		// input only integers
	$('body').delegate('input.only_integer','keyup',function(){
	if(!$(this).val().match(/^\-?[0-9]*$/)) // numbers
	remove_last_input(this);
	});
	// input only floats
	$('body').delegate('input.only_float','keyup',function(){
	if(!$(this).val().match(/^\-?[0-9]*[\.,]?[0-9]*$/)) // numbers[.,]numbers
	remove_last_input(this);
	});
	// input phone number
	$('body').delegate('input.only_phone_number','keyup',function(){
	if(!$(this).val().match(/^\+?[0-9 ]*$/)) // +numbers or space
	remove_last_input(this);
	});
	// input zip code
	$('body').delegate('input.only_zip_code','keyup',function(){
	if(!$(this).val().match(/^[0-9]{0,5}$/)) // 5 numbers maximum
	remove_last_input(this);
	});
	// input email
	$('body').delegate('input.only_email','keyup',function(){
	if(!$(this).val().match(/^[a-z0-9\-\.\_]*@?[a-z0-9\-\.]*\.?[0-9a-z]*$/i)) // a-z and 0-9
	remove_last_input(this);
	});
	// input alpha-num
	$('body').delegate('input.only_alpha_num','keyup',function(){
	if(!$(this).val().match(/^[0-9a-z]*$/i)) // a-z and 0-9
	remove_last_input(this);
	});
	// input alpha
	$('body').delegate('input.only_alpha','keyup',function(){
	if(!$(this).val().match(/^[a-z]*$/i)) // a-z
	remove_last_input(this);
	});
	// input hex
	$('body').delegate('input.only_hex','keyup',function(){
	if(!$(this).val().match(/^[0-9a-f]*$/i)) // 0-9 a-f
	remove_last_input(this);
	});
	// input oct
	$('body').delegate('input.only_oct','keyup',function(){
	if(!$(this).val().match(/^[0-7]*$/i)) // 0-7
	remove_last_input(this);
	});
	// input chemical element
	$('body').delegate('input.only_from_list','keyup',function(){
	var available_values = $(this).attr('list').split(','); // get le valid values from the 'list' attribut
	var val = $(this).val();
	if (val) { // something to analyse
	var valid_input = false;
	for (var elm in available_values) {
	if (val == available_values[elm].substr(0,val.length)) {
	valid_input = true; break;
	}
	}
	if (!valid_input)
	remove_last_input(this);
	}
	}); 
	if (document.getElementById('page_accueil')) {
	   $("#menu_deroulant ul").clone().appendTo("#page_accueil");
	}
});
	
 $("#div_import").qtip ({
    style: {             // style du carré http://craigsworks.com/projects/qtip/docs/tutorials/#styling   
              width      : 300,
              padding    : 3,
              background : 'white',
              color      : 'black', // Couleur de font
              fontFamily: 'Verdana, Arial, Helvetica, sans-serif',
              fontSize: '9px',
             // textAlign: 'center',
              name: 'light',        // Les attributs non spécifiés ci dessous seront hérité du style qTip par défaut "light"
              
              border: {  // Style de la bordure du cadre
                       width: 3,
                       radius: 4 // rayon de courbure
                      // color: 'gray'
                    },
                          
              tip: {corner : 'topLeft',         // Pointe http://craigsworks.com/projects/qtip/docs/tutorials/#tips
                    size: {
                      x: 10, // Be careful that the x and y values refer to coordinates on screen, not height or width.
                      y : 20 // Depending on which corner your tooltip is at, x and y could mean either height or width!
                          }
                    }       
           },

    position: {                 // position du cadre http://craigsworks.com/projects/qtip/docs/tutorials/#position                
                //  corner: {                 
                 //    tooltip: 'topMiddle'
                 //         }
               },
   show:      { 
                effect: {type   :'fade', // effet d'apparition (peut aussi être 'fade')
                         length : 200   // durée de l'effet 
                        }
              },
              
    content : 
     {
         text: false // Le text affiché sera celui compris dans l'attribut title de l'objet de classe .BulleQtip
      }

    
   
 })	
/*
Colonne 1 : RAISON SOCIALE | 
Colonne 2 :  DIRIGEANT | 
Colonne 3 : ADRESSE | 
Colonne 4 : CP | 
Colonne 5 : VILLE | 
Colonne 6 : TELEPHONE | 
Colonne 7 : EMAIL | 
Colonne 8 : CODE NAF | 
Colonne 9 : LIBELLE NAF | 
Colonne 10 : RUBRIQUE PROFESSIONNELLE | 
Colonne 11 : FORME JURIDIQUE | 
Colonne 12 : STATUT ETS | 
Colonne 13 : EFFECTIF | 
Colonne 14 : DEBUT ACTIVITE
*/
// Montre des sous menus et cache les autres
function montre(m1, m2) {
	for (var i = 1; i <= 16; i++) {
		var menu = document.getElementById('smenu' + i);
		if (menu) {
			if ((i == m1) || (i == m2)) {
				menu.style.display = 'block';
			}
			else {
				menu.style.display = 'none';
			}
		}
	}
}

// Demande une confirmation de suppression
function confirmerSuppression() {
	return confirm('Voulez-vous supprimer cet article ?');
}

// Ajoute l'action de montrer le bouton de validation du formulaire de liste lorsque qu'on modifie un champ
function surModificationChamps() {
	var f = document.getElementsByName('formulaire_liste')[0];
	if (f) {
		var champs = f.getElementsByTagName('input');
		for (var i = 0; i < champs.length; i++) {
			champs[i].onchange = showSubmitButton;
		}
	}
}

// Rend visible les boutons de soumission du formulaire de liste
function showSubmitButton() {
 alert ('modif !! ');
	var buttons = document.getElementsByTagName('input');
	for (var i = 0; i < buttons.length; i++) {
		if (buttons[i].className == 'submit_list_button') {
			buttons[i].style.visibility = 'visible';
			buttons[i].style.display = 'block';
		}
	}
}

