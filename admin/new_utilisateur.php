<fieldset>
	<legend>Ajouter un nouveau contact:</legend>
	<form method="post" action="ajouter_utilisateur.php">
		<p>
		<label for="agence">Agence:</label> 
		<select id="agence" name="agence">
			<option value="">Choisir l'agence</option>
			<?php
				while($donnees = mysql_fetch_array($agence))
				{
					echo "<option value=\"".$donnees['id_agence']."\">".$donnees['nom_agence']."</option>";
				}
			?>
		</select>
		</p>
		
		<p>
			<label for="status">Status:</label> 
			<select id="status" name="status">
				<option value="">Choisir le status</option>
				<option value="admin">Admin</option>
				<option value="chef">Chef</option>
				<option value="negociateur">Négociateur</option>
			</select>
			
		</p>
		
		<p>
			<label for="nom">Nom: </label>
			<input type="text" id="nom" name="nom"/>
			<?php echo $_SESSION['info']; $_SESSION['info'] = "";?>
		</p>
		
		<p>
			<label for="prenom">Prenom: </label>
			<input type="text" id="prenom" name="prenom"/>
		</p>
		
		<p>
			<label for="login">Login: </label>
			<input type="text" id="login" name="login"/>
		</p>
		
		<p>
			<label for="mdp">Mot de Passe:</label>
			<input type="text" id="mdp" name="mdp"/>
		</p>
		
		<p>
			<label for="telephone">Telephone:</label>
			<input type="text" id="telephone" name="telephone"/>
		</p>
		
		<p>
			<label for="portable">Portable:</label>
			<input type="text" id="portable" name="portable"/>
		</p>
		
		<p>
			<label for="mail">Adresse Mail:</label>
			<input type="text" id="mail" name="mail"/>
		</p>
		
		<p>
			<input type="submit" value="Enregistrer"/>
		</p>
			
	</form>
	
</fieldset>