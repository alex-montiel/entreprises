<?php
	session_start();
	
	if($_SESSION['acces'] != "oui")
	{
		header("Location:../accueil.php");
	}
?>

<!-- 
	Formulaire pour l'ajout d'un nouveau contact et la modification d'un contact existant.
	Affichage dans une fenêtre popup de type shadowbox.
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="../include/offre.css" />
	
	<link type="text/css" href="../include/jquery-ui/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
	<link type="text/css" href="../include/jquery-autocomplete/jquery.autocomplete.css" rel="stylesheet" />
	<link rel="stylesheet" href="../include/pagination/pagination.css" />
	<link rel="stylesheet" href="../include/clockpick/clockpick.css"/>
	<link rel="stylesheet" href="../include/tableau/param_table.css"/>

	<?php
	include("../include/connex.inc.php");
	

	
	function date2fr($date)
	{
		if($date != "0000-00-OO")
		{
			//récupération des différentes valeurs en utilisant les / comme séparateurs
			@list($annee,$mois,$jour) = explode('-',$date);
			
			//retour de la date modifié au bon format grace à un mktime
   			return @date('d/m/Y',mktime(0,0,0,$mois,$jour,$annee));
		}
	}
	?>

	<script type="text/javascript" src="../include/jquery.js"></script>
	<script type="text/javascript" src="../include/shadowbox/shadowbox.js"></script>
	<script type="text/javascript" src="../include/jquery-ui/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="../include/jquery-autocomplete/jquery.autocomplete.js"></script>
	<script type="text/javascript" src="../include/pagination/jquery.pagination.js"></script>
	<script type="text/javascript" src="../include/clockpick/clockpick.js"></script>
	<script type="text/javascript" src="../include/tableau/design_tableau.js"></script>
	<script type="text/javascript" src="../include/tiny_mce/tiny_mce.js"></script>
	
	<?php
	if(isset($_GET[id]))
	{
		$id_offre = $_GET[id];
		$requete = "SELECT * FROM offre WHERE id_offre = '$id_offre'";
		$return = mysql_query($requete);
		$offre = mysql_fetch_array($return);
	
		$requete = "SELECT * FROM offre_surface WHERE id_offre = '$id_offre'";
		$surface = mysql_query($requete);
		$nbre_surface = mysql_num_rows($surface);
		
		$requete = "SELECT * FROM offre_photo WHERE id_offre = '$id_offre' ORDER BY id_photo";
		$photo = mysql_query($requete);
		$nbre_photo = mysql_num_rows($photo);
		
		
		$requete = "SELECT id_agence FROM utilisateur WHERE id_utilisateur=".$offre['id_utilisateur'];
		$utilisateur = mysql_fetch_array(mysql_query($requete));
		
		if($_SESSION['agence'] != $utilisateur['id_agence'] && $_SESSION[login] != "Admin")
		{
			echo "<script type=\"text/javascript\"> parent.Shadowbox.close();</script>";
			echo "<script type=\"text/javascript\"> document.location.href=\"../index.php?requete=offre\";</script>";
		}
		
	}
	?>

	<script type="text/javascript">
	Shadowbox.init({
	    language:   "en",
	    players:    ["html", "iframe", "img"]
	});

	tinyMCE.init({
		mode : "exact",
		theme : "advanced",
		elements : "document_content",
		    plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,ibrowser", 
		 
		    // Theme options 
		    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,<gras>ibrowser</gras>,fontsizeselect", 
		    theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,undo,redo,|,link,unlink,anchor,image,code,|,preview,|,forecolor,backcolor", 
		    theme_advanced_buttons3 : "tablecontrols,|,hr,|,charmap,|,fullscreen", 

		theme_advanced_toolbar_location : "top",

		theme_advanced_toolbar_align : "left",
		//width: 1000,
		//height: height,
		language : "fr"
	});
	</script>
	
	<!-- script pour la gestion des onglets, datepicker, autocomplete -->
	
	<script type="text/javascript">
		
		$(function() {
			$("#tabs").tabs();
		});
	
	
	
		$(function() {
			$("#date_bail").datepicker({dateFormat: 'dd/mm/yy'});
			$("#date_dispo_location").datepicker({dateFormat: 'dd/mm/yy'});
			$("#date_dispo_vente").datepicker({dateFormat: 'dd/mm/yy'});
			$("#date_start_tache").datepicker({dateFormat: 'dd/mm/yy'});
			$("#debut_rapport").datepicker({dateFormat: 'dd/mm/yy'});
			$("#fin_rapport").datepicker({dateFormat: 'dd/mm/yy'});
		});
		
		
		$(document).ready(function() {									
			$("#ville").autocomplete("../ville_cp_auto_complete.php?data=ville", {
										matchContains: true,
										selectFirst: true,
			});

			// Cache les onglets
			$(".tabContent").each(function(i){
			        this.id = "#" + this.id;
			    });

		    $(".tabContent:not(:first)").hide();

		    $("#onglet a").click(function() {
		        var idTab = $(this).attr("href");
		        $(".tabContent").hide();
		        $("div[id='" + idTab + "']").fadeIn();
		        return false;
		    });
			
		});
	$(function() {
		function format(contact) {
			return contact.civilite+"  "+contact.name + " " + contact.prenom + " &lt;"+ contact.societe + " " + contact.ville + "  " + contact.portable + "&gt;";
		}
		$("#proprietaire").autocomplete('../nom_auto_complete.php', {
			parse: function(data) {
				return $.map(eval(data), function(row) {
					return {
						data: row,
						value: row.name,
						result: row.name
					};
				});
			},
			formatItem: function(item) {
				return format(item);
			}
		}).result(function(e, item) {
			$('#proprietaire_id').val(item.id);
		});
		
		$("#suivi").autocomplete('../utilisateur/utilisateur_auto_complete.php', {
			parse: function(data) {
				return $.map(eval(data), function(row) {
					return {
						data: row,
						value: row.name,
						result: row.name
					};
				});
			},
			formatItem: function(item) {
				return item.name+"  "+item.prenom+"  --"+item.status+"--";
			}
		}).result(function(e, item) {
			$('#id_utilisateur').val(item.id);
		});
		
		$("#mandant").autocomplete('../nom_auto_complete.php', {
			parse: function(data) {
				return $.map(eval(data), function(row) {
					return {
						data: row,
						value: row.name,
						result: row.name
					};
				});
			},
			formatItem: function(item) {
				return format(item);
			}
		}).result(function(e, item) {
			$('#mandant_id').val(item.id);
		});
		
		$("#loue_par").autocomplete('../nom_auto_complete.php', {
			parse: function(data) {
				return $.map(eval(data), function(row) {
					return {
						data: row,
						value: row.name,
						result: row.name
					};
				});
			},
			formatItem: function(item) {
				return format(item);
			}
		}).result(function(e, item) {
			$('#loue_par_id').val(item.id);
		});
	
		$("#visiteur").autocomplete('../nom_auto_complete.php', {
			parse: function(data) {
				return $.map(eval(data), function(row) {
					return {
						data: row,
						value: row.name,
						result: row.name
					}
				});
			},
			formatItem: function(item) {
				return format(item);
			}
		}).result(function(e, item) {
			$('#visiteur_id').val(item.id);
		});
	
	});
	</script>
	
	<script type="text/javascript">
	        
	            // This is a very simple demo that shows how a range of elements can
	            // be paginated.
	        
	            /**
	             * Callback function that displays the content.
	             *
	             * Gets called every time the user clicks on a pagination link.
	             *
	             * @param {int}page_index New Page index
	             * @param {jQuery} jq the container with the pagination links as a jQuery object
	             */
				function pageselectCallback(page_index, jq){
	                var new_content = $('#hiddenresult div.result:eq('+page_index+')').clone();
	                $('#Searchresult').empty().append(new_content);
	                return false; 
	            }
	           
	            /** 
	             * Callback function for the AJAX content loader.
	             */
	            function initPagination() {
	                var num_entries = $('#hiddenresult div.result').length;
	                // Create pagination element
	                $("#Pagination").pagination(num_entries, {
	                    num_edge_entries: 2,
	                    num_display_entries: 4,
	                    callback: pageselectCallback,
	                    items_per_page:1
	                });
	             }
	                    
	            // Load HTML snippet with AJAX and insert it into the Hiddenresult element
	            // When the HTML has loaded, call initPagination to paginate the elements        
	            $(document).ready(function(){      
	                initPagination();
	            });
	            
	            
	            
	</script>
		
	<script type="text/javascript">
		$(document).ready(function() {
			$(".time").clockpick({
			starthour: 8,
			endhour: 19,
			minutedivisions: 2,
			military: true,
			layout: 'horizontal' 
			});
		});
	</script>
	
	<script type="text/javascript">
		
		//fonction permettant l'affichage de la ville en fonction du code postal
		function afficheVille(size, cp) 
		{
	    	
	    	if (cp.length > size-1)	// déclanchement de la fonction qu'une fois le code postal fini d'être entrer (size = 5)
	    	{
	  			$.ajax				// requete ajax jquery
	  			({ 
					type: "GET",// de type GET
					url: "../verif_cp.php?cp="+cp,// script qui traitera les données 
					success:function(data)		// en cas de succés
					{ 
						if(data==0) 			// si la valeur retourné est 0
						{ 
							alert('Aucun resultat, modifier le code postal'); 	// aucune ville correspondante
						} 
						else if(data==1)		// si la valeur retournée est 1 (plusieurs villes possibles)
						{ 
							
							Shadowbox.open		//appelle shadowbox
							({
		 						player:     "iframe",// une page html
		 						content:    '../choix_ville.php?codepostal='+cp,	//chargement de la page choix_ville.php avec comme donnée le code postal
	        					title:      "Code postal disponible pour "+cp,	// le titre
	        					height:     350,								// la hauteur
	        					width:      350									//la largeur
	        				});
						}
						else					// si la valeur est différente de 0 ou 1, elle aura la valeur de la ville
						{
							document.getElementById('ville').value = data;		// insertion de la ville dans le formulaire
	    				}
	
					} 
				}); 
			}
		}
		
		function afficheCp(ville) // fonction permettant l'affichage du code postal en fonction de la ville
		{
	  		if (ville.length > 1)	// il faut au moins 2 caractere à la ville
	  		{
	  			$.ajax				// requete ajax
	  			({ 
					type: "GET",	// de type GET 
					url: "../verif_ville.php?ville="+ville, // script PHP traitant les données
					success:function(data)				// en cas de succes
					{ 
						if(data==0) 					// si valeur retourné est 0
						{ 
							alert('Aucun resultat, modifier le nom de la ville'); 	// pas de code postal disponible
						} 
						else if(data==1)				// si la valeur retourné est 1 ==> plusieurs codes postaux possibles
						{ 
							Shadowbox.open				// appelle shadowbox
							({
		 						player:     "iframe",	// page html
		 						content:    '../choix_cp.php?ville='+ville,// chargement de la page choix_cp.php avec comme donnée la ville 
	        					title:      "Code postal disponible pour "+ville,	// titre
	        					height:     350,									// hauteur
	        					width:      350										// largeur
	        				});
						}
						else // si la valeur est différente de 0 ou 1 (il s'agit du code postal)
						{
							document.getElementById('cp').value = data; // insertion du code postal
	    				}
	
					} 
				}); 
			}
		}
		
		function duplication(id)// fonction permettant la duplication des inputs de surfaces dans l'onglet généralites
		{
	 		document.getElementById(id).onclick = null;	// on supprime l'évenement onclick de l'input appelant
	 		id = parseInt(id);							// conversion de l'id en INT
	 		if(id < 5)									// test de l'id ==> limite a 5 surface
	 		{
	 		new_id = id+1;								// création de la nouvelle id
	  		nouveauDiv = document.createElement("fieldset"); // création du nouveau fieldset
	  		nouveauDiv.innerHTML = '<p id="'+new_id+'" onClick="duplication(this.id)"><select id="type_'+new_id+'" name="type_'+new_id+'"><option value="">Type de produit</option><?php $requete = "SELECT * FROM typedeproduit"; $return = mysql_query($requete); while ($type = mysql_fetch_array($return)){echo "<option value=\"".$type['typedeproduit']."\">".$type['typedeproduit']."</option>";}?></select><input type="text" id="repere_'+new_id+'" name="repere_'+new_id+'" value="Repere" maxlength="50" onFocus="if (this.value==\'Repere\') {this.value=\'\'}"><input type="text" id="surface_'+new_id+'" name="surface_'+new_id+'" value="Surface m²" maxlength="10" onchange="surfacetotal()" onFocus="if (this.value==\'Surface m²\') {this.value=\'\'}"><input type="text" id="comm_surface_'+new_id+'" name="comm_surface_'+new_id+'" value="commentaire" maxlength="150" onFocus="if (this.value==\'commentaire\') {this.value=\'\'}"></p>'; // "remplissage du fielset"
	  		nouveauDiv.setAttribute("class", "surface");	// attribution de la classe surface au nouveau fieldset
	  		
	
	  		mon_div = document.getElementById("sous_surface");
	  		document.getElementById("surface").insertBefore(nouveauDiv, mon_div);	// insertion dans la partie surface avant mon_div qui est l'input "sous_surface"
	  		document.getElementById("nbre_surface").value = id;						// affectation de la nouvelle id au champ caché nbre_surface
	  		}
	}	
	
		function duplication_photo()// fonction permettant la duplication des inputs de photos 
		{
			id = parseInt(document.getElementById("nbre_photo").value) + 1;	// on récupére l'id courante + convertion en INT
			if(id < 10)														// test du nombre de photos
			{					
			new_id = id+1;													// création de la nouvelle id
			document.getElementById("photo"+id).onclick= null;				// suppresion de l'évenement onclick de l'input appelant 
			nouveauDiv = document.createElement("p");						// creation du nouveau paragraphe
			nouveauDiv.innerHTML = '<label for="photo'+new_id+'">Photographie n°'+new_id+'</label><input type="file" id="photo'+new_id+'" name="photo'+new_id+'" onclick="duplication_photo()">'; // remplissage du paragraphe
			document.getElementById("photographie").appendChild(nouveauDiv);// insertion du nouveau paragraphe
			}
			document.getElementById("nbre_photo").value = id;				// mise a jour de l'id contenue dans le champ caché nbre_photo
		}
	 	
	 	function surfacetotal()	// fonction permettant le calcul de la surface total
	 	{
	 		nbre_surface = parseInt(document.getElementById("nbre_surface").value);	// récuperation du nbre d'input de surface
	 		total = 0;	// initialisation de la variable total
	 		for (i=1; i<=nbre_surface; i++)	// boucle pour le calcul
	 		{
	 			total += parseInt(document.getElementById("surface_"+i).value); // additiondes differentes surfaces
	 		}
	 		document.getElementById("surface_total").value = total+"m²";	// insertion de la variable total dans l'input surface_total
	 		prix_metre();
	 		loyer_metre();
	 	}
	 	
	 	function loyer(loyer)	// fonction permettant le calcul du loyer mensuelle 	
	 	{
	 		loyer = parseInt(loyer);	// convertion en INT du loyer
	 		alert(loyer);
	 		loyermensuel = loyer / 12;	// division par 12 pour avec le mensuelle
	 		document.getElementById("loyer_mensuel").value = loyermensuel + "€";	//insertion loyer_mensuel + €
	 		document.getElementById("loyer_annuel").value  = loyer + "€";			// insertion loyer_annuel + €
	 		loyer_metre();
	 		
	   	}
	   	
	   	function loyer_metre()
	   	{
	   		loyer2 = parseInt(document.getElementById("loyer_annuel").value);
	   		surface = parseInt(document.getElementById("surface_total").value);	// récupération de la surface
	   		loyer2 = loyer2 / surface;
	   		if(!isNaN(loyer2) && loyer2 != Infinity)
	   		{
	   			document.getElementById("loyer_m2").value = loyer2.toFixed(2) + "€";
	   		}
	   	}
	  	
	  	function prix_metre()	// fonction permettant le calcul du prix au metre carré en fonction du prix des murs et de la surfaces
	  	{
	  		prix = parseInt(document.getElementById("prix_murs").value);	// convertion du prix en INT
	  		surface = parseInt(document.getElementById("surface_total").value);	// récupération et convertion de la surface
	  		prix = prix / surface;	// division
	 		if(!isNaN(prix) && prix != Infinity )
	 		{
	 		document.getElementById("prix_m2").value= prix.toFixed(2) + "€";	// insertion du prix au metre carree  		
			}
	  	}
	 	
	 	function impot()		// fonction permettant le calcul des impots
	 	{
	 		var impot = 0;		// initialisation de la variable impot
	 		impot = parseInt(document.getElementById("impot_locataire").value) + parseInt(document.getElementById("impot_proprio").value) ; // addition des impots
	 		document.getElementById("impot_foncier").value= impot ;	// insertion de l'impot foncier
	 		document.getElementById("impot_foncier_vente").value = impot; // insertion dans la prtie vente
	 	}
	 	
	 	function recup_extension(fichier) // fonction de récupération extension fichier
	   	{
	        if (fichier!="")// si le champ fihier n'est pas vide
	        {
	           nom_fichier=fichier;// on récupere le chemin complet du fichier
	           nbchar = nom_fichier.length;// on compte le nombre de caractere que compose ce chemin
	           extension = nom_fichier.substring(nbchar-4,nbchar); // on récupere les 4 derniers caracteres
	           extension=extension.toLowerCase(); //on uniforme les caracteres en minuscules au cas ou cela aurait été écris en majuscule...
	           return extension; // on renvoi l'extension vers la fonction appelante
	        }
	    }
	
		function verif_extension(fichier)// fonction vérification de l'extension aprés avoir choisi le fichier
	   	{
	   		ext = recup_extension(fichier, id);// on appelle la fonction de récupération de l'extension et on récupere l'extension
	   
	        if(ext==".jpg"||ext==".gif"||ext==".png"){}// si extension = a une des extension suivante alors tout est ok donc ... pas d'erreur
	        else // sinon on alert l'user de la mauvaise extension
	        {
	         	alert("L'extension du fichier que vous voulez uploader est :'"+extension+"'\n cette extension n'est pas autorisée !\n Seules les extesnions suivantes sont autorisées :\n'JPG;PNG;GIF' !");
	        }
	   }
		
		
		function supprimer_photo(id, id_photo)
		{	$.ajax
	  			({ 
					type: "GET", 
					url: "../photographie/supprimer_photo.php?id_photo="+id_photo, 
					success:function(data)
					{ 
						if(data == 'erreur')
						{
							alert("Un problème a eu lieu durant la suppression de la photo d'id:"+id_photo);
						}
						else
						{
							$('#'+id).hide();
							
						}
						
						
	
					} 
				});
		}
		
		function visite(tache){
			$.ajax({
				type: "GET",
				url: "typeAction.php?tache="+tache,
				success: function(data){
					if(data == "calendrier"){
						// Heure precise affichée
						$("#visite").css("display", "block");
					}
					else{
						// Heure precise masquée
						$("#visite").css("display", "none");
					}
				}
			});
		}
		
		
		function reset_tache()
		{
			$('#form_action').find('select').find('option:first').attr('selected', 'selected').parent('select');
			$('#date_start_tache').val("Date de l'évenement");
			$('#time_start_tache').val("heure de commencement");
			$('#time_end_tache').val("heure de fin");
			$('#visiteur_id').val("");
			$('#visiteur').val("Contact");
			$('#comm_tache').val("Commentaire");
			$("#visite").css("display", "none");
			document.getElementById('bouton_tache').onclick = function(){ ajouter_tache(); };
			$("#bouton_tache").val("Ajouter tache");
		}
		
		function ajouter_tache()
		{
			if($("#type_tache").val() != '')
			{
				var id_offre = "<?php echo $id_offre; ?>";
				var id_contact = '<?php echo $offre['mandant_id']; ?>';
				var tache = $("#type_tache").val();
				var date = $("#date_start_tache").val();
				var commentaire = $("#comm_tache").val();
				var start = $("#time_start_tache").val();
				var end = $("#time_end_tache").val();
				var visiteur_id = $("#visiteur_id").val();
				var visiteur = $("#visiteur").val();
				var status = $("#status").val();
				$.ajax({ 
					type: "POST",
					url: "../tache/ajouter_tache.php",
					data: "id_offre="+id_offre+"&id_contact="+id_contact+"&tache="+tache+"&date="+date+"&start="+start+"&end="+end+"&visiteur_id="+visiteur_id+"&visiteur="+visiteur+"&status="+status+"&comm="+commentaire,
					success:function(data)
					{
						if(data == "erreur")
						{
							alert("erreur");
						}
						else
						{
							var nbre_tache = $('.result > p').length / 2;
							if(nbre_tache < 12)
							{
								$('.result').append("<p onClick=\"rappel_tache("+data+");\">"+tache+"</p>");
							}
							else
							{
								$('.result:last').append("<p>"+tache+"</p>");
							}
						}
					}
				});
	
				reset_tache();
				
			}
		
		}
		
		function rappel_tache(id)
		{
			reset_tache();
			
			$.getJSON("../tache/rappel_tache.php",
			{id_tache: id},
			function(data){
				$("#type_tache").val(data[0].type_tache).attr("selected", "selected");
				if(data[0].type_tache == "Visite" || data[0].type_tache =="Proposé non visité" || data[0].type_tache =="Appel téléphonique" )
				{
					$("#visite").css("display", "block");
				}
				else
				{
					$("#visite").css("display", "none");
				}
				
				if(data[0].date_start_tache != null)
				{
					$("#date_start_tache").val(data[0].date_start_tache);
				}
				if(data[0].comm_tache != "")
				{
					$("#comm_tache").val(data[0].comm_tache);
				}
				if(data[0].visiteur_id != 0)
				{
					$("#visiteur_id").val(data[0].visiteur_id);
				}
				if(data[0].visiteur != "")
				{
					$("#visiteur").val(data[0].visiteur);
				}
				if(data[0].time_start_tache != "00:00")
				{
					$("#time_start_tache").val(data[0].time_start_tache);
				}
				if(data[0].time_end_tache != "00:00")
				{
					$("#time_end_tache").val(data[0].time_end_tache);
				}
				$("#status").val(data[0].status).attr("selected", "selected");
				
				$("#bouton_tache").val("Modifier tache");
				document.getElementById('bouton_tache').onclick = function(){ modifier_tache(id); };
				
				});
		}
	
		function modifier_tache(id)
		{
			var id_offre = "<?php echo $id_offre; ?>";
			var id_contact = '<?php echo $offre['mandant_id']; ?>';
			var tache = $("#type_tache").val();
			var date = $("#date_start_tache").val();
			var commentaire = $("#comm_tache").val();
			var start = $("#time_start_tache").val();
			var end = $("#time_end_tache").val();
			var visiteur_id = $("#visiteur_id").val();
			var visiteur = $("#visiteur").val();
			var status = $("#status").val();
				
				$.ajax({ 
					type: "POST",
					url: "../tache/modifier_tache.php",
					data: "id_offre="+id_offre+"&id_contact="+id_contact+"&tache="+tache+"&date="+date+"&start="+start+"&end="+end+"&visiteur_id="+visiteur_id+"&visiteur="+visiteur+"&status="+status+"&comm="+commentaire+"&id_tache="+id,
					success:function(data)		
					{ 
						if(data != '')
						{
							alert(data);
						}
						else
						{
							reset_tache();
						}
					}	
				});
		}
		
		function supprimer_tache(id)
		{
			$.ajax({
				type: "POST",
				url: "../tache/supprimer_tache.php",
				data: "id_tache="+id,
				success:function(data)
				{ 
					if(data != '')
					{
						alert(data);
					}
					else
					{
						$('#tache'+id).hide();
						reset_tache();
						
					}
				}
			});
		}
		
		function format(date)
		{
			a=date.split('/');
			date = a[2]+"-"+a[1]+"-"+a[0];
			return date;
		}
				
		function rapport()
		{
			var debut = $("#debut_rapport").val();
			var fin = $("#fin_rapport").val();
			var id_offre = "<?php echo $id_offre; ?>";
			
			if(debut !="" && debut !="Date de départ du rapport" && fin !="" && fin != "Date de fin du rapport")
			{
				debut = format(debut);
				fin = format(fin);
				
				 document.location.href="../fiches/rapport_activite.php?id="+id_offre+"&debut="+debut+"&fin="+fin;
				
			}
			else
			{
				alert("Veuillez choisir une date.");
			}
		}

		function genererDocument(){
			var id_modele = $("#select_modele").val();
			var id_offre = "<?php echo $id_offre; ?>";
			/*var conditions = " WHERE offre.id_contact_mandant = contact.id_contact"
			 + " AND offre.id_contact_proprietaire = contact.id_contact";*/
			$.ajax({
				type: "POST",
				url: "charge_modele.php",
				data: "id_modele="+id_modele+"&id_offre="+id_offre,
				success: function(){ alert("Youpy"); }
			});
		}

		function openDocument(id_document){
			$("#document_content_parent").css( "display", "block" ); // Affiche textarea
			
			$.getJSON("infosDocument.php",
				{ id_document: id_document },
				function(data){
					//$("#nom_modele").val(data[0].libelle_document);
					$("#id_document").val(data[0].id_document);
					tinyMCE.get('document_content').setContent(data[0].texte_document);
				}
			);
		}

		function editDocument(){			
			var id_document = $("#id_document").val();
			var texte_document = tinyMCE.get('document_content').getContent();
			
			var data = {
				id_document: id_document,
				texte_document: texte_document
			}; // Passage par un objet pour echapper html
			
			$.ajax({
				type: "POST",
				async: false,
				url: "update_document.php",
				data: data,
				success: function(){ alert("Héhi hého, on rentre du boulot !"); }
			});
		}
		
		function refreshDocs(){
			$("#document_content_parent").css( "display", "none" ); // Masque textarea
			$("#table_liste_documents tr:not(:first)").remove(); // Supprime éléments en cours sauf titres
			
			$.getJSON(
				"liste_documents.php",
				function(data){
					if (data == ""){
						$("#table_liste_documents").append("<tr><td>Il n'y a aucun document</td></tr>");
					}
					else{
						$.each(data, function(i, value){
							var numLine = i + 1;
							$("#table_liste_documents").append(
							  "<tr id='T1line"+numLine+"'>"
								  +"<td>"+value.libelle_document+"</td>"
								  +"<td>"+value.id_document+"</td>"
								  +"<td>"+value.date_creation+"</td>"
								  +"<td class='center'><a href='createPDF.php?id="+value.id_document+"' target='_blank'><img id='logoPdf' src='../images/pdf.png' title='Ouvrir' /></a></td>"
								  +"<td><a onclick='openDocument("+value.id_document+")'>Editer</a></td>"
							  +"</tr>"
							);
						});
						styleTableau();
					}
				}
			);
		}
	</script>
	
	<title>Offre</title>
</head>

<body>

<div id="onglet">
	<ul id="navlist">
		<li><a href="#generalite">Généralités</a></li>
		<li><a href="#situation">Situation/Description</a></li>
		<li><a href="#location">Location</a></li>
		<li><a href="#vente">Vente</a></li>
		<li><a href="#honoraire">Honoraire</a></li>
		<li><a href="#photo">Photo</a></li>
		<?php
			if(isset($id_offre))
			{
				echo '<li><a href="#action">Actions</a></li>';
			}
		?>
		<li><a href="#documents" onclick="refreshDocs()">Documents</a></li>
	</ul>
</div>

<form method="post" action="<?php if(isset($id_offre)){echo "modifier_offre.php";}else{echo "ajouter_offre.php";}?>" enctype="multipart/form-data">
<?php
	echo "<input type=\"hidden\" id=\"id_offre\" name=\"id_offre\" value=\"".$offre['id_offre']."\">";
?>

<div id="generalite" class="tabContent">
	<div class="gauche">
		<fieldset>
			<legend>Information</legend>
			<p>
				<input type="hidden" value="<?php if(isset($offre['id_utilisateur'])){echo $offre['id_utilisateur'];}else{echo $_SESSION['id']; }?>" name="id_utilisateur" id="id_utilisateur"/>
				<label for="suivi">Suivi par: </label>
				<input type="text" id="suivi" name="suivi" maxlength="50" value="<?php if(isset($offre['suivi'])){echo $offre['suivi'];}else{echo $_SESSION['nom']; }?>" />
			</p>
			<p>
				<label for="mandant">Une offre de: </label>
				<input type="text" id="mandant" name="mandant" maxlength="50" value="<?php echo $offre['mandant'];?>" />
				<input type="hidden" id="mandant_id" name="mandant_id" value="<?php echo $offre['mandant_id'];?>" />
			</p>
			<p>
				<label for="proprietaire">Propriétaire: </label>
				<input type="text" id="proprietaire" name="proprietaire" maxlength="50" value="<?php echo $offre['proprietaire'];?>" />
				<input type="hidden" id="proprietaire_id" name="proprietaire_id" value="<?php echo $offre['proprietaire_id'];?>" />
			</p>
			<p>
				<label for="classement">Catégorie de l'offre: </label>
				<select id="classement" name="classement">
					<option value="A" <?php if($offre['classement'] == 'A'){echo "selected=selected";} ?>>A</option>
					<option value="B" <?php if($offre['classement'] == 'B'){echo "selected=selected";} ?>>B</option>
					<option value="C" <?php if($offre['classement'] == 'C'){echo "selected=selected";} ?>>C</option>
				</select>
			</p>
			<p>
				<label for="type_offre">Type de l'offre:</label>
				<select id="type_offre" name="type_offre">
					<?php 
					if(!isset($offre['type_offre'])){
						?>
						<option value="">Choisir le type de l'offre</option>
						<?php 
					}
					?>
					<option value="bureau" <?php if($offre['type_offre'] == 'bureau'){echo "selected=selected";} ?>>Bureau</option>
					<option value="commerce" <?php if($offre['type_offre'] == 'commerce'){echo "selected=selected";} ?>>Commerce</option>
					<option value="locaux d'activités" <?php if($offre['type_offre'] == 'locaux d\activités'){echo "selected=selected";} ?>>Locaux d'activités</option>
					<option value="terrains"<?php if($offre['type_offre'] == 'terrains'){echo "selected=selected";} ?>>Terrains</option>
					<option value="entrepot" <?php if($offre['type_offre'] == 'entrepot'){echo "selected=selected";} ?>>Entrepot</option>
				</select>
			</p>
			<p>
				<label for="type_transaction">Type de la transaction</label>
				<select id="type_transaction" name="type_transaction">
					<?php 
					if(!isset($offre['type_offre'])){
						?>
						<option value="">Choisir le type de la transaction</option>
						<?php 
					}
					?>
					<option value="droit au bail" <?php if($offre['type_transaction'] == 'droit au bail'){echo "selected=selected";} ?>>Droit au bail</option>
					<option value="cession FDC" <?php if($offre['type_transaction'] == 'cession FDC'){echo "selected=selected";} ?>>Cession FDC</option>
					<option value="location pure" <?php if($offre['type_transaction'] == 'location pure'){echo "selected=selected";} ?>>Location Pure</option>
					<option value="vente" <?php if($offre['type_transaction'] == 'vente'){echo "selected=selected";} ?>>Vente</option>
				</select>
			</p>
		</fieldset>
		<fieldset>			
			<legend>Commentaire</legend>
			<p>
				<textarea id="generalite_comm" name="generalite_comm" rows="8" cols="55"><?php echo $offre['generalite_comm'];?></textarea>
			</p>
		</fieldset>
		<fieldset>
			<legend>Moyens de visite</legend>
			<p>
				<textarea id="moyens_de_visite" name="moyens_de_visite" rows="8" cols="55"><?php echo $offre['moyens_de_visite'];?></textarea>
			</p>
		</fieldset>
		
	</div>

	<div class="droite">
	<fieldset>
			<legend>A louer/ A vendre</legend>
			<p>
				<label for="louer_vendre">Louer/vente: </label>
				<select id="louer_vendre" name="louer_vendre">
					<option value="">non précisé</option>
					<option value="A louer" <?php if($offre['louer_vendre'] == 'A louer'){echo "selected=selected";} ?>>A Louer</option>
					<option value="A vendre" <?php if($offre['louer_vendre'] == 'A vendre'){echo "selected=selected";} ?>>A Vendre</option>
					<option value="A louer ou a vendre" <?php if($offre['louer_vendre'] == 'A louer ou a vendre'){echo "selected=selected";} ?>>A Louer ou A Vendre</option>
					<option value="Droit au bail à céder" <?php if($offre['louer_vendre'] == 'Droit au bail à céder'){echo "selected=selected";} ?>>Droit au bail à céder </option>
					<option value="Fond de commerce à céder" <?php if($offre['louer_vendre'] == 'Fond de commerce à céder'){echo "selected=selected";} ?>>Fond de commerce à céder</option>
				</select>	
			</p>

			<p>
				<label for="locaux">Vide ou Loué: </label>
				<select id="locaux" name="locaux">
					<option value="">Non précisé</option>
					<option value="vide" <?php if($offre['locaux'] == 'vide'){echo "selected=selected";} ?>>Vide</option>
					<option value="Loué" <?php if($offre['locaux'] == 'Loué'){echo "selected=selected";} ?>>Loué</option>
				</select>
			</p>
	</fieldset>
	<fieldset id="surface">
		<legend>Surface</legend>
		
		
		<!-- hidden qui permet le comptage du nbre de ligne pour les surfaces pour le traitement php ultérieur -->
		<input type="hidden" id="nbre_surface" name="nbre_surface" value ="<?php if(isset($nbre_surface)){ echo $nbre_surface;}else{echo "0";}?>" />
		<fieldset class="surface">
			<?php 
				$i = 1;
				if(isset($nbre_surface))
				{
					
					while ($donnees = mysql_fetch_array($surface))
					{
						echo '<p id="'.$i.'" onclick="duclication(this.id)">
								<select id="type_'.$i.'" name="type_'.$i.'">
									<option value="">Type de produit</option>';
						$requete = "SELECT * FROM typedeproduit";
								$return = mysql_query($requete);
								while ($type = mysql_fetch_array($return))
								{
									if ($donnees['type'] == $type['typedeproduit'])
									{
										echo "<option value=\"".$type['typedeproduit']."\" selected=\"selected\">".$type['typedeproduit']."</option>";
									}
									else
									{
										echo "<option value=\"".$type['typedeproduit']."\">".$type['typedeproduit']."</option>";
									}
								}
						echo '</select> <input type="text" id="repere_'.$i.'" name="repere_'.$i.'" value="'.$donnees['repere'].'" maxlength="50"><input type="text" id="surface_'.$i.'" name="surface_'.$i.'" value="'.$donnees['surface'].'" maxlength="10" onchange="surfacetotal()"><input type="text" id="comm_surface_'.$i.'" name="comm_surface_'.$i.'" value="'.$donnees['commentaire'].'" maxlength="150"></p>';
						$i++;
					}
				}
			?>
		
		<p id="<?php echo $i;?>" onclick="duplication(this.id)">
			
					<select id="type_<?php echo $i;?>" name="type_<?php echo $i;?>">
							<option value="">Type de produit</option>
							<?php
								$requete = "SELECT * FROM typedeproduit";
								$return = mysql_query($requete);
								while ($type = mysql_fetch_array($return))
								{
									echo "<option value=\"".$type['typedeproduit']."\">".$type['typedeproduit']."</option>";
								}
							?>
						</select>
						<input type="text" id="repere_<?php echo $i;?>" name="repere_<?php echo $i;?>" value="Repere" maxlength="50" onfocus="if (this.value=='Repere') {this.value=''}" />
						<input type="text" id="surface_<?php echo $i;?>" name="surface_<?php echo $i;?>" value="Surface m²" maxlength="10" onchange="surfacetotal()" onfocus="if (this.value=='Surface m²') {this.value=''}" />
						<input type="text" id="comm_surface_<?php echo $i;?>" name="comm_surface_<?php echo $i;?>" value="commentaire" maxlength="150" onfocus="if (this.value=='commentaire') {this.value=''}" />

		</p>
		</fieldset>		
		
		<p id="sous_surface"><label for="surface_total">Surface Total: </label><input type="text" id="surface_total" name="surface_total" value="<?php if(isset($offre['surface_total'])){ echo $offre['surface_total'];}else{echo "0";}?>" readonly="readonly" /></p>
		<p><label for="divisible">Surface divisible: </label><input type="checkbox" id="divisible" name="divisible" value="1" <?php if($offre['divisible']==1){echo 'checked="checked"';} ?> /></p>
	</fieldset>
	
	</div>
</div>

<div id="situation" class="tabContent">
	<div class="gauche">
	<fieldset>
		<legend>Situation: </legend>
		<p>
			<label for="zone_activite">Zone d'activité</label>
			<input type="text" id="zone_activite" name="zone_activite" value="<?php echo $offre['zone_activite']?>" maxlength="50" />
		</p>
		<p>
			<label for="secteur_geo">Secteur géographique</label>
			<input type="text" id="secteur_geo" name="secteur_geo" maxlength="50" value="<?php echo $offre['secteur_geo']?>" />
		</p>
		<p>
			<label for="adresse">Adresse:</label>		
			<input type="text" name="adresse" id="adresse" value="<?php echo $offre['adresse']; ?>" maxlength="32"/>
		</p>
		<p>
			<label for="suite">Suite:</label>		
			<input type="text" name="suite" id="suite" value="<?php echo $offre['suite']; ?>" maxlength="32"/>
		</p>
		
		<p>
			<!-- Appelle de la fonction afficheVille pour vérification et affichage de la ville correspondante -->
			<label for="cp">Code postal:</label>		
			<input type="text" value="<?php echo $offre['code_postal']; ?>" name="cp" id="cp" maxlength="5" size="5" onkeyup="afficheVille(this.size, this.value)" />
		</p>
		
		<p>
			<!-- Appelle de la fonction afficheCp pour vérification et affichage du code postal correspondante -->
			
			<label for="ville">Ville</label> 		
			<input type="text" name="ville" id="ville" maxlength="26" value="<?php echo $offre['ville']; ?>" onchange="afficheCp(this.value)"/>
		</p>
		
		<p><label for="pays">Pays:</label> 		
			<select name="pays" id="pays" tabindex="1">
				<option value="france">France</option>
			</select>
		</p>

		<p>
			<label for="qualite_emplacement">Qualité de l'emplacement:</label>
			<select id="qualite_emplacement" name="qualite_emplacement">
				<option value="non precise" <?php if($offre['qualite_emplacement'] == "non precise"){echo("selected=\"selected\"");} ?>>Non Précisé</option>
				<option value="exceptionelle" <?php if($offre['qualite_emplacement'] == "exceptionelle"){echo("selected=\"selected\"");} ?>>Exceptionnel</option>
				<option value="excellent" <?php if($offre['qualite_emplacement'] == "excellent"){echo("selected=\"selected\"");} ?>>Excellent</option>
				<option value="très bon" <?php if($offre['qualite_emplacement'] == "très bon"){echo("selected=\"selected\"");} ?>>Très Bon</option>
				<option value="moyen" <?php if($offre['qualite_emplacement'] == "moyen"){echo("selected=\"selected\"");} ?>>Moyen</option>
				<option value="bon" <?php if($offre['qualite_emplacement'] == "bon"){echo("selected=\"selected\"");} ?>>Bon</option>
			</select>
			
		</p>
	</fieldset>
	
	<fieldset>
		<legend>Description</legend>
			<fieldset>
				<legend>Descriptif: </legend>
				<textarea id="descriptif" name="descriptif" rows="10" cols="55"><?php echo $offre['descriptif'];?></textarea>
			</fieldset>
	</fieldset>
	
	</div>
	<div class="gauche">
		<fieldset>
			<legend>Description</legend>
			<fieldset>
				<legend>Equipement: </legend>
				<textarea id="equipement" name="equipement" rows="17" cols="55"><?php echo $offre['equipement']; ?></textarea>
			</fieldset>
			
			<fieldset>
				<legend>Divers</legend>
			
			<p>
				<label for="etat">Etat:</label>
				<select id="etat" name="etat">
					<option value="">Choisir l'état du batiment</option>
					<?php
						$requete = "SELECT etat FROM etat_offre";
						$return =@ mysql_query($requete);
						while($etat = mysql_fetch_array($return))
						{
							if($offre['etat'] == $etat['etat'])
							{
								echo '<option value="'.$etat['etat'].'" selected=selected>'.$etat['etat'].'</option>';
							}
							else
							{
								echo '<option value="'.$etat['etat'].'">'.$etat['etat'].'</option>';
							}
							
						}
					?>
				</select>
			</p>
			<p>
				<label for="standing">Standing: </label>
				<select id="standing" name="standing">
					<option value="">Choisir le standing</option>
					<?php
						$requete = "SELECT standing FROM standing_offre";
						$return =@ mysql_query($requete);
						while($standing = mysql_fetch_array($return))
						{
							if($offre['standing'] == $standing['standing'])
							{
								echo '<option value="'.$standing['standing'].'" selected=selected>'.$standing['standing'].'</option>';
							}
							else
							{
								echo '<option value="'.$standing['standing'].'">'.$standing['standing'].'</option>';
							}
							
						}
					?>
				</select>
			</p>
			<p>
				<label for="acces">Accés: </label>
				<input id="acces" name="acces" type="text" value="<?php echo $offre['acces']; ?>" maxlength="150" />
			</p>
			<p>
				<label for="desserte">Desserte: </label>
				<input type="text" id="desserte" name="desserte" value="<?php echo $offre['desserte']; ?>" maxlength="150" />
			</p>
			</fieldset>
		</fieldset>
	</div>
</div>

<div id="location" class="tabContent">
	<div class="gauche">
		<fieldset>
			<legend>Information Bail</legend>
			<p>
				<label for="date_bail">Date du début du bail: </label>
				<input type="text" id="date_bail" name="date_bail" maxlength="25" value="<?php if(isset($offre['date_bail'])){if($offre['date_bail'] == "0000-00-00"){echo "";}else{ echo(date2fr($offre['date_bail']));}}?>" />
			</p>
			
			<p>
				<label for="regime_fiscal">Régime fiscal: </label>
				<select id="regime_fiscal" name="regime_fiscal">
					<option value="">Choisir le régime de location</option>
					<?php
						$requete = "SELECT * FROM regimedelocation";
						$return =@ mysql_query($requete);
						while ($select = mysql_fetch_array($return))
						{
							if($offre['regime_fiscal'] == $select['regimedelocation'])
							{
								echo '<option value="'.$select['regimedelocation'].'" selected=selected>'.$select['regimedelocation'].'</option>';
							}
							else
							{
								echo '<option value="'.$select['regimedelocation'].'">'.$select['regimedelocation'].'</option>';
							}	
							
							
						}
					?>
				</select>
			</p>
			<p>
				<label for="type_bail">Type de bail: </label>
				<select id="type_bail" name="type_bail">
					<option value="">Choisir le type de bail</option>
					<?php
						$requete = "SELECT * FROM typedebail";
						$return =@ mysql_query($requete);
						while ($select = mysql_fetch_array($return))
						{
							if($offre['type_bail'] == $select['typedebail'])
							{
								echo '<option value="'.$select['typedebail'].'" selected="selected" >'.$select['typedebail'].'</option>';
							}
							else
							{
								echo '<option value="'.$select['typedebail'].'">'.$select['typedebail'].'</option>';
							}
							
						}
					?>
				</select>
			</p>
			<p>
				<label for="garantie">Dépot de garantie: </label>
				<select id="garantie" name="garantie">
					<option value="">Choisir le type de dépot de garantie</option>
					<?php
						$requete = "SELECT garantie FROM depotdegarantie";
						$return =@ mysql_query($requete);
						while($select = mysql_fetch_array($return))
						{
							if($offre['garantie'] == $select['garantie'])
							{
								echo '<option value="'.$select['garantie'].'" selected=selected>'.$select['garantie'].'</option>';							
							}
							{
								echo '<option value="'.$select['garantie'].'">'.$select['garantie'].'</option>';
							}
							
						}
					?>
				</select>
			</p>
		</fieldset>
		
		<fieldset>
			<legend>Notes</legend>
			<textarea id="location_notes" name="location_notes" rows="10" cols="55"><?php echo $offre['location_notes']; ?></textarea>
		</fieldset>
		
		<fieldset>
			<legend>Commentaires</legend>
			<textarea id="location_comm" name="location_comm" rows="10" cols="55"><?php echo $offre['location_comm'];?></textarea>
		</fieldset>
		<fieldset>
			<legend>Document</legend>
			<label for="select_modele">Choix du modèle</label>
			<select id="select_modele">
				<?php
				$queryChoixModele = "SELECT * FROM modele WHERE table_modele = 'view_offre'";
				$resultChoixModele = mysql_query($queryChoixModele);
				
				while ($res = mysql_fetch_array($resultChoixModele)){
					?>
					<option value="<?php echo $res['id_modele']; ?>"><?php echo $res['nom_modele']; ?></option>
					<?php
				}
				?>
			</select>
			<input type="button" value="Générer" onclick="genererDocument()" />
		</fieldset>
	</div>
	
	<div class="droite">
	<fieldset>
		<legend>Local</legend>
		<p>
			<label for="date_dispo_location">Date de disponibilité: </label>
			<input type="text" id="date_dispo_location" name="date_dispo_location" maxlength="10" value="<?php if(isset($offre['date_dispo_location'])){if($offre['date_dispo_location'] == "0000-00-00"){echo "";}else{ echo(date2fr($offre['date_dispo_location']));}}?>" />
		</p>
		<p>
			<label for="duree">Durée: </label>
			<input type="text" id="duree" name="duree" maxlength="25" value="<?php echo $offre['duree']; ?>" />
		</p>
		<p>
			<label for="loue_par">Loué par: </label>
			<input type="text" id="loue_par" name="loue_par" maxlength="50" value="<?php echo $offre['loue_par']; ?>" />
			<input type="hidden" id="loue_par_id" name="loue_par_id" value="<?php echo $offre['loue_par_id'];?>" />
		</p>
		<p>
			<label for="pas_de_porte">Prix du pas de porte: </label>
			<input type="text" id="pas_de_porte" name="pas_de_porte" maxlength="15" value="<?php echo $offre['pas_de_porte']; ?>" />
		</p>
	</fieldset>
	
	<fieldset>
		<legend>Loyer</legend>
		<p>
			<label for="loyer_annuel">Loyer annuel HC et HT: </label>
			<input type="text" id="loyer_annuel" name="loyer_annuel" maxlength="15" onchange="loyer(this.value);" value="<?php echo $offre['loyer_annuel']; ?>" />
		</p>
		<p>
			<label for="provision_location" style="font-size: 14px;">Provisions pour charges </label>
			<input type="text" id="provision_location" name="provision_location" maxlength="15" value="<?php echo $offre['provision_location']; ?>" />
		</p>
		<p>
			<label for="paiement">Modes de paiement: </label>
			<select id="paiement" name="paiement">
				<option value="">Choisir le mode de paiement</option>
				<?php
					$requete = "SELECT modedepaiement FROM modedepaiement";
					$return =@ mysql_query($requete);
					while($select = mysql_fetch_array($return))
					{
						$mode = $select['modedepaiement'];
						if($offre['paiement'] == $mode)
						{
							echo '<option value="'.$mode.'" selected=selected>'.$mode.'</option>';
						}
						else
						{
							echo '<option value="'.$mode.'">'.$mode.'</option>';
						}
						
					}
				?>
			</select>
		</p>
		<p>
			<label for="loyer_mensuel">Loyer mensuel HT: </label>
			<input type="text" id="loyer_mensuel" name="loyer_mensuel" maxlength="15" value="<?php echo $offre['loyer_mensuel']; ?>" />
		</p>
		<p>
			<label for="loyer_m2">Loyer au m²: </label>
			<input type="text" id="loyer_m2" name="loyer_m2" maxlength="15" value="<?php echo $offre['loyer_m2']; ?>" />
		</p>
	</fieldset>
	
	<fieldset>
		<legend>Taxes</legend>
		<p>
			<label for="impot_foncier">Impot Foncier: </label>
			<input type="text" id="impot_foncier" name="impot_foncier" maxlength="15" value="<?php if(isset($offre['impot_foncier'])){echo $offre['impot_foncier']."€";} else{ echo "0€";} ?>" readonly="readonly" />
		</p>
		<p>
			<label for="impot_locataire">A charge du locataire: </label>
			<input type="text" id="impot_locataire" name="impot_locataire" maxlength="15" value="<?php if(isset($offre['impot_locataire'])){echo $offre['impot_locataire']."€";} else{ echo "0€";} ?>" onchange="impot()" />
		</p>
		<p>
			<label for="impot_proprio" style="font-size: 13px;">A charge du propriétaire: </label>
			<input type="text" id="impot_proprio" name="impot_proprio" maxlength="15" value="<?php if(isset($offre['impot_proprio'])){echo $offre['impot_proprio']."€";} else{ echo "0€";} ?>" onchange="impot()" />
		</p>
		<p>
			<label for="autres_taxes">Autres Taxes: </label>
			<input type="text" id="autres_taxes" name="autres_taxes" maxlength="15" value="<?php echo $offre['autres_taxes']; ?>" />
		</p>
	</fieldset>
	</div>
</div>

<div id="vente" class="tabContent">
	<div class="gauche">
		<fieldset>
			<legend>Notes</legend>
			<textarea id="notes_vente" name="notes_vente" rows="15" cols="55"><?php echo $offre['notes_vente']; ?></textarea>
		</fieldset>
		<fieldset>
			<legend>Commentaires</legend>
			<textarea id="comm_vente" name="comm_vente" rows="15" cols="55"><?php echo $offre['comm_vente']; ?></textarea>
		</fieldset>
		
	</div>
	<div class="droite">
		<fieldset>
			<legend>Date de disponibilité: </legend>
			<p>
				<label for="date_dispo_vente">Date de disponibilité: </label>
				<input type="text" id="date_dispo_vente" name="date_dispo_vente" maxlength="10" value="<?php if(isset($offre['date_dispo_vente'])){if($offre['date_dispo_vente'] == "0000-00-00"){echo "";}else{ echo(date2fr($offre['date_dispo_vente']));}}?>" />
			</p>
		</fieldset>
		
		<fieldset>
			<legend>Prix</legend>
			<p>
				<label for="prix_murs">Prix de vente des murs</label>
				<input type="text" id="prix_murs" name="prix_murs" maxlength="15" value="<?php echo $offre['prix_murs']; ?>" onchange="prix_metre()" />
			</p>
			<p>
				<label for="tva_murs">TVA: </label>
				<select id="tva_murs" name="tva_murs">
					<option value="TVA" <?php if($offre['tva_murs'] == "TVA"){ echo "selected=selected";} ?>>TVA</option>
					<option value="Hors TVA" <?php if($offre['tva_murs'] == "Hors TVA"){ echo "selected=selected";} ?>>Hors TVA</option>
					<option value="M2 TVA" <?php if($offre['tva_murs'] == "M2 TVA"){ echo "selected=selected";} ?>>m² TVA</option>
					<option value="M2 Hors TVA" <?php if($offre['tva_murs'] == "M2 HORS TVA"){ echo "selected=selected";} ?>>m² Hors TVA</option>
				</select>
			</p>
			<p>
				<label for="prix_fond_commerce" style="font-size: 13px;">Prix du fond de commerce</label>
				<input type="text" id="prix_fond_commerce" name="prix_fond_commerce" maxlength="15" value="<?php echo $offre['prix_fond_commerce']; ?>" />
			</p>
			<p>
				<label for="prix_m2">Prix au m²: </label>
				<input type="text" id="prix_m2" name="prix_m2" maxlength="15" value="<?php echo $offre['prix_m2']; ?>" />
			</p>
			
		</fieldset>
		<fieldset>
			<legend>Charges</legend>
			<p>
				<label for="provision_vente" style="font-size: 12px;">Provisions pour charges: </label>
				<input type="text" id="provision_vente" name="provision_vente" maxlength="15" value="<?php echo $offre['provision_vente']; ?>" />
			</p>
			<p>
				<label for="impot_foncier_vente">Impôt Foncier:</label>
				<input type="text" id="impot_foncier_vente" name="impot_foncier_vente" maxlength="15" value="<?php echo $offre['impot_foncier_vente']; ?>" />
			</p>
			<p>
				<label for="autres_taxes_vente">Autres taxes:</label>
				<input type="text" id="autres_taxes_vente" name="autres_taxes_vente" maxlength="15" value="<?php echo $offre['autres_taxes_vente']; ?>" />
			</p>
		</fieldset>
	
	</div>

</div>

<div id="honoraire" class="tabContent">
	<div class="gauche">
	<fieldset>
		<legend>Location</legend>
	<fieldset>
		<legend>honoraires de transaction</legend>
		<textarea id="hono_trans_location" name="hono_trans_location" rows="8" cols="55"><?php echo $offre['hono_trans_location']; ?></textarea>
	</fieldset>
	<fieldset>
		<legend>honoraires de rédaction des actes</legend>
		<textarea id="hono_redac_location" name="hono_redac_location" rows="8" cols="55"><?php echo $offre['hono_redac_location']; ?></textarea>
	</fieldset>
	<fieldset>
		<legend>Montant des honoraires</legend>
		<textarea id="hono_total_location" name="hono_total_location" rows="8" cols="55"><?php echo $offre['hono_total_location']; ?></textarea>
	</fieldset>
	</fieldset>
	
	</div>
	<div class="droite">
	<fieldset>
		<legend>Vente</legend>
	<fieldset>
		<legend>honoraires de transaction</legend>
		<textarea id="hono_trans_vente" name="hono_trans_vente" rows="8" cols="55"><?php echo $offre['hono_trans_vente']; ?></textarea>
	</fieldset>
	<fieldset>
		<legend>honoraires de rédaction des actes</legend>
		<textarea id="hono_redac_vente" name="hono_redac_vente" rows="8" cols="55"><?php echo $offre['hono_redac_vente']; ?></textarea>
	</fieldset>
	<fieldset>
		<legend>Montant des honoraires</legend>
		<textarea id="hono_total_vente" name="hono_total_vente" rows="8" cols="55"><?php echo $offre['hono_total_vente']; ?></textarea>
	</fieldset>
	</fieldset>
	</div>

</div>

<div id="photo" class="tabContent surface">
	<fieldset id="photographie">
		<legend>Photo</legend>
		<input type="hidden" id="nbre_photo" name="nbre_photo" value="<?php if(isset($nbre_photo)){ echo $nbre_photo;}else{ echo "0";} ?>" />
		<input type="hidden" id="nbre_photo_upload" name="nbre_photo_upload" value="<?php echo $nbre_photo;?>" />
		<?php
			if(isset($nbre_photo))
			{
				$i = 1;
				while ($donnees = mysql_fetch_array($photo))
				{
					echo '<p id="paraphoto'.$i.'"><label for="photo'.$i.'">Photographie n°'.$i.'</label>
					<a href="/photo/'.$donnees['nom_photo'].'" rel="shadowbox"><input type="button" value="Afficher" id="photo'.$i.'" name="photo'.$i.'"></a>
					<input type="button" value="Supprimer" onclick="supprimer_photo(\'paraphoto'.$i.'\', \''.$donnees['id_photo'].'\');"></p>';
					$i++;
					
				}
			}
		?>
		
		<p>
			<label for="photo1">Photographie n°<?php if(isset($nbre_photo)){ echo $i;}else{echo "1";} ?></label>
			<input type="file" value="" id="photo<?php if(isset($nbre_photo)){ echo $i;}else{echo "1";} ?>" name="photo<?php if(isset($nbre_photo)){ echo $i;}else{echo "1";} ?>" onclick="duplication_photo();" onchange="verif_extension(this.value, this.id);" />
			
		</p>
		
	</fieldset>
</div>

<div id="action"  <?php if(!isset($id_offre)){ echo "style=\"display:none\"";} ?> class="tabContent">
	<fieldset class="surface" id="form_action">
		<legend>Ajouter une nouvelle tache</legend>
		<p>
		<select id="type_tache" name="type_tache" onchange="visite(this.value);">
			<option value="">Type de Tache</option>
			<?php
				$requete = "SELECT tache FROM typedetache";
				$return = mysql_query($requete);
				while($donnees = mysql_fetch_array($return))
				{
					echo '<option value="'.$donnees['tache'].'">'.$donnees['tache'].'</option>';
				}
			?>
		</select>
		<input type="text" value="Date de l'évenement" id="date_start_tache"/>
		<input type="text" value="Commentaire" id="comm_tache" name="comm_tache" onfocus="if (this.value=='Commentaire') {this.value=''}"/>
		<input type="hidden" value="" id="visiteur_id" name="visiteur_id" />
		<input type="text" value="Contact" id="visiteur" name="visiteur" onfocus="if (this.value=='Contact') {this.value=''}" />
		
		</p>
		<p style="display:none;" id="visite">
		<input type="text" value="heure de commencement" id="time_start_tache" class="time"/>
		<input type="text" value="heure de fin" id="time_end_tache" class="time"/>
		<select id="status" name="status">
			<option value="">Status de la visite</option>
			<?php
				$requete = "SELECT status FROM statusTache";
				$return = mysql_query($requete);
				while($donnees = mysql_fetch_array($return))
				{
					echo '<option value="'.$donnees['status'].'">'.$donnees['status'].'</option>';
				}
			?>
		</select>
		
		</p>
		<p>
			<input type="button" id="bouton_tache" value="Nouvelle Tache" onclick="ajouter_tache();"/>
		</p>
		
		
		
	</fieldset>
	
	<fieldset>
	<legend>Taches Enregistrées</legend>
	<br style="clear:both;" />
		<div id="Searchresult">
			This content will be replaced when pagination inits.
		</div>
	
	<div id="hiddenresult" style="display:none;">
        <?php        	
        	$requete = "SELECT tache.tache, tache.date, tache.id_tache, contact.civilite, contact.nom_contact 
        				FROM tache
        				LEFT OUTER JOIN contact ON tache.id_visiteur = contact.id_contact
        				WHERE tache.id_offre='$id_offre'
        				ORDER BY tache.date";
        	$return = mysql_query($requete);
        	echo '<div class="result">';
        	$i = 0;
        	while($donnees = mysql_fetch_array($return))
        	{
        	
        	
        	if( $i != 0 && $i % 10 == 0){
        			echo '</div><div class="result">';}
        		echo '<div id="tache'.$donnees['id_tache'].'"><p onclick="rappel_tache('.$donnees['id_tache'].');">'.$donnees['tache']." le "."   ".date2fr($donnees['date'])." ".$donnees['civilite']." ".$donnees['nom_contact'].'<span style= "float:right" onclick="supprimer_tache('.$donnees['id_tache'].');">Supprimer</span></p></div>'; $i++;
  			}
        	echo '</div>';
     	?>
        
        
        
        </div>
      </fieldset>
        <div id="Pagination" class="pagination">
        </div>
        
        <div class="surface">
			<p>
			<input type="text" id="debut_rapport" name="debut_rapport" value="Date de départ du rapport"/>
			<input type="text" id="fin_rapport" name="fin_rapport" value="Date de fin du rapport"/>
			<input type="button" onclick="rapport();" value="Rapport d'activité"/>
			</p>
		</div>
</div>

<div id="documents" class="tabContent">
	<fieldset>
		<legend>Liste des docs.</legend>
		<table id="table_liste_documents">
			<tr>
				<th>Titre</th>
				<th>Numéro</th>
				<th>Date création</th>
				<th>PDF</th>
				<th>Edition</th>
			</tr>
		</table>
		
		<textarea style="width: 100%;" name="content" id="document_content" ></textarea>
		
		<input type="hidden" id="id_document" value="" />
		<input type="button" value="Enregistrer" onclick="editDocument()" />
	</fieldset>
</div>

<div id="footer">
	<input type="submit" id="btSubmit" value="<?php if(isset($id_offre)){echo "Modifier l'offre";}else{echo "Ajouter l'offre";}?>"/>
</div>
</form>
</body>
</html>