<?php
	session_start();
	
	include("../include/connex.inc.php");
	
	function checkmdp($mdp)
	{
		if($mdp == '')
		{
			$_SESSION['info_mdp'] = "Le mot de passe est vide.";
			return 'empty';
		}
		elseif(strlen($mdp) < 6) 
		{
			$_SESSION['info_mdp'] = "Le mot de passe doit faire au moins 6 caractéres.";
			return 'tooshort';
		}
		elseif(strlen($mdp) > 50)
		{
			$_SESSION['info_mdp'] = "Le mot de passe doit faire moins de 50 caractéres.";
			return 'toolong';
		}
		else
		{
			if(!preg_match('#[0-9]{1,}#', $mdp))
			{
				$_SESSION['info_mdp'] = "Le mot de passe doit contenir au moins un nombre.";
				return 'nofigure';
			}
			else if(!preg_match('#[A-Z]{1,}#', $mdp))
			{
				$_SESSION['info_mdp'] = "Le mot de passe doit contenir au moins un nombre.";
				return 'noupcap';
			} 
			else return 'ok';
		}
	}


	
	
	if(isset($_POST['mdp1']) && isset($_POST['mdp2']))
	{
		$mdp1 = $_POST['mdp1'];
		$mdp2 = $_POST['mdp2'];
		
		
		
		if($mdp1 != $mdp2)
		{
			$_SESSION['info_mdp'] = "Les deux mot de passe ne sont pas identiques.";
			header("Location:../index.php?requete=mdp");
			
		}
		else
		{
			if(checkmdp($mdp1) != "ok")
			{
				header("Location:../index.php?requete=mdp");
			}
			else
			{
				$mdp1 = md5($mdp1);
				$requete = "UPDATE utilisateur SET mdp_utilisateur = '$mdp1' WHERE id_utilisateur=".$_SESSION['id'];
				$return = mysql_query($requete);
				
				if(!$return)
				{
					echo "Une erreur s'est produite".mysql_error();
				}
				else
				{
					$_SESSION['info'] = "Votre Mot de Passe est bien modifié.";
					header("Location:../index.php");
				}
			}
		}
	}


?>