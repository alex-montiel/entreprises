<table class="tableau">
	<caption>
		<div id="buttons">
			<input type="button" value="Tout afficher" onclick="changeTableau('tout')" class="button" />
			<input type="button" value="Débute par" onclick="changeTableau('debut')" class="button" />
			<input type="button" value="Contient" onclick="changeTableau('contient')" class="button" />
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

<script type="text/javascript">
    function Ajouter(url){
        var win;
        alert('url : ' + url);
        if(url == contact){
            win = window.open("", "Contacts");
            if(win.location=="about:blank"){
                win.location = "contact/contact.php";
            }else
                win.close();
                window.open("", "Contacts");
                win.location = "contact/contact.php";
        }else{
            win = window.open("", "Offres");
            if(win.location=="about:blank"){
                win.location = "offre/offre.php";
            }else
                win.close();
                window.open("", "Contacts");
                win.location = "offre/offre.php";
        }
    }
</script>
    
    <?php 


    if($action == 'contact'){
        ?><a href="#" title="Ajouter un contact" id="ajoutContact" onclick="Ajouter(contact)"><img src="Images/Ajouter2.png" /></a><?php
    }else if($action == 'offre'){
        ?><a href="#" title="Ajouter une offre" id="ajoutContact" onclick="Ajouter(offre)"><img src="Images/Ajouter2.png" /></a><?php
    }