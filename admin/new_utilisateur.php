<fieldset id="zone_utilisateur">
	<legend>Ajouter un nouvel utilisateur</legend>
	<form method="post" action="ajouter_utilisateur.php" id="form_utilisateur">
		<p>
		<label for="agence">Agence:</label> 
		<select id="agence" name="agence" style="width:200px;">
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
                        <select id="status" name="status" style="width:200px;">
				<option value="">Choisir le status</option>
				<option value="admin">Admin</option>
				<option value="chef">Chef</option>
				<option value="negociateur">Négociateur</option>
			</select>
			
		</p>
		
		<p>
			<label for="nom" class="txt_user_agences" >Nom: </label>
			<input type="text" id="nom" name="nom" style="width:200px;" class="txt_user_agences"/>
			<?php echo $_SESSION['info']; $_SESSION['info'] = "";?>
		</p>
		
		<p>
			<label for="prenom" class="txt_user_agences">Prenom: </label>
			<input type="text" id="prenom" name="prenom" style="width:180px;" class="txt_user_agences"/>
		</p>
		
		<p>
			<label for="login" class="txt_user_agences">Login: </label>
			<input type="text" id="login" name="login" class="txt_user_agences"/>
		</p>
		
		<p>
			<label for="mdp" class="txt_user_agences">Mot de Passe:</label>
			<input type="text" id="mdp" name="mdp" class="txt_user_agences"/>
		</p>
		
		<p>
			<label for="telephone" class="txt_user_agences">Telephone:</label>
			<input type="text" id="telephone" name="telephone" class="txt_user_agences"/>
		</p>
		
		<p>
			<label for="portable" class="txt_user_agences">Portable:</label>
			<input type="text" id="portable" name="portable" class="txt_user_agences"/>
		</p>
		
		<p>
			<label for="mail" class="txt_user_agences">Adresse Mail:</label>
			<input type="email" id="mail" name="mail" style="width:200px;" class="txt_user_agences"/>
		</p>
		
		<p>
			<input type="submit" value="Enregistrer" id="bouton_ajoutUser"/>
		</p>
			
	</form>
	
</fieldset>