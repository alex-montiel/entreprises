<fieldset>
	<legend>Modifier une agence:</legend>
	<?php
		$id_agence = $_GET['id_agence'];
		
		$requete = "SELECT * FROM agence WHERE id_agence =".$id_agence;
		$return = mysql_query($requete);
		$donnees = mysql_fetch_array($return);
		
	?>
	
	<form method="post" action="modifier_agence.php">
		
		<input type="hidden" name="id_agence" value="<?php echo $id_agence;?>"/>
		<p>
			<label for="nom">Nom de l'agence: </label>
			<input type="text" name="nom" value="<?php echo $donnees['nom_agence'];?>"/>
		</p>
		<p>
			<label for="adresse">Adresse de l'agence: </label>
			<input type="text" name="adresse" value="<?php echo $donnees['adresse_agence'];?>"/>
		</p>
		<p>
			<label for="cp">Code Postal: </label>
			<input type="text" name="cp"  value="<?php echo $donnees['cp_agence'];?>"/>
		</p>
		<p>
			<label for="ville">Ville: </label>
			<input type="text" name="ville"  value="<?php echo $donnees['ville_agence'];?>"/>
		</p>
		<p>
			<label for="tel">Téléphone: </label>
			<input type="text" name="tel"  value="<?php echo $donnees['tel_agence'];?>"/>
		</p>
		
		<p>
			<label for="mail">Mail de contact: </label>
			<input type="text" name="mail"  value="<?php echo $donnees['mail_agence'];?>"/>
		</p>
		
		<p>
			<input type="submit" value="Enregistrer"/>
		</p>
		
	</form>
	<form method="post" action="supprimer_agence.php">
			<input type="hidden" name="id_agence" value="<?php echo $id_agence;?>"/>
			<input type="submit" value="Supprimer"/>
		</form>
			
</fieldset>