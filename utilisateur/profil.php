<?php
$requete = "SELECT tel_utilisateur, portable_utilisateur, mail_utilisateur FROM utilisateur WHERE id_utilisateur = ".$_SESSION['id'];
$return = mysql_query($requete);
$donnees = mysql_fetch_array($return);
?>

<script type="text/javascript">
	$(window).load(function(){
		$('#contenu').css("display", "block");
	});
</script>

<fieldset>
	<legend>Modifier Votre profil:</legend>
	<form method="post" action="utilisateur/modifier_profil.php">
		<p>
		<label for="telephone">Téléphone fixe:</label>
		<input type="text" id="telephone" name="telephone" value="<?php echo $donnees['tel_utilisateur']; ?>" maxlength="10"/>
		</p>
		<p>
		<label for="portable">Téléphone Portable:</label>
		<input type="text" id="portable" name="portable" value="<?php echo $donnees['portable_utilisateur']; ?>" maxlength="10"/>
		</p>
		<p>
		<label for="mail">Téléphone fixe:</label>
		<input type="text" id="mail" name="mail" value="<?php echo $donnees['mail_utilisateur']; ?>"/>
		</p>
		<p>
		<input type="submit" value="Modifier"/> <a style="margin-left: 50px;" href="index.php?requete=mdp"><input type="button" value="Modifier Mot de Passe"/></a>
		</p> 
	</form>
</fieldset>