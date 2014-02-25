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

<fieldset id="zone_profil">
	<legend>Modifier votre profil:</legend>
	<form method="post" action="utilisateur/modifier_profil.php" id="form_profil">
		<p>
		<label for="telephone">Téléphone fixe:</label>
		<input type="text" id="telephone" name="telephone" value="<?php echo $donnees['tel_utilisateur']; ?>" maxlength="10"/>
		</p>
		<p>
		<label for="portable">Téléphone Portable:</label>
		<input type="text" id="portable" name="portable" value="<?php echo $donnees['portable_utilisateur']; ?>" maxlength="10"/>
		</p>
		<p>
		<label for="mail">E-mail:</label>
		<input type="email" id="mail" name="mail" value="<?php echo $donnees['mail_utilisateur']; ?>" maxlength="38" style="width: 200px;"/>
		</p>
		<p>
                <table>
                    <th><input type="submit" value="Modifier" id="btn_profil"/></th>
                    <th><a href="index.php?requete=mdp"><input type="button" value="Modifier Mot de Passe" id="btn_profil" style="width:200px;"/></a></th>		
                </p>             
	</form>
</fieldset>