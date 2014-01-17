<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
		<?php
			include("../include/connex.inc.php");
		?>	
        <title>SquareEntreprise.fr</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="fr" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta name="DC.Language" scheme="RFC3066" content="fr" />
        <link rel="stylesheet" href="../include/clockpick/clockpick.css"/>
        <link type="text/css" href="../include/jquery-ui/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
        
        <script type="text/javascript" src="../include/jquery.js"></script>
        <script type="text/javascript" src="../include/jquery-ui/jquery-ui-1.7.2.custom.min.js"></script>
        <script type="text/javascript" src="../include/clockpick/clockpick.js"></script>
        
        
        <script type="text/javascript">
        
        $(document).ready(function() {
			$(".time").clockpick({
				starthour: 8,
				endhour: 19,
				military: true,
				layout: 'horizontal' 
				
			});

			$("#date_start_tache").datepicker({
				dateFormat: 'dd/mm/yy',
				firstDay: 1,
				dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
				dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
				dayNamesMin: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
				monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
				monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aou','Sep','Oct','Nov','Dec'],
				nextText: "Suivant",
				prevText: "Precedant",
				showAnim: 'clip'
			});
		});
	
        
        function checkbox(id)
        {
        	var effectue = 0;
        	
        	if($("#"+id).is(':checked') == true)
        	{
        		effectue = 1;
        	}
        	
        	$.ajax				
  				({ 
					type: "POST",
					url: "effectuer_tache.php",
					data: "id="+id+"&effectue="+effectue, 
					success:function(data)		
					{ 
						if(data != "")
						{
							alert(data);
						}
					 }	
				});	
		}
		
		function reset()
		{
			$('#date_start_tache').val("Date de l'évenement");
			$('#time_start_tache').val("heure de commencement");
			$('#time_end_tache').val("heure de fin");
			$('#comm_tache').val("Commentaire");
			$('#modifier').show();
		}
		
		function appel_tache(id)
		{
			reset();
			$.getJSON("rappel_tache.php?id_evenement="+id,
			function(data){
				if(data[0].date_start_tache != null)
				{
					$("#date_start_tache").val(data[0].date_start_tache);
				}
				if(data[0].comm_tache != "")
				{
					$("#comm_tache").val(data[0].comm_tache);
				}
				if(data[0].time_start_tache != "00:00")
				{
					$("#time_start_tache").val(data[0].time_start_tache);
				}
				if(data[0].time_end_tache != "00:00")
				{
					$("#time_end_tache").val(data[0].time_end_tache);
				}
				
				document.getElementById('bouton_tache').onclick = function(){ modifier_tache(id); };	
			});
		}
		
		function modifier_tache(id)
		{
			var date = $("#date_start_tache").val();
			var commentaire = $("#comm_tache").val();
			var start = $("#time_start_tache").val();
			var end = $("#time_end_tache").val();
			
			$.ajax({ 
				type: "POST",
				url: "modifier_tache.php",
				data: "date="+date+"&start="+start+"&end="+end+"&comm="+commentaire+"&id_evenement="+id,
				success:function(data)		
				{ 
					if(data != "")
					{
					  	alert(data);
					}
					else
					{
						$('#modifier').hide();
						location.reload();
					}
				}	
			});
		}       
        </script>
	</head>
<body>
	<p id="modifier" style="display:none; margin-top: 50px">
	<input type="text" value="Date de l'évenement" id="date_start_tache"/>
	
	<input type="text" value="heure de commencement" id="time_start_tache" class="time"/>
	<input type="text" value="heure de fin" id="time_end_tache" class="time"/>
	<input type="text" value="Commentaire" id="comm_tache" name="comm_tache" onfocus="if (this.value=='Commentaire') {this.value=''}"/>
	<input type="button" id="bouton_tache" value="Modifier la tache" onclick="modifier_tache();"/>
	</p>

	<ul id="taches">
	<?php
	$today = new DateTime();
	if(isset($_GET['day']))
	{
		$date = $_GET['day'];
	
		if($date == $today->format("Y-m-d"))
		{
			$requete= "SELECT *
					FROM evenements
					INNER JOIN typedetache ON evenements.tache = typedetache.tache
					INNER JOIN contact ON evenements.id_contact = contact.id_contact
					WHERE typedetache.emplacement = \"tache\"
					AND evenements.debut <= '$date'
					AND id_utilisateur = '".$_GET['idUtil']."';";
		}
		else
		{
			$requete= "SELECT *
					FROM evenements
					INNER JOIN typedetache ON evenements.tache = typedetache.tache
					INNER JOIN contact ON evenements.id_contact = contact.id_contact
					WHERE typedetache.emplacement = \"tache\"
					AND evenements.debut like '$date %'
					AND id_utilisateur = '".$_GET['idUtil']."';";
		}
		$return = mysql_query($requete) or die(mysql_error());
		$nbReturn = mysql_num_rows($return);
		
		if ($nbReturn == 0){
			?>
			<li>Il n'y a aucune tâche pour ce jour :)</li>
			<?php
		}
		else{
			while($donnees = mysql_fetch_array($return))
			{
				$debut = new DateTime($donnees['debut']);
				$fin = new DateTime($donnees['fin']);
				$effectue = "";
				
				echo "<li onclick=\"appel_tache(".$donnees['id_evenement'].");\">";
				echo $donnees['tache'].": ".$donnees['civilite']." ".$donnees['nom_contact']." le ".$debut->format("d/m/Y");
				
				if($donnees['debut'] != '0000-00-00 00:00:00' && $donnees['fin'] != '0000-00-00 00:00:00')
				{
					echo " entre ".$debut->format('G:i')." et ".$fin->format('G:i');
				}
				elseif($donnees['debut'] == '0000-00-00 00:00:00' && $donnees['fin'] == '0000-00-00 00:00:00')
				{
					echo " horaire non precisee.";
				}
				elseif($donnees['fin'] == '0000-00-00 00:00:00')
				{
					echo " a partir de ".$debut->format('G:i'); 
				}
				elseif($donnees['debut'] == '0000-00-00 00:00:00')
				{
					echo " avant ".$fin->format('G:i');
				}
				
				echo "<label for=\"".$donnees['id_evenement']."\">Effectuee:</label>";
				
				if($donnees['effectue'] == 1)
				{
					$effectue = "checked=\"checked\"";
				}
				echo "<input type=\"checkbox\" id=\"".$donnees['id_evenement']."\" onchange=\"checkbox(this.id);\" ".$effectue."/>";
				
				echo "<ul><li>Commentaire: ".$donnees['commentaire']."</li>";
		
					
				if($donnees['telephone'] != "")
				{
					echo "<li>Telephone: ".$donnees['telephone']."</li>";
				}	
					
				
				if($donnees['portable'] != "")
				{
					echo "<li>Telephone portable: ".$donnees['portable']."</li>";
				}
				
				echo "</ul>";
				echo "</li>";
			}
		}
	}
	?>
	</ul>
</body>
</html>

