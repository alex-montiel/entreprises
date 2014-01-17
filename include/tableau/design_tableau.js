/**
 * Design des tableaux avec couleur lignes alternées
 * Ajax pour gestion recherche avec filtres 
 * @autor: Florian Morin pour Admin-Services (2012)
 */

function isPair(nb){
	// Si le nombre / 2 = entier du nombre / 2, il est pair
	if(nb/2 == Math.round(nb/2)){
		return true;
	}
	else{
		return false;
	}
}

function styleTableau(){		
	//$("table").after("<a rel='shadowbox;height=800px;width=1024px;' href='contact/contact.php?id_contact=16'>Fiche</a>");
	var isTable = $("table");
	
	// Vérifi qu'il y a un tableau sur la page. 
	$(isTable).each(function(index){
		var numTableau = index + 1;
		var i = 1;
		var line = $("#T" + numTableau + "line" + i);
		
		// Vérifi qu'il y a qqchose à la ligne du tableau
		while(line.length > 0){
			while(line.length > 0){
				if(isPair(i)){
					line.addClass('pair');
				}
				else{
					line.addClass('impair');
				}
				i++;
				line = $("#T" + numTableau + "line" + i);
			}
			i = 1;
			numTableau++;
			line = $("#T" + numTableau + "line" + i);
		}
	});
}