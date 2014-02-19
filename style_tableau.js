/**
 * Design des tableaux avec couleur lignes alternées
 * Ajax pour gestion recherche avec filtres 
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
    $('.popup').live('click', function() { 
        Shadowbox.open(this); 
        return false; 
    }); 
	
	//$("table").after("<a rel='shadowbox;height=800px;width=1024px;' href='contact/contact.php?id_contact=16'>Fiche</a>");
	var isTable = $("table");
	
	// Vérifie qu'il y a un tableau sur la page. 
	$(isTable).each(function(index){
		var numTableau = index + 1;
		
		// ligne 1 = titre & ligne 2 = filtres
		var i = 3;
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

/*function createLine(nom_utilisateur, prenom_utilisateur, tel_utilisateur, portable_utilisateur,
 mail_utilisateur, ville_agence, cp_agence, nom_agence){
	// Valorise variables utilisées par l'appel de la méthode
	this.nom_utilisateur = nom_utilisateur;
	this.prenom_utilisateur = prenom_utilisateur;
	this.tel_utilisateur = tel_utilisateur;
	this.portable_utilisateur = portable_utilisateur;
	this.mail_utilisateur = mail_utilisateur;
	this.ville_agence = ville_agence;
	this.cp_agence = cp_agence;
	this.nom_agence = nom_agence;
}*/

var TSelect = new Array;
var TIds = new Array();
//var TLibelles = new Array();
var TFiltersName = new Array();
var TFiltersValue = new Array();

$(document).ready(function(){
	styleFeuille();
	// Id SQL
	jQuery.each($("th"), function(index){
		if ($(this).attr("id") != "choix"){
			TSelect[TSelect.length] = $(this).attr("id");
		}
	});
	
	// Entête tableau
	/*jQuery.each($("th"), function(index){
		TLibelles[index] = $(this).html();
	});*/
	
	// Filtres
	var child;
	jQuery.each($(".filter > td"), function(index){
		// Enfant de la ligne de filtre
		child = $("#" + $(this).attr("id") + " > :input:not(:button, #filter_choix)");
		
		if (child.length > 0){
			// Il existe un champs à filtrer
			// Enlève le "filter_" au nom de la variable -> retrouve le nom SQL
			TFiltersName[TFiltersName.length] = child.attr("id").substr(7);
			TFiltersValue[TFiltersValue.length] = child.val();
		}
	});
	
	if ($("table").length > 0){
		changeTableau();
		styleTableau();
	}
});

function changeTableau(choix, page){
    
        if(typeof(page) === 'undefined'){
            page = 1;          
        }
        //alert(page);
	// Vide le tableau des filtres
	TFiltersValue = [];
	//var choix = $("#filter_choix").val();
        
	// Actualise les valeurs des filtres
	jQuery.each($(".filter > td > :input:not(:button, #filter_choix)"), function(){
		TFiltersValue[TFiltersValue.length] = $(this).val();
	});
		
	// Données à envoyer
	var data2 = {
		"TSelect[]": TSelect,
		"TIds[]": TFiltersName,
		"TValues[]": TFiltersValue,
		"TDbs[]": TDbs,
		"choix": choix,
                "page": page,
		"conditions": function() { if(typeof (conditions) != "undefined"){ return conditions; } else{ return ""; alert();}; }
	};
	
	jQuery.ajax({
		url: "actualise_tableau.php",
		context: document.body,
		type: "GET", 
		data: data2,
		dataType: "html",
		success: function(result){
			if (result == 0){
				alert("Aucun resultat"); 
			}
			else{
				// Affiche résultats
				// Lignes du tableau
				var TLinesTable = $("table .impair, table .pair");
                                
                                var TLinesPage = $("table .tabPage");
                                
                                
//				
				jQuery.each(TLinesTable, function(){
					// Vide le tableau actuel
					$(this).remove();
				});
				
				
				// Découpage resultat par enregistrement
				var TLineRequest = result.split("/");
				
				var numLine = 3;
				
				jQuery.each(TLineRequest, function(indexLine){
					// Découpage par champs pour chaque enregistrement
					var TFieldRequest = TLineRequest[indexLine].split("*");
					
					// Création nouvelle ligne et du champ fiche si demandé
					if (fiche){
						$("table").append("<tr id='T1line" + numLine + "' class='newLine'></tr>");				
						$("table tr:last-child").append("<td><a href='" + lien + "?id=" + TFieldRequest[0]
						 +"' rel='shadowbox;height=800px;width=1024px;' title='Modifier une offre'"         
						 + "class='popup'><img src='Images/loupe.png' title='Voir fiche'></a></img>"
						 + "<a href='include/html2pdf/createPDF.php?id=" + TFieldRequest[0]
						 + "' title='Fiche commerciale' target='_blank'>Fiche</a></td>");
					}
					else{
						$("table").append("<tr id='T1line" + numLine + "' class='newLine'></tr>");				
						$("table tr:last-child").append("<td><a href='" + lien + "?id=" + TFieldRequest[0]
						 + "' rel='shadowbox;height=800px;width=1024px;' title='Modifier une offre'"
						 + "class='popup'><img src='Images/loupe.png' title='Voir fiche'></a></img>");                                           
					}
					
					var numColumn = 2;
					
					jQuery.each(TFieldRequest, function(indexField){
						//alert(TFieldRequest[9]);
						// Création nouveau champ et remplissage
						$("table tr:last-child").append("<td id='T1line" + numLine + "column" + numColumn + "'>"
						 + TFieldRequest[indexField] + "</td>");
						
						numColumn++;
					});
					
//                                        
                                        
					numLine++;
					// Couleur lignes
				});	
				
                                jQuery.each(TLinesPage, function(){
                                        $(this).remove()
                                });
                                
                                var $firstpage;
                                var $prevpage;
                                var $pageactuelle;
                                var $nextpage;
                                var $lastpage;
                                var newpagesuiv;
                                var newpageprec;
                                var newpagelast;

                                newpageprec = page - 1;
                                newpagesuiv = page + 1;
                                newpagelast = nbPage;

                                $firstpage="<td><a href='#' id='btn_prem' onclick='changeTableau(\"" + choix + "\", 1)'><img src='images/Fast-Backward.png' title='Première Page'></img></a></td>";
                                $prevpage="<td><a href='#' id='btn_prec' onclick='changeTableau(\"" + choix + "\", "+newpageprec+")'><img src='images/Arrow-Left.png' title='Page Précédente'></img></a></td>"; 
                                $nextpage="<td><a href='#' id='btn_suiv' onclick='changeTableau(\"" + choix + "\", "+newpagesuiv+")'><img src='images/Arrow-Right.png' title='Page Suivante'></img></a></td>";                                                                  
                                $lastpage="<td><a href='#' id='btn_dern' onclick='changeTableau(\"" + choix + "\", "+newpagelast+")'><img src='images/Fast-Forward.png' title='Dernière Page'></img></a></td>";
                                $pageactuelle="<td><p>[Page : "+page+" de "+newpagelast+"]</p></td>"

                                $("table").append("<tr class='tabPage'></tr>");
                                $("table tr:last-child").append($firstpage+$prevpage+$pageactuelle+$nextpage+$lastpage);

                                styleTableau();
                                //$("table").after("<a rel='shadowbox;height=800px;width=1024px;' href='contact/contact.php?id_contact=16'>Fiche</a>");

                                if(page == 1){
                                    document.getElementById('btn_prem').style.visibility = 'hidden';
                                    document.getElementById('btn_prec').style.visibility = 'hidden';
                                }

                                if(page == newpagelast){
                                    document.getElementById('btn_suiv').style.visibility = 'hidden';
                                    document.getElementById('btn_dern').style.visibility = 'hidden';
                                }

                                if(page<=newpagelast && page>=1){
                                    $('#pageactu').html(page);
                                }
                                    
                                    
                                    
                            }
                        
		},
		error: function(){
			alert("Erreur ajax");
		}
	}); 
}

function styleFeuille(){
	//alert($("#connexion").width());
	$("#connexion").css({"margin-left": $(window).width() - $("#connexion").width() - 100});
	$("#captionTitle").css({"margin-left": $("table").width() / 2 - $("#captionTitle").width() / 2 - $("#buttons").width()});
}