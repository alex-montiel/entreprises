<table class="tableau">
	<caption>
		<div id="buttons">
			<input type="button" value="Tout afficher" onclick="changeTableau('tout', 1)" class="button" />
			<input type="button" value="Débute par" onclick="changeTableau('debut', 1)" class="button" />
			<input type="button" value="Contient" onclick="changeTableau('contient', 1)" class="button" />
		</div>
		<h2><span id="captionTitle"><?php echo $caption; ?></span></h2>
	</caption>
	<tr id="T1line1" class="title">
		<?php 
		foreach ($TColumn as $column){
			?>
			<th id="<?php echo $column['id'] ?>"><?php echo $column['libelle']; ?></th>
			<?php
		}
		?>

	</tr>
	
	<!-- Paramètres de recherches -->
	<tr id="T1line2" class="filter">
		<?php
		$columnNb = 1;
		foreach ($TColumn as $column){
			?>
			<td id="T1line2column<?php echo $columnNb;?>">
				<?php
				if ($column["filter"] == true){
					// Le champs est un filtre
					switch ($column["type"]){
						case "select":
							if ($column['libelle'] == "Opération"){
								?>
								<!-- 
								<select id="filter_<?php echo $column['id'];?>">
									<option value="tous">Tout afficher</option>
									<option value="debut">Débute par</option>
									<option value="contient">Contient</option>
								</select>
								-->
								
								<?php
							}
						break;
						// Type = texte
						default:
							?>
							<input type="text" id="filter_<?php echo $column['id']; ?>" />
							<?php
						break;
					}
				}
				$columnNb++;
				?>
			</td>
			<?php
		}
		?>
	<!-- fonction AJAX -->
</table>
<!--        <a href="contact/contact.php" rel="shadowbox;height=800px;width=1024px;" title="Ajouter un contact" id="ajoutContact"><input type="button" value="Ajouter" class="button"/></a>-->
<?php if($_GET['requete'] == "offre"){
    ?><a href="offre/offre.php" rel="shadowbox;height=800px;width=1024px;" title="Ajouter une offre" id="ajoutContact" ><img src="Images/Ajouter2.png" title="Ajouter une offre" />
<?php }else if($_GET['requete'] == "contact"){
    ?><a href="contact/contact.php" rel="shadowbox;height=800px;width=1024px;" title="Ajouter un contact" id="ajoutContact" ><img src="Images/Ajouter2.png" title="Ajouter un contact" />
<?php }
