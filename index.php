<?php
        error_reporting(E_ERROR);
	session_start();
	
	if($_SESSION['acces'] != "oui")
	{
		header("Location:accueil.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
		<?php
			include("include/connex.inc.php");
			include 'include/myparam.inc.php';
		?>	
        <title>SquareEntreprise.fr</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="fr" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
        <meta name="DC.Language" scheme="RFC3066" content="fr" />
        
        <script type="text/javascript" src="include/jquery.js"></script>
		<script type="text/javascript" src="include/shadowbox/shadowbox.js"></script>

		<script type="text/javascript" src="style_tableau.js"></script>
		<!--[if lte IE 8]>
			<script type="text/javascript" src="include/roundies.js"></script>
			
			<style>
				#connexion{border: gray solid; border-width: 0 1px 4px 1px};
			</style>
		<![endif]-->
        <link rel="stylesheet" href="style.css" type="text/css" media="screen" title="Normal" />
        <link href="include/shadowbox/shadowbox.css" rel="stylesheet" type="text/css"/>

        
        <script type="text/javascript">
			Shadowbox.init({
		    	language:   "en",
		    	players:    ["html", "iframe", "img"]
			});
			//Shadowbox.setup();
		</script>

		<script type="text/javascript">
			function supprimer(id)
			{
				if (confirm('Voulez vous vraiment supprimer ce contact ?') == true)
				{
					$.ajax
	  				({ 
						type: "GET", 
						url: "contact/supprimer_contact.php?id="+id, 
						success:function()
						{ 
							var e = document.getElementById(id);
							e.parentNode.removeChild(e);				
						} 
					});
				}
			}
		</script>
		
		<?php 
		if (isset($_GET['requete'])){
			switch ($_GET['requete']) {
				case "offre":
					$lien = "offre/offre.php";
					?>
					<script type="text/javascript">
						var lien = "offre/offre.php";
						var fiche = true;
					</script>
					<?php
				break;
				case "contact":
					$lien = "contact/contact.php";
					?>
					<script type="text/javascript">
						var lien = "contact/contact.php";
						var fiche = false;
					</script>
					<?php
				break;
			}
			?>
		
			<?php 
		}
		?>
   </head>

<body>
	<a href="index.php"><div id="header"><span>Punfrance</span></div></a>

	<div id="connexion">
		<?php
			if(isset($_SESSION['login']))
	      	{
	      		echo "Bonjour ".$_SESSION['login'];
	      		echo "<br/><a href=\"index.php?requete=profil\" onclick='showProfil()'>Profil</a>  <a href=\"utilisateur/logout.php\">Déconnexion</a>";
	      		echo "<br/>".$_SESSION['info'];
	      		
	      		if($_SESSION['login'] == "admin")
	      		{
	      			echo "<a href=\"admin/afficher_profil.php\">Administration</a>";
	      		}
	      	}
	      	$_SESSION['info'] = "";
		?>
	</div>
	
	<ul id="menuhorizontal">
		<li id="li1"><a href="index.php?requete=contact">Contact</a></li>
		<li id="li2"><a href="index.php?requete=offre">Offre</a></li>
		<li id="li3"><a href="#">Demande</a></li>
		<li id="li4"><a href="calendrier/calendrier.php">Planning</a></li>
		<li id="li5"><a href="#">Stats.</a></li>
	</ul>
	
	<ul id="menuvertical">
		<?php
			if(isset($_GET['requete']))
			{
				if($_GET['requete'] == "contact")
				{
					/*echo '<li id="ajoutContact"><a href="contact/contact.php" rel="shadowbox;height=800px;width=1024px;" title="Ajouter un contact">Ajouter un contact</a></li>';
										
					echo '<li id="derniersAjouts">Derniers ajouts</li>';
					$requete = "SELECT id_contact, nom_contact FROM contact ORDER BY date_creation DESC LIMIT 0,2";
					$result = mysql_query($requete);
					while($donnees = mysql_fetch_array($result))
					{
						echo '<li class="ongletsVerticaux"><a href="contact/contact.php" rel="shadowbox;height=800px;width=1024px;" title="Modifiez un contact" >'.$donnees['nom_contact'].'</a></li>';
					}*/
				
				}
				elseif($_GET['requete'] == "offre")
				{
					echo '<li><a href="offre/offre.php" rel="shadowbox;height=800px;width=1024px;" title="Ajouter une offre">Ajouter une offre</a></li>';
					$requete = "SELECT id_offre FROM offre WHERE id_agence=".$_SESSION['agence'];
					$return = mysql_query($requete);
					while($donnees = mysql_fetch_array($return))
					{
                                             '<li><a href="offre/offre.php?id='.$donnees['id_offre'].'" rel="shadowbox;height=800px;width=1024px;" title="Modifiez une offre">'.$donnees['id_offre'].'</a> <a href="commerciale.php?id='.$donnees['id_offre'].'" title="Fiche commerciale"> Fiche</a></li>';
					}
				}
			
			}
		?>
	</ul>
	
	<?php 
	if($_GET['requete'] == "profil" || $_GET['requete'] == "mdp"){
		?>
		<div id="contenu">
			<?php
				if($_GET['requete'] == "profil")
				{
					include("utilisateur/profil.php");
				}
				elseif($_GET['requete'] == "mdp")
				{
					include("utilisateur/mdp.php");
				}
			?>
	</div>
	<?php 
	}
	?>
	
	<?php 
	if($_GET['requete'] == "contact"){
            
            if(isset($_GET['page']) && $_GET['page']!= 0){
                $pageActuelle = intval($_GET['page']);
                if ($pageActuelle > $nbPage){
                    $pageActuelle = $nbPage;
                }
            }else{
                $pageActuelle = 1;
}

            
            $pagination = 15;
            $resultat = mysql_query('SELECT COUNT(*) AS "total" FROM contact');
            $tabResult = mysql_fetch_assoc($resultat);
            $nbLignes = $tabResult['total'];
            $nbPage = ceil($nbLignes / $pagination);

		?>
		<script type="text/javascript">
			var TDbs = new Array;
			TDbs = ["agence", "contact"];
                        var nbPage;
                        nbPage = <?php echo $nbPage; ?>;
		</script>
        
		<div id="tableauContacts">
			<?php
                        
			// Parametre tableau
			$caption = "Liste des contacts";
			$TColumn[] = array("id" => "choix", "libelle" => "", "type" => "select", "filter" => true);
			$TColumn[] = array("id" => "id_contact", "libelle" => "Code", "type" => "text", "filter" => false);
			$TColumn[] = array("id" => "nom_contact", "libelle" => "Nom", "type" => "text", "filter" => true);
			$TColumn[] = array("id" => "prenom_contact", "libelle" => "Prénom", "type" => "text", "filter" => true);
			$TColumn[] = array("id" => "telephone", "libelle" => "Tel", "Type" => "text", "filter" => true);
			$TColumn[] = array("id" => "portable", "libelle" => "Portable", "type" => "text", "filter" => true);
			$TColumn[] = array("id" => "email", "libelle" => "Mail", "type" => "text", "filter" => false);
			$TColumn[] = array("id" => "ville_agence", "libelle" => "Ville", "type" => "text", "filter" => true);
			$TColumn[] = array("id" => "cp_agence", "libelle" => "CP", "type" => "text", "filter" => true);
			$TColumn[] = array("id" => "nom_agence", "libelle" => "Nom", "type" => "text", "filter" => true);
			
			include 'form_tableaux.php'; 
			?>
		</div>
	<?php
	}
	
        if($_GET['requete'] == "offre"){
            
            if(isset($_GET['page']) && $_GET['page']!= 0){
                $pageActuelle = intval($_GET['page']);
                if ($pageActuelle > $nbPage){
                    $pageActuelle = $nbPage;
                }
            }else{
                $pageActuelle = 1;
            }
		
            $pagination = 15;
            $resultat = mysql_query('SELECT COUNT(*) AS total FROM offre');
            $tabResult = mysql_fetch_assoc($resultat);
            $nbLignes = $tabResult['total'];
            $nbPage = ceil($nbLignes / $pagination);
            
            ?>
		<script type="text/javascript">
			var TDbs = new Array;
			TDbs = ["offre", "utilisateur"];
			var conditions = "offre.id_utilisateur_suivi = utilisateur.id_utilisateur";
                        var nbPage;
                        nbPage = <?php echo $nbPage; ?>;
		</script>
		<div id="tableauOffres">
			<?php
			// Parametre tableau
			$caption = "Liste des offres";
			$TColumn[] = array("id" => "choix", "libelle" => "", "type" => "select", "filter" => true);
			$TColumn[] = array("id" => "id_offre", "libelle" => "Code", "type" => "text", "filter" => false);
			$TColumn[] = array("id" => "nom_utilisateur", "libelle" => "Suivi", "type" => "text", "filter" => true);
			$TColumn[] = array("id" => "classement", "libelle" => "Classement", "type" => "text", "filter" => true);
			$TColumn[] = array("id" => "type_offre", "libelle" => "Type de l'offre", "Type" => "text", "filter" => false);
			$TColumn[] = array("id" => "type_transaction", "libelle" => "Type de transaction", "type" => "text", "filter" => false);
			$TColumn[] = array("id" => "louer_vendre", "libelle" => "Action", "type" => "text", "filter" => false);
			$TColumn[] = array("id" => "locaux", "libelle" => "Locaux", "type" => "text", "filter" => true);
			$TColumn[] = array("id" => "surface_total", "libelle" => "Surface", "type" => "text", "filter" => true);
			$TColumn[] = array("id" => "code_postal", "libelle" => "CP", "type" => "text", "filter" => true);
			$TColumn[] = array("id" => "offre.ville", "libelle" => "ville", "type" => "text", "filter" => true);
			
			include 'form_tableaux.php'; 
			?>
		</div>
	<?php
	}
	?>
</body>
</html>
