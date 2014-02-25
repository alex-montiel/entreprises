<fieldset id="zone_agence">
	<legend>Ajouter une nouvelle agence:</legend>
	<form method="post" action="ajouter_agence.php" id="form_agence">
		<p>
			<label for="nom" class="txt_user_agences">Nom de l'agence: </label>
			<input type="text" name="nom" class="txt_user_agences" style="width:200px;"/>
		</p>
		<p>
			<label for="adresse" class="txt_user_agences">Adresse de l'agence: </label>
                        <input type="text" name="adresse" class="txt_user_agences" style="width:300px;"/>
		</p>
		<p>
			<label for="cp" class="txt_user_agences">Code Postal: </label>
			<input type="text" name="cp" class="txt_user_agences"/>
		</p>
		<p>
			<label for="ville" class="txt_user_agences">Ville: </label>
			<input type="text" name="ville" class="txt_user_agences" style="width:150px;"/>
		</p>
                <p>
			<label for="pays" class="txt_user_agences">Pays: </label>
			<input type="text" name="pays" class="txt_user_agences" style="width:150px;"/>
		</p>
		<p>
			<label for="tel" class="txt_user_agences">Téléphone: </label>
			<input type="text" name="tel" class="txt_user_agences"/>
		</p>
		
		<p>
			<label for="mail" class="txt_user_agences">Mail de contact: </label>
			<input type="email" name="mail" class="txt_user_agences" style="width:250px;"/>
		</p>
		
		<p>
			<input type="submit" value="Enregistrer" id="bouton_ajoutAgence"/>
		</p>
		
	</form>
			
</fieldset>