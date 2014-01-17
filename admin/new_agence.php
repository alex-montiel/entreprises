<fieldset>
	<legend>Ajouter une nouvelle agence:</legend>
	<form method="post" action="ajouter_agence.php">
		<p>
			<label for="nom">Nom de l'agence: </label>
			<input type="text" name="nom"/>
		</p>
		<p>
			<label for="adresse">Adresse de l'agence: </label>
			<input type="text" name="adresse"/>
		</p>
		<p>
			<label for="cp">Code Postal: </label>
			<input type="text" name="cp"/>
		</p>
		<p>
			<label for="ville">Ville: </label>
			<input type="text" name="ville"/>
		</p>
		<p>
			<label for="tel">Téléphone: </label>
			<input type="text" name="tel"/>
		</p>
		
		<p>
			<label for="mail">Mail de contact: </label>
			<input type="text" name="mail"/>
		</p>
		
		<p>
			<input type="submit" value="Enregistrer"/>
		</p>
		
	</form>
			
</fieldset>