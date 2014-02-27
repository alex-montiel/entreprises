<?php
	
	if(isset($_POST['mdp']))
	{
		$mdp = md5($_POST['mdp']);
		
		$requete = "SELECT mdp_utilisateur FROM utilisateur WHERE id_utilisateur=".$_SESSION['id'];
		$return = mysql_query($requete);
		$donnees = mysql_fetch_array($return);
		
		if($mdp == $donnees['mdp_utilisateur'])
		{
		
		?>
		
		<fieldset id="zone_mdp">
			<legend>Veuillez entrer votre nouveau mot de passe.</legend>
			<form action="utilisateur/modifier_mdp.php" method="post" id="form_mdp">
			<p>
				<?php echo $_SESSION['info_mdp']; $_SESSION['info_mdp'] = ""; ?>
			</p>
			<p>
				<label for="mdp1" style="width: 200px;">Mot de passe:</label>
				<input type="password" id="mdp1" name="mdp1"/>
			</p>
			
			<p>
				<label for="mdp2" style="width: 200px;">Retapez votre Mot de passe:</label>
				<input type="password" id="mdp2" name="mdp2"/>
			</p>
			
			<p>
				<input type="submit" value="Enregistrer" id="btn_mdp"/>
			</p>
			</form>		
		</fieldset>
		<?php
		
		}
		else
		{
			$_SESSION['info_mdp'] = "Mauvais Mot de Passe!";
			echo "<meta http-equiv='refresh' content='0';URL=index.php?refresh=1&requete=mdp'>"; 
		}
	}
	else
	{
	?>
		<fieldset id="zone_mdp">
			<legend>Veuillez entrer votre mot de passe.</legend>
			<form action="index.php?requete=mdp" method="post" id="form_mdp">
			<p>
				<?php echo $_SESSION['info_mdp']; $_SESSION['info_mdp'] = ""; ?>
			</p>
			
			<p>
				<label for="mdp" style="width: 200px;">Mot de passe Actuel:</label>
				<input type="password" id="mdp" name="mdp"/>
			</p>
			<p>
				<input type="submit" value="Envoyer" id="btn_mdp"/>
			</p>
			</form>		
		</fieldset>
	
	<?php
	}
	
?>