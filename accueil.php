<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<style type="text/css">
		body{
			background-color: #FFFFE5;
			font-family: "Arial";
		}
		#connexion{
			width: 1000px;
			margin: auto;
			margin-top: 25%;
		}
		#connexion legend{
			padding: 0 15px;
			margin-left: 10px;
			background-color: #FFFFE5;
			border-radius: 0 0 40px 40px;
			font-weight: bolder;
			font-size: 23px;
			color: darkRed;
		}
		#connexion fieldset{
			border-radius: 0 40px;
			background-color: lightblue;
			border: 1px solid darkRed;
		}
		#connexion table{
			width: 100%;
		}
		#connexion table td{
			width: 50%;
		}
		#connexion table .labels{
			text-align: right;
			font-weight: bolder;
			color: darkRed;
		}
		#connexion table .champs{
			margin-right: 15px;
		}
		#connexion table .button{
			text-align: center;
		}
		.bt_submit{
			color: darkRed;
		}
	</style>
</head>
<body>
<div id="connexion">
	<fieldset>
		<legend>Connexion</legend>
		<form method="post" action="utilisateur/connexion.php" >
			<table>
				<tr>
					<td class="labels">
						<label for="login">Login :</label>
					</td>
					<td class="champs">
						<input type="text" maxlength="50" id="login" name="login"/>
					</td>
				</tr>
				
				<tr>
					<td class="labels">
						<label for="mdp">Mot de Passe :</label>
					</td>
					<td  class="champs">
						<input type="password" maxlength="50" id="mdp" name="mdp"/>
					</td>
				</tr>
				
				<tr>
					<td colspan="2" class="button">
						<input type="submit" value="Connexion" class="bt_submit" /> 
					</td>
				</tr>
			<?php
				echo mysql_error();
			?>
			</table>
		
		</form>
	</fieldset>
</div>
</body>
</html>