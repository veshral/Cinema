/*
*	Programme de Jquery : 
*  0. Les bases de Jquery (rappel JS, bibliopthèque JS) + Etudier le documentation avec Cheat sheet 
*  1. Selecteurs
*  2. Manipulation CSS
*  3. Manipulation DOM
*  4. Traversing des éléments DOM
*  5. Evenements avec Jquery
*  6. Intégration JS avec Boostrap Twitter
*  7. Best plugins à integrer avec Jquery
*  8. Création de son propre plugin Jquery
*  9. Outil Compressions, Minimifiction, Concaténations etc...
*  10. Ouverture: Preprocessing avec pseudo langage SASS & Coffeescript

* ------------------------------------------------------------------------------------------------------------------------
*  
*  Estimation de temps : 3 x 3h.
*  
*  So, anyway... if so powerful you've become, why leave...?
*  Let me try & play within this f*ck'in awesome framework b***h beyond my limits ! ... :) 
*/

/**********************************************************************************************************************/


/**
* Debut 
*/
$(document).ready(function(){
// version raccourci : $(function() {

	/* ---------------------------------PARTIE 1

	// Sélection elements par classe
	console.log($('div#album img.img-thumbnail').length);

	console.log($('#content-wrapper > div.page-header').length);

	// Sélection par ID
	console.log($('div#album').length);

	// Sélection par élément
	console.log($('h1').length);

	//$('#content-wrapper > div.page-header + h3').css('color','blue');

	$('#content-wrapper > div.page-header + h3').css({
		'color' : 'blue',
		'font-size' : '54px'
		});

	// les elements freres
	$('div#album ~ p').css('color','red');

	//combinaisons d'élements
	$('p, h1, h2, div#album').css('color', 'grey');

	//:first pseudo sélecteur
	$('#content-wrapper h3:first').css('color','black');

	//:last pseudo sélecteur
	$('#content-wrapper h3:last').css('color','pink');

	//:eq sélection par index
	$('#content-wrapper h3:eq(1)').css('color','green');

	//gt() plus grand que
	$('div#album img.img-thumbnail:gt(3)').css('opacity', 0.5);

	//lt() plus petit que
	$('div#album img.img-thumbnail:lt(2)').css('border', '1px solid #222');

	// selecteur rapide de tous les <Hn>
	$(':header').css('font-family', 'Verdana');

	$(':radio:not(:checked) + span').css('color','blue');

	$('.theme-asphalt #main-navbar .widget-messages-alt .message-subject').css('color', 'red');

	// contient - vérifie au niveau du contenu
	$('h3:contains("Julien")').css('color','purple');

	// qui a - sélectionner un élément si il comporte un élément fils
	$('div#album:has(img.img-thumbnail)').css('opacity', 0.3);

	// sélecteur par attribut
	$('a[href]').css('color', 'tomato');

	$(':input[placeholder]').css('color','purple')

	------------------------------------FIN PARTIE 1 */

	/* ---------------------------------DEBUT PARTIE 2 */

	// $('input[placeholder="Email"]').css('border','1px solid red');
	// $('input[placeholder="Password"]').css('border','1px solid red');
	// $('textarea[class="form-control"]').css('border','3px solid red');
	// $('button[type="submit"]').css('border', '1px dashed blue');
	// $('button[type="submit"]').css('background', 'red');
	// $('[placeholder]').css('background', 'red');
	// $('img[src$=".jpeg"], img[src$=".jpg"]').css('border','2px dotted green');


	// $(':text').attr('placeholder', 'veuillez entrer votre texte');
	
	// $('textarea, input').attr(
	// 	{
	// 		'required' : 'required',
	// 		'pattern' : ".{3,}"
	// 	}
	// 	);


	// // Supprimer l'attribut placeholder
	// $('input').removeAttr('placeholder');
	
	// $('textarea').val('Petite description sympa');

	// $('input[type="url"]').val('http://');


	// $('.img-thumbnail:eq(1)').removeClass('img-thumbnail').addClass('img-circle');
	// $('.img-thumbnail:eq(1)').toggleClass('img-thumbnail','img-circle');


	// // $('.img-thumbnail:eq(1)').attr('src','http://www.wallfizz.com/nature/neige/3436-nature-enneigee-WallFizz.jpg');


	/* ---------------------------------FIN PARTIE 2 */

	/* ---------------------------------DEBUT PARTIE 3 

	// récupère le 1er élément
	$('div#album img').first().css('border','1px solid red');

	// récupère le dernier élément
	$('div#album img').last().css('border','1px solid #444');

	// accéder à un élément particulier
	$('div#album img').eq(3).css('border','1px solid green');


	$('#content-wrapper div').filter('.table-primary').css('opacity', 0.5);


	$(':checkbox').is(':checked')
	//alert($('#boite').is(':visible'));
	//alert($('#boite').is(':hidden'));

	//alert($('#sexe').is(':checked'));
	//alert($('#cgu').is(':checked'));


	//children : les enfants de
	var nb = $('div#album').children().length;

	$('div#nbphotos').html('<span class="label label-success">Il y a ' + nb + ' photos.</span>')


	$('div#album').find('#testfind').css('opacity', 0.5);

	//le frere suivant
	$('div#textdemo p#middle').next().css('color', 'red');

	//le frere précédent
	$('div#textdemo p#middle').prev().css('color', 'green');

	//les freres suivants
	$('div#textdemo p#middle').nextAll().css('color', 'red');

	//les freres précédents
	$('div#textdemo p#middle').prevAll().css('color', 'green');

	// on récupère l'élement parent ou arrière grand-parents
	$('#testfind').parents('div#album').css('border','5px dashed red');

	$('#textdemo p#middle').parents('#textdemo').find('p').css('font-size', '24px');


	var html = $('<h1>Bonjour</h1>');
	var html2 = $('<h1>Bonjour 22222222</h1>');
	var html3 = $('<h1>Bonjour 333333333</h1>');
	var html4 = $('<h1>Bonjour 4444444444</h1>');


	// ajouter un élément html à la fin d'un autre élément
	$('#textdemo').append(html);
	$('#textdemo').prepend(html2);
	$('#textdemo').after(html3);
	$('#textdemo').before(html4);

	---------------------------------FIN PARTIE 3 */


	/* ---------------------------------DEBUT PARTIE 4 

	// fonction evenement : click sur les images
	$('img.img-thumbnail').click(function(){
		// alert('ok');
		var elementcourant = $(this); // je stocke mon élément courant dans ma variable elementcourant
		elementcourant.css('opacity', 0.6);
	});


    $('#textdemo p').click(function(){
    	var elementcourant = $(this); // je stocke mon élément courant dans ma variable elementcourant
		elementcourant.css('color', 'green');
	});

	$('img.img-thumbnail').click(function(){
		var elementcourant = $(this); 
		elementcourant.toggleClass('img-circle', 'img-thumbnail');
	}); // quand je bascule d'une classe à une autre 
		// il me fait une animation avec la propriété transition

	
	// blur : fonction évenementielle quand je quitte le focus des champs
	$('input, textarea').keyup(function(){
		var elementcourant = $(this); 

		var regex = /[a-zA-Z0-9]{5,}/;
		var regexemail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

		if (elementcourant.val() == "") {
			elementcourant.css('border', '1px solid red');
		} else if (!regexemail.test(elementcourant.val())
			&& elementcourant.attr('id') == "inputEmail2"){
			
			elementcourant.css('border', '1px solid orange');
		} else {
			elementcourant.css('border', '1px solid green');
		}

	});

*/



});