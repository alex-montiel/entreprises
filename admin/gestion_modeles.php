<?php
$sDeb = "!-";
$sFin = "-!";

$query = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'test1' ORDER BY TABLE_NAME ASC";
$result = mysql_query($query) or die(mysql_error());
?>


<script type="text/javascript">
	var sDeb = "<?php echo $sDeb; ?>";
	var sFin = "<?php echo $sFin; ?>";
	//var styleSignet = "background-color: green; color: white;";
	//var styleSignetUnknown = "background-color: red; color: yellow;";

	var tabFields = new Array;
	var width = 1654/2; // A4
	var height= 2339/2;
	var signetOuvert = false;
	
	tinyMCE.init({
		mode : "exact",
		theme : "advanced",
		elements : "modele_content",
		    plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,ibrowser", 
		 
		    // Theme options 
		    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,<gras>ibrowser</gras>,fontsizeselect", 
		    theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,undo,redo,|,link,unlink,anchor,image,code,|,preview,|,forecolor,backcolor", 
		    theme_advanced_buttons3 : "tablecontrols,|,hr,|,charmap,|,fullscreen,", 

		theme_advanced_toolbar_location : "top",

		theme_advanced_toolbar_align : "left",
		width: width,
		height: height,
		language : "fr",
		setup: function(ed){
			ed.onKeyUp.add(function(ed, e){
				//doGetCaretPosition(document.blah.nameEdit);
				//doGetCaretPosition(ed);
				
				//ed.selection.select(ed.dom.select('span#caret_pos_holder')[0]); //select the span
				//ed.dom.remove(ed.dom.select('span#caret_pos_holder')[0]); //remove the span
				alertKey(ed, e);
			});
		},
		content_css: "/entreprise/include/tiny_mce/present.css"
	});
	
	function alertKey(ed, e){
		if(e.keyCode == 223){ // !
			if (signetOuvert == true){
				designMCE(true);
				signetOuvert = false;
			}
			else{
				signetOuvert = true;
			}
		}
	}

	function designMCE(isNew){
		var espace = "";
		if (isNew){
			espace = "&nbsp";
		}
		var contain = tinyMCE.get('modele_content');
		var string = contain.getContent();
		var newString;
					
		var signets = new Array();
		signets = string.split(sDeb);
		
		var signets2 = new Array;
		$.each(signets, function(i, value){
			signets2[i] = value.split(sFin)[0];
		});

		// Supprime le 1er élement
		signets2.shift();

		//alert(tabFields.length);
		$.each(signets2, function(i, value){
			//if (isNew){
				newString = string.replace(sDeb+value+sFin, "<span id='signet"+i+"' class='signet'>"+sDeb+value+sFin+"</span>"+espace);
			//}
			contain.setContent(newString);
		});
		//alert($("#modele_content_ifr").getContent().find("#signet0").length);
		//$("#iFrame").content().find("#signet0").css({ "background-color": "green", "color": "white" });
	}
	
	function chargeModele(id){
    	$.ajax({ 
			type: "POST",
			url: "include/infosModele.php",
			dataType: 'json',
			data: "id="+id, 
			success:function(data)		
			{ 
				if(data != "")
				{
					$("[name='id_modele']").val(data[0].id_modele); // Tous les id_modeles
					$("#type_modele").val(data[0].type_modele);
					$("#table option[value="+data[0].table_modele+"]").attr("selected", true); // Selectionne table dans liste
					$("#cle_table_modele").val(data[0].cle_table_modele);
					$("#nom_modele").val(data[0].nom_modele);
					$("[name='nom_table']").val(data[0].table_modele);
					tinyMCE.get('modele_content').setContent(data[0].texte_modele);

					showFields(data[0].table_modele);
				}
				else{
					alert("Erreur");
				}
			}	
		});	
	}

	function createModele(){
		tinyMCE.get('modele_content').setContent('');
		$('#nom_modele').val('');
		$('#id_modele').val('');
	}
	
	function showFields(select){
		$.getJSON("include/recherche_champs.php",
			{ table: select },
			function(data){
				// Vide options liste champs
				$("#field > *").remove();
				tabFields.splice(0, tabFields.length);

				/*$("#ici").empty();*/
				// Remplie liste champs
				$.each(data, function(i, item){
					/*$("#ici").html($("#ici").html() + "C." +item.column_name+ " as 'C."+item.column_name+"', ");*/
					$("#field").append("<option id='"+item.column_name+"'>"+item.column_name+"</option>");
					tabFields[i] = item.column_name;
				});
				$("#cle_table_modele").val(data[0].column_name); // Par défault premier champs de la table
			}
		);
	}

	function addSelectedField(){
		select = $("#field").val();
		
		var string = tinyMCE.get('modele_content').getContent();
		var string1 = string.substring(3, string.length-4); // Retire les balises de paragraphe
		
		var newString = string.replace(string1, string1+sDeb+select+sFin+"&nbsp</p>");
		tinyMCE.get('modele_content').setContent(newString);
		designMCE();
	}

	function selectPK(){
		$("#cle_table_modele").val($("#field").val());
	}

	function insertImg(){
		var string = tinyMCE.get('modele_content').getContent();
		var string1 = string.substring(3, string.length-4);
		var toAdd = "<span class='signet'>"+sDeb+"image"+sFin+"</span>&nbsp";

		var newString = string.replace(string1, string1+toAdd);
		
		tinyMCE.get('modele_content').setContent(newString);
	}
	
	function insertDPE(){
		var string = tinyMCE.get('modele_content').getContent();
		var string1 = string.substring(3, string.length-4);
		var toAdd = "<span class='signet'>"+sDeb+"dpe"+sFin+"</span>&nbsp";
		
		var newString = string.replace(string1, string1+toAdd);
		tinyMCE.get('modele_content').setContent(newString);
	}

	function insertDate(){
		var string = tinyMCE.get('modele_content').getContent();
		var string1 = string.substring(3, string.length-4);
		var toAdd = "<span class='signet'>"+sDeb+"date"+sFin+"</span>&nbsp";
		
		var newString = string.replace(string1, string1+toAdd);
		tinyMCE.get('modele_content').setContent(newString);
	}
</script>
<!-- <div id='ici' /></div> -->
<table id="gestion_modeles">
	<tr>
		<td id="listeModeles" class="gestion_modele_col">
			<ul>
				<?php
				$queryModeles = "SELECT * FROM modele";
				$resultModeles = mysql_query($queryModeles);
				
				while ($res = mysql_fetch_array($resultModeles)){
					?>
					<li onclick="chargeModele('<?php echo $res['id_modele']; ?>')"><?php echo $res['nom_modele']; ?></li>	
					<?php
				}
				?>
			</ul>
		</td>
		<td id="td2" class="gestion_modele_col">
			<div id="modele">
				<form action="include/change_modele.php" method="post">
					<div id="modele_param">
						<input type="button" value="Nouveau modèle" onclick="createModele();" />
						<br/>
						
						<select id="table" name="table" onchange="showFields(this.value); $('#modele').val(this.value);">
							<?php 
							while ($table = mysql_fetch_array($result)){
								?>
								<option value="<?php echo $table['TABLE_NAME']; ?>"><?php echo $table['TABLE_NAME']; ?></option>
								<?php
							}
							?>
						</select>
						
						<select id="field">
							<!-- Chargé par jQuery -->
						</select>
						
						<input type="button" value="Ajouter le champs" onclick="addSelectedField();"/>						
						<input type="button" value="Déclarer comme clé primaire" onclick="selectPK();" />
						<br/>
						
						<input type="hidden" name="id_modele" id="id_modele" value="" />
						
						<label for="cle_table_modele">Clé primaire de la table : </label>
						<input type="text" name="cle_table_modele" id="cle_table_modele" readonly/>
						<br/>
						
						<label for="nom_modele">Titre du modèle : </label>
						<input type="text" name="nom_modele" id="nom_modele" />
						<br/>
						
						<label for="type_modele">Type du modèle : </label>
						<input type="text" name="type_modele" id="type_modele" />
						<br/>
						
						<input type="button" value="Balise image" onclick="insertImg()" />
						<input type="button" value="Balise dpe" onclick="insertDPE()" />
						<input type="button" value="Date du jour" onclick="insertDate()" />
					</div>
					
					<textarea style="width: 100%;" name="content" id="modele_content"></textarea>
					<input name="send" type="submit" value="Envoyer" />
				</form>
				
				<form action="include/charge_modele.php" method="post">
					<input type="hidden" name="id_modele" id="id_modele2" value="" />
					<input type="hidden" name="nom_table" id="nom_table2" value="" />
					<input type="submit" value="Charger" />
				</form>
				
				<form action="include/delete_modele.php" method="post">
					<input type="hidden" name="id_modele" id="id_modele3" value="" />
					
					<input type="submit" value="Supprimer" />
				</form>
			</div>
		</td>
	</tr>
</table>
<script language="JavaScript">
	showFields($("#table").val());
</script>