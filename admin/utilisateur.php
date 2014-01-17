<fieldset>
	
	<?php
			$id_utilisateur = $_GET['id_utilisateur'];
			$requete = "SELECT * FROM utilisateur WHERE id_utilisateur = '$id_utilisateur'";
			$return = mysql_query($requete);
			$utilisateur = mysql_fetch_array($return);
			
	?>
	
	<legend>Modifiez un utilisateur:</legend>
	<form method="post" action="modifier_utilisateur.php">
		<input type="hidden" id="id_utilisateur" name="id_utilisateur" value="<?php echo $id_utilisateur;?>"/>
		<p>
		<label for="agence">Agence:</label> 
		<select id="agence" name="agence">
			<option value="">Choisir l'agence</option>
			<?php
				while($donnees = mysql_fetch_array($agence))
				{
					if($utilisateur['id_agence'] == $donnees['id_agence'])
					{
						echo "<option value=\"".$donnees['id_agence']."\" selected=\"selected\">".$donnees['nom_agence']."</option>";
					}
					else
					{
						echo "<option value=\"".$donnees['id_agence']."\">".$donnees['nom_agence']."</option>";
					}
					
				}
			?>
		</select>
		</p>
		
		<p>
			<label for="status">Status:</label> 
			<select id="status" name="status">
				<option value="">Choisir le status</option>
				<option value="admin" <?php if($utilisateur['status_utilisateur'] == 'admin'){echo 'selected="selected"';} ?>>Admin</option>
				<option value="chef" <?php if($utilisateur['status_utilisateur'] == 'chef'){echo 'selected="selected"';} ?>>Chef</option>
				<option value="negociateur" <?php if($utilisateur['status_utilisateur'] == 'negociateur'){echo 'selected="selected"';} ?>>Négociateur</option>
			</select>
			
		</p>
		
		<p>
			<label for="nom">Nom: </label>
			<input type="text" id="nom" name="nom" value="<?php echo $utilisateur['nom_utilisateur'];?>"/>
		</p>
		
		<p>
			<label for="prenom">Prenom: </label>
			<input type="text" id="prenom" name="prenom" value="<?php echo $utilisateur['prenom_utilisateur'];?>"/>
		</p>
		
		<p>
			<label for="login">Login: </label>
			<input type="text" id="login" name="login" value="<?php echo $utilisateur['login_utilisateur'];?>"/>
		</p>
		<p>
			<label for="telephone">Telephone:</label>
			<input type="text" id="telephone" name="telephone" value="<?php echo $utilisateur['tel_utilisateur'];?>"/>
		</p>
		
		<p>
			<label for="portable">Portable:</label>
			<input type="text" id="portable" name="portable" value="<?php echo $utilisateur['portable_utilisateur'];?>"/>
		</p>
		<p>
			<label for="mail">Adresse Mail:</label>
			<input type="text" id="mail" name="mail" value="<?php echo $utilisateur['mail_utilisateur'];?>"/>
		</p>
		
		<p>
			<input type="submit" value="Modifier"/> 
			
		</p>
			
	</form>
			
			<form action="supprimer_utilisateur.php" method="post">
			<p>
			<input type="hidden" name="nego_supprimer" value="<?php echo $id_utilisateur; ?>"/>
			<label for="next_nego">Négociateur récupérant les données: </label>
			<select id="next_nego" name="next_nego">
				<option value="">Choisir un négociateur de l'agence</option>
				<?php
					$requete = "SELECT id_utilisateur, nom_utilisateur, prenom_utilisateur FROM utilisateur WHERE id_agence =".$utilisateur['id_agence'];
					$return = mysql_query($requete);
					while($donnees = mysql_fetch_array($return))
					{
						echo "<option value=\"".$donnees['id_utilisateur']."\">".$donnees['nom_utilisateur']."  ".$donnees['prenom_utilisateur']."</option>";
					}
				?>
			</select>
			
			</p>
			<p>
				<input type="submit" value="Supprimer l'utilisateur"/>
			</p>
			</form>
			
	
</fieldset>