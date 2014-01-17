<?php
	session_start();
	
	if($_SESSION['acces'] != "oui")
	{
		header("Location:../accueil.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
		<?php
			include("../include/connex.inc.php");
			
			// Liste des utilisateurs
			$query = "SELECT id_utilisateur, login_utilisateur FROM utilisateur;";
			$result = mysql_query($query) or die(mysql_error());
		?>	
        <title>SquareEntreprise.fr</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="fr" />
           <meta http-equiv="Content-Script-Type" content="text/javascript" />
           <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta name="DC.Language" scheme="RFC3066" content="fr" />
         
	    <link rel='stylesheet' type='text/css' href='../include/calendrier/reset.css' />
		<link rel='stylesheet' type='text/css' href='../include/calendrier/jquery-ui-1.7.2.custom.css' />
		<link rel='stylesheet' type='text/css' href='../include/calendrier/jquery.weekcalendar.css' />
		<link rel='stylesheet' type='text/css' href='../include/calendrier/demo.css' />
		<link rel="stylesheet" href="../style.css" type="text/css" media="screen" title="Normal" />
		<link href="../include/shadowbox/shadowbox.css" rel="stylesheet" type="text/css"/>
				
		<script type="text/javascript" src="../include/myparam.inc.js"></script>
		<script type='text/javascript' src='../include/jquery.js'></script>
		<script type="text/javascript" src="../include/shadowbox/shadowbox.js"></script>
		<script type='text/javascript' src='../include/jquery-ui/jquery-ui-1.7.2.custom.min.js'></script>
		<script type='text/javascript' src='../include/calendrier/jquery.weekcalendar.js'></script>
		<script type='text/javascript' src='calendrier.js'></script>
			
		 <script type="text/javascript">
			Shadowbox.init({
		    	language:   "fr",
		    	players:    ["html", "iframe", "img"]
			});
		</script> 
		
		<style type="text/css">
			/* barre entière */
			#calendar ::-webkit-scrollbar {
			    width: 10px;
			}
			
			/* contour */
			#calendar ::-webkit-scrollbar-track {
			    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
			    border-radius: 10px;
			}
			
			/* barre interne */
			#calendar ::-webkit-scrollbar-thumb {
			    border-radius: 10px;
			    box-shadow: inset 0 0 3px rgba(0,0,0,0.5);
			    background-color: #E6EEF1;
			}
			
			/* Boutons */
			::-webkit-scrollbar-button {
				/*height: 26px;*/
				width: 16px;
				height: 16px;
				background: url(../include/jquery-ui/images/ui-icons_222222_256x240.png);
				background-position: -2.5px -15px;
				
				/*background: url(../images/webkit-arrows-vert.png) ;*/
			}
			
			/* Bouton pour descendre */
			::-webkit-scrollbar-button:increment {
				background-position: -68px -15px;
			}
			
			/* Boutons horizontaux */
			::-webkit-scrollbar-button:horizontal {
				width: 26px;
				background: url(../images/webkit-arrows-horiz.png) 50% 1px no-repeat;
			}

			/* Bouton pour aller à droite */
			::-webkit-scrollbar-button:horizontal:increment {
				background-position: 50% -19px;
			}
		</style>
  	</head>
	<body>
		<h1 id="header"><span>Punfrance</span></h1>
		
		<p id="connexion">
			<?php
				if(isset($_SESSION['login']))
		      	{
		      		echo "Bonjour ".$_SESSION['login'];
		      		echo "<br/><a href=\"index.php?requete=profil\" onclick='showProfil()'>Profil</a>  <a href=\"utilisateur/logout.php\">Déconnexion</a>";
		      		echo "<br/>".$_SESSION['info'];
		      		
		      		if($_SESSION['login'] == "Admin")
		      		{
		      			echo "<a href=\"admin/afficher_profil.php\">Administration</a>";
		      		}
		      	}
		      	$_SESSION['info'] = "";
			?>
		</p>
		
		<ul id="menuhorizontal" >
			<li id="li1"><a href="http://127.0.0.1/entreprise/index.php?requete=contact">Contact</a></li>
			<li id="li2"><a href="http://127.0.0.1/entreprise/index.php?requete=offre">Offre</a></li>
			<li id="li3"><a href="http://127.0.0.1/entreprise/#">Demande</a></li>
			<li id="li4"><a href="http://127.0.0.1/entreprise/calendrier/calendrier.php">Planning</a></li>
			<li id="li5"><a href="http://127.0.0.1/entreprise/#">Stats.</a></li>
		</ul>
		
		<p><input type="hidden" id="nbre_tache" value=""/></p>
		<div id="calendar_selection" class="ui-corner-all">
			<strong>Voir l'agenda de : </strong>
			<select id="data_source">
				<?php
				while ($res = mysql_fetch_array($result)){
					echo "<option value='".$res['id_utilisateur']."'>".$res['login_utilisateur']."</option>";
				}
				?>
			</select>
		</div>
		<div id='calendar'></div>
		<div id="event_edit_container">
			<form>
				<p><input type="hidden" /></p>
				<ul>
					<li>
						<span>Date: </span><span class="date_holder"></span> 
					</li>
					<li>
						<label for="start">Heure de départ: </label><select name="start"></select>
					</li>
					<li>
						<label for="end">Heure de fin: </label><select name="end"></select>
					</li>
					<li>
						<label for="title">Titre: </label><input type="text" name="title" />
					</li>
					<li>
						<label for="body">Commentaire: </label><textarea name="body"></textarea>
					</li>
					<li id="li_status">
						<label for="status">Status: </label>
						<select name="status" id="status">
							<?php
								$requete = "SELECT status FROM statusTache";
								$return = mysql_query($requete);
								while($donnees = mysql_fetch_array($return))
								{
									echo '<option value="'.$donnees['status'].'">'.$donnees['status'].'</option>';
								}
							?>
						</select>
					</li>
					
				</ul>
			</form>
		</div>
		
		<script type="text/javascript">
			$("#connexion").css({"margin-left": $(window).width() - $("#connexion").width() - 100});
		
			// Recharge la page à la fermeture du formulaire de tâches
			$(document).ready(function(){
				$("#sb-overlay, #sb-nav-close").click(function(){
					$('#calendar').weekCalendar("refresh");
				});
			});	
		</script>
	</body>
</html>




