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

<!-- Double déclaration ! A enlever -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>Ajouter un contact</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../include/contact.css" rel="stylesheet" type="text/css" media="screen"/>
<link rel="stylesheet" type="text/css" href="../include/shadowbox/shadowbox.css" />
<?php
	include("../include/connex.inc.php");
?>

<script type="text/javascript" src="../include/jquery.js"></script>
<script type="text/javascript" src="../include/shadowbox/shadowbox.js"></script>

<script type="text/javascript">
Shadowbox.init({
    language:   "en",
    players:    ["html", "iframe", "img"]
})

</script>

<!-- script pour la gestion des onglets -->

<script type="text/javascript">
$(document).ready(function(){
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

    /* ***** DESGIN FIELDSET ***** */
    var actif;
    var childrenFieldset;
    var champsFocus;
    var parentFocus;
    // Design focus
    $("fieldset").mouseover(function(){
    	$(this).css("border-color", "green");
		
   		$("#" + $(this).attr("id") + " legend").css({
   	   		"font-weight": "bold",
   	   		"border-color": "green"
   		});

		// Changement de fieldset
		if (actif != "#" + $(this).attr("id")){
   			actif = "#" + $(this).attr("id");
		}
    });

	// Retour design base
    $(actif).mouseout(function(){
    	$(actif).css("border-color", "#999");
		
   		$(actif + " legend").css({
   			"font-weight": "",
			"border-color": "#999"
   		});
    });

	// Tableau des input et select enfants de fielset p
    jQuery.each($("fieldset p > input, select, checkbox, textarea"), function(){
    	$("#" + ($(this).attr("id"))).focus(function(){
    		champsFocus = "#" + $(this).attr("id");
			
    		parentFocus = "#" + $(champsFocus).parent("p").parent("fieldset").attr("id");
    		
    		if (actif != parentFocus){
        		//alert("pass");
    			// Retour design base
    	    	$(actif).css("border-color", "#999");
    			
    	   		$(actif + " legend").css({
    	   			"font-weight": "",
    				"border-color": "#999"
    	   		});
    	   		
    	   		actif = "#" + $(this).attr("id");
    	   		
    	   		// Design focus
    	    	$(parentFocus).css("border-color", "green");
    			
    	   		$(parentFocus + " legend").css({
    	   	   		"font-weight": "bold",
    	   	   		"border-color": "green"
    	   		});
    		}
        });
    });
    /* ***** FIN DESIGN FIELSET ***** */
});

</script>

<script type="text/javascript">
	function afficheVille(size, cp) 
	{
    	
    	if (cp.length > size-1) 
    	{
  			$.ajax
  			({ 
				type: "GET", 
				url: "../verif_cp.php?cp="+cp, 
				success:function(data)
				{ 
					if(data==0) 
					{ 
						alert('Aucun resultat, modifier le code postal'); 
					} 
					else if(data==1)
					{ 
						
						Shadowbox.open
						({
	 						player:     "iframe",
	 						content:    '../choix_ville.php?codepostal='+cp,
        					title:      "Code postal disponible pour "+cp,
        					height:     350,
        					width:      350
        				});
					}
					else
					{
						document.getElementById('ville').value = data;
    				}

				} 
			}); 
		}
	}
	
	function afficheCp(ville) 
	{
  		if (ville.length > 1)
  		{
  			$.ajax
  			({ 
				type: "GET", 
				url: "../verif_ville.php?ville="+ville, 
				success:function(data)
				{ 
					if(data==0) 
					{ 
						alert('Aucun resultat, modifier le nom de la ville'); 
					} 
					else if(data==1)
					{ 
						Shadowbox.open
						({
	 						player:     "iframe",
	 						content:    '../choix_cp.php?ville='+ville,
        					title:      "Code postal disponible pour "+ville,
        					height:     350,
        					width:      350
        				});
					}
					else
					{
						document.getElementById('cp').value = data;
    				}

				} 
			}); 
		}
	}

</script>
</head>

<body>
<?php
	//vérification de l'id transmisse ==> choix entre formulaire de nouveau ou de modification de contact
	
	if(isset($_GET['id']))
	{
		$id_contact = $_GET['id'];
		$requete = "SELECT * FROM contact WHERE id_contact = ".$id_contact."";
		$return = mysql_query($requete);
		$donnees = mysql_fetch_array($return);
		
		/*if($_SESSION['agence'] != $donnees['id_agence'])
		{
			echo "<script type=\"text/javascript\"> parent.Shadowbox.close();</script>";
			echo "<script type=\"text/javascript\"> document.location.href=\"../index.php?requete=contact\";</script>";
		}*/
		
		
	}
?>

<div id="onglet">
	<ul id="navlist">
		<li><a href="#first">Info Contact</a></li>
		<li><a href="#autre">Autre</a></li>
		<li id="navlist3"><a href="#creer_document">Creer un document</a></li>
		<!--  id="navlist3" -->
	</ul>
</div>


<form method="post" action="<?php if(isset($id_contact)){ echo "modifier_contact.php";}else{echo "ajouter_contact.php";}?>">
<div class="tabContent" id="first">
	<div class="gauche">
		<fieldset id="fCivilite">
			<?php
				if(isset($id_contact))
				{
					echo "<input type=\"hidden\" id=\"id_contact\" name=\"id_contact\" value=\"".$donnees['id_contact']."\">";
				}
			?>
			
			<input type="hidden" name="id_agence" id="id_agence" value="<?php if(isset($donnees['id_agence'])){echo $donnees['id_agence'];}else{echo $_SESSION['agence']; }?>"/>
			
			<legend>Contact</legend>
			<p>
				<label for="civilite">Civilité:</label>
				<select name="civilite" id="civilite" tabindex="6">
					<option value="">-- Choisir civilité du contact --</option>
					<?php
						$requete = "SELECT * FROM civilite";
						$return =@ mysql_query($requete);
						while ($tab = mysql_fetch_array($return))
						{
							if($donnees['civilite'] == $tab['civilite'])
							{
								echo "<option value=\"".$tab['civilite']."\" selected=\"selected\">".$tab['designation']."</option>";
							}
							else
							{
								echo "<option value=\"".$tab['civilite']."\">".$tab['designation']."</option>";
							}
									
						}
					?>
				</select>
			</p>
						
		<p>
			<label for="nom_contact">Nom:</label>		
			<input type="text" name="nom_contact" id="nom_contact" value="<?php echo $donnees['nom_contact']; ?>" maxlength="40"/>
		</p>
		<p>
			<label for="prenom_contact">Prénom:</label>		
			<input type="text" name="prenom_contact" id="prenom_contact" value="<?php echo $donnees['prenom_contact']; ?>" maxlength="40"/>
		</p>
		<p>
			<label for="adresse">Adresse:</label>		
			<input type="text" name="adresse" id="adresse" value="<?php echo $donnees['adresse']; ?>" maxlength="32"/>
		</p>
		<p>
			<label for="suite">Suite:</label>		
			<input type="text" name="suite" id="suite" value="<?php echo $donnees['suite']; ?>" maxlength="32"/>
		</p>
		
		<p>
			<!-- Appelle de la fonction afficheVille pour vérification et affichage de la ville correspondante -->
			<label for="cp">CP:</label>		
			<input type="text" value="<?php echo $donnees['cp']; ?>" name="cp" id="cp" maxlength="5" size="5" onkeyup="afficheVille(this.size, this.value)" />
		</p>
		
		<p>
			<!-- Appelle de la fonction afficheCp pour vérification et affichage du code postal correspondante -->
			
			<label for="ville">Ville</label> 		
			<input type="text" name="ville" id="ville" maxlength="26" value="<?php echo $donnees['ville']; ?>" onchange="afficheCp(this.value)"/>
		</p>
		
		<p><label for="pays">Pays:</label> 		
			<select name="pays" id="pays" tabindex="1">
				<option value="france">France</option>
			</select>
		</p>
		</fieldset>
		<fieldset id="fSociete">
		<legend>Info Société</legend>
		<p><label for="societe">Société:</label>
		<input type="text" name="societe" id="societe" value="<?php echo $donnees['societe']; ?>" maxlength="40"/></p>
		<p><label for="forme_juridique">Forme Juridique:</label>	
			<select name="forme_juridique" id="forme_juridique" tabindex="6">
								<option value="">-- Choisir la forme de la société -- </option>
								<option value="sa"<?php if($donnees['forme_juridique']=="sa"){ echo 'selected="selected"';}?>>SA</option>
								<option value="sarl" <?php if($donnees['forme_juridique']=="sarl"){ echo 'selected="selected"';}?>>SARL</option>
								<option value="sci" <?php if($donnees['forme_juridique']=="sci"){ echo 'selected="selected"';}?>>SCI</option>
								<option value="scp" <?php if($donnees['forme_juridique']=="scp"){ echo 'selected="selected"';}?>>SCP</option>
								<option value="eurl" <?php if($donnees['forme_juridique']=="eurl"){ echo 'selected="selected"';}?>>EURL</option>
			</select>
		</p>
		<p><label for="capital">Capital:</label> 	
			<input type="text" name="capital" id="capital" value="<?php echo $donnees['capital']; ?>" maxlength="50"/>
		</p>
		<p>
			<label for="siege">Lieu Siège:</label>	
				<input type="text" name="siege" id="siege" value="<?php echo $donnees['siege']; ?>" maxlength="50" />
		</p>
		<p>
			<label for="fonction">Fonction:</label> 	
			<input type="text" name="fonction" id="fonction" value="<?php echo $donnees['fonction']; ?>" maxlength="40" />
		</p>
		</fieldset>
		<fieldset id="fObservation">
		<legend>Observations</legend>
		<p>
			<textarea name="observations" id="observations" rows="5" cols="53"><?php echo $donnees['observations']; ?></textarea>
		</p>
		</fieldset>
	</div>

	<div class="droite">
		<fieldset id="fCoordonnees">
		<legend>Info Coordonnées</legend>
		<p>	
			<label for="telephone">Téléphone:</label>
			<input type="text" name="telephone" id="telephone" value="<?php echo $donnees['telephone']; ?>" maxlength="20"/>
		</p>
		<p>
			<label for="telephone2">Téléphone n°2:</label>	
			<input type="text" name="telephone2" id="telephone2" value="<?php echo $donnees['telephone2']; ?>" maxlength="20"/>
		</p>
		<p>
			<label for="telecopie">Télécopie:</label> 		
			<input type="text" name="telecopie" id="telecopie" value="<?php echo $donnees['telecopie']; ?>" maxlength="20"/>
		</p>
		<p>
			<label for="portable>">N°portable:</label> 		
			<input type="text" name="portable" id="portable" value="<?php echo $donnees['portable']; ?>" maxlength="20"/>
		</p>
		<p>
			<label for="site_web">Site Web:</label>
			<input type="text" name="site_web" id="site_web" value="<?php echo $donnees['site_web']; ?>" maxlength="255"/>
		</p>
		</fieldset>

		<fieldset id="fGroupe">
		<legend>Info groupe du contact</legend>
		<p>
			<label for="investisseur">Investisseur</label>
			<input type="checkbox" name="investisseur" id="investisseur" <?php if($donnees['investisseur']==1){echo 'checked="checked';} ?>   value="1"/>
		</p>
		
		<p>
			<label for="notaire">Notaire</label>
			<input type="checkbox" name="notaire" id="notaire" <?php if($donnees['notaire']==1){echo 'checked="checked';} ?>   value="1"/>
		</p>
		
		<p>
			<label for="prescripteur">Prescripteur</label>
			<input type="checkbox" name="prescripteur" id="prescripteur" <?php if($donnees['prescripteur']==1){echo 'checked="checked';} ?>  value="1"/>
		</p>
		<p>
			<label for="syndic">Syndicat</label>
			<input type="checkbox" name="syndicat" id="syndicat" <?php if($donnees['syndic']==1){echo 'checked="checked';} ?> value="1"/>
		</p>
		<p>
			<label for="autre">Autre</label>
			<input type="checkbox" name="autre" id="autre" <?php if($donnees['autre']==1){echo 'checked="checked';} ?> value="1"/>
		</p>
		<p>	
			<label for="demandeur">Demandeur</label>
			<input type="checkbox" name="demandeur" id="demandeur" <?php if($donnees['demandeur']==1){echo 'checked="checked';} ?> value="1"/>
		</p>
		<p>	
			<label for="confrere">Confrère</label>
			<input type="checkbox" name="confrere" id="confrere" <?php if($donnees['confrere']==1){echo 'checked="checked';} ?> value="1"/>
		</p>
		<p>
			<label for="offreur">Offreur</label>
			<input type="checkbox" name="offreur" id="offreur" <?php if($donnees['offreur']==1){echo 'checked="checked';} ?> value="1"/>
		</p>
		<p>
			<label for="prospect">Prospect</label>
			<input type="checkbox" name="prospect" id="prospect" <?php if($donnees['prospect']==1){echo 'checked="checked';} ?> value="1"/>
		</p>
		</fieldset>
	</div>
</div>
<div class="tabContent" id="autre">
	<fieldset id="fOrigine">
		<legend>Origine du contact</legend>
		<p>
			<label for="origine_contact">Type:</label>
			<select name="origine_contact" id="origine_contact" tabindex="6">
								<option value="">---Choisir le type---</option>
								<?php
									$requete = "SELECT origine_contact FROM origine_contact";
									$return =@ mysql_query($requete);
									
									while ($tab = mysql_fetch_array($return))
									{
										$origine_contact = $tab['origine_contact'];
										if($donnees['origine_contact'] == $origine_contact)
										{
											echo "<option value=\"$origine_contact\" selected=\"selected\">$origine_contact</option>";
										}
										else
										{
											echo "<option value=\"$origine_contact\">$origine_contact</option>";
										}
										
									}
									mysql_close();
								?>
			</select>
		</p>
		<p>
			<label for="nom2">Nom:</label>
			<input type="text" name="nom2" id="nom2" value="<?php echo $donnees['nom2']; ?>" maxlength="50"/>
		</p>
		<p>
			<label for="societe2">Société:</label>
			<input type="text" name="societe2" id="societe2" value="<?php echo $donnees['societe2']; ?>" maxlength="50"/>
		</p>
		<p>
			<label for="accord_financier_origine">Mémo financier:</label>
			<input type="text" name="accord_financier_origine" id="accord_financier_origine" value="<?php echo $donnees['accord_financier_origine']; ?>" maxlength="50"/>		
		</p>
		<p>
			<label for="support_publicitaire">Publication:</label>
			<input type="support_publicitaire" name="support_publicitaire" id="support_publicitaire" value="<?php echo $donnees['support_publicitaire']; ?>" maxlength="50"/>
		</p>
	
	</fieldset>
	<fieldset id="fRegistreCS">
		<legend>Registre commerce et sociétés</legend> 
		<p>
			<label for="RCS">RCS:</label>		
			<input type="text" name="RCS" id="RCS" value="<?php echo $donnees['RCS']; ?>" maxlength="50"/>
		</p>
		<p>
			<label for="lieu_RCS">Lieu RCS:</label>		
			<input type="text" name="lieu_RCS" id="lieu_RCS" value="<?php echo $donnees['lieu_RCS']; ?>" maxlength="50"/>
		</p>
	</fieldset>
</div>

<div class="tabContent" id="creer_document">
	<p>Je ne sais pas encore à quoi sert cet onglet...</p>
</div>

<div id="footer">
	<input type="submit" id="btSend" value="<?php if(isset($id_contact)){ echo "Modifier le contact";}else{ echo "Ajouter le nouveau contact";}?>"/>
	<input type="button" id="btBack" value="Quitter" onclick="parent.Shadowbox.close();" />
</div>
</form>

</body>
</html>
