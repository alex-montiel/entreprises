<?php require_once '../myparam.inc.php'; ?>

<style>
<!--
	#cadre1{
		width: 100%;
	}
	#txt1{
		margin-left: 300px;
	}
	#middle{
		margin-top: 50px;
	}
	#numero{
		margin-left: 250px;
		background-color: red;
	}
	#img1{
		margin-top: 35px;
		float: left;
	}
	hr{
		border: 0.2px gray;
	}
	th{
		background-color: #191970;
		color: white;
		text-align: center;
		width: 350px;
	}
	.column{
		width: 350px;
	}
	#separation{
		width: 15px;
	}
	.claire{
		background-color: #F5F5F5;
	}
	.foncee{
		background-color: lightgray;
	}
-->
</style>

<page>
	<page_header>
		<div id="cadre1">
			<span id="txt1">Fiche commerciale</span>
			<span id="numero">Numéro : <?php echo $_GET['id']; ?></span>
		</div>
		<hr/>
	</page_header>
	<div id="middle">
		<table>
			<tr>
				<table>
					<tr>
						<td style="width:150px">
							<img src="../../images/logo.png" id="imgGauche" style="width:150px" />
						</td>
						<td style="width:250px; padding: 0 10px">
							<p style="font-weight: bold"><?php echo $res['type_offre'];?>
							<br/>
							<?php echo $res['surface_total']; ?> m²
							</p>
						</td>
						<td rowspan="3">
							<?php if ($img['nom_photo']){?>
								<img src="../../photo/<?php echo $img['nom_photo']; ?>" id="imgDroite"  style="width:300px"/>
							<?php }?>
						</td>
					</tr>
					
					<tr>
						<td>
							<?php echo $entete; ?>
						</td>
						<td style="width:250px; padding: 0 10px">
							<?php echo $res['code_postal'] . " " . $res['ville'] ?>
							<br/>
							<?php echo $res['adresse'] . " " . $res['suite'];?>
						</td>	
					</tr>	
						
					<tr>
						<td></td>
						<td style="width:250px; padding: 0 10px">
							<?php echo $res['zone_activite']; ?>
						</td>
						<td></td>
					</tr>		
				</table>
			</tr>
		
			<tr style="margin-top:15px">
				<table>
					<td class="column">
						<!-- EMPLACEMENT -->
						<table>
							<tr><th>Qualité de l'emplacement</th></tr>
							<tr><td><?php echo $res['qualite_emplacement']; ?></td></tr>
						</table>
	
						<!-- DESCRIPTIF -->
						<table>
							<tr><th>Descriptif</th></tr>
							<tr><td><?php echo $res['descriptif']; ?></td></tr>
						</table>
				
						<!-- EQUIPEMENTS -->
						<table>
							<tr><th>Equipements</th></tr>
							<?php if(!empty($res['equipement'])){ ?>
								<tr><td><?php echo $res['equipement']; ?></td></tr>
							<?php }?>
						</table>
	
						<!-- COMMENTAIRES -->
						<table>
							<tr><th>Commentaires</th></tr>
						</table>
					</td>
					
					<td id="separation"></td>
					
					<td class="column">
						<!-- CONDITIONS FINANCIERES -->
						<table>
							<tr><th colspan="2">Conditions financières</th></tr>
							<tr>
								<td>Loyer annuel / mensuel : </td>
								<td><?php echo $res['loyer_annuel']; ?>€ / <?php echo $res['loyer_mensuel']; ?>€</td>
							</tr>
							<tr>
								<td>Prix de ventre : </td>
								<td><?php echo $res['prix_murs']; ?>€ <?php echo $res['tva_murs']; ?></td>
							</tr>
							<tr>
								<td>Provisions sur charges : </td>
								<td><?php echo $res['provision_vente']; ?></td>
							</tr>
							<tr>
								<td>Taxe foncière proprietaire : </td>
								<td><?php echo $res['impot_proprio']; ?></td>
							</tr>
							<tr>
								<td>Taxe foncière locataire : </td>
								<td><?php echo $res['impot_locataire']; ?></td>
							</tr>
							<tr>
								<td>Prix de cession : </td>
								<td><?php //echo $res['']; ?> ??</td>
							</tr>
							<tr>
								<td>Prix fond de commerce : </td>
								<td><?php echo $res['prix_fond_commerce']; ?></td>
							</tr>
							<tr>
								<td>Paiement : </td>
								<td><?php echo $res['paiement']; ?></td>
							</tr>
						</table>
						
						<!-- HONORAIRES -->
						<table>
							<tr><th>Honoraires</th></tr>
							<?php if(!empty($res['hono_trans_location'])){ ?>
								<tr><td><?php echo $res['hono_trans_location'];?></td></tr>
							<?php }?>
						
							<?php if(!empty($res['hono_redac_location'])){
								?>
								<tr><td><?php echo $res['hono_redac_location'];?></td></tr>
							<?php }?>
							
							<?php if(!empty($res['hono_trans_vente'])){
								?>
								<tr><td><?php echo $res['hono_trans_vente'];?></td></tr>
							<?php }?>
			
							<?php if(!empty($res['hono_redac_vente'])){
								?>
								<tr><td><?php echo $res['hono_redac_vente'];?></td></tr>
							<?php }?>
			
							<?php if(!empty($res['hono_total_location'])){
								?>
								<tr><td><?php echo $res['hono_total_location'];?></td></tr>
							<?php }?>
			
							<?php if(!empty($res['hono_total_vente'])){
								?>
								<tr><td><?php echo $res['hono_total_vente'];?></td></tr>
							<?php }?>
						</table>
	
						<!-- CONDITIONS JURIDIQUE -->
						<table>
							<tr><th colspan="2">Conditions juridiques</th></tr>
							<tr>
								<td>Type de bail : </td>
								<td><?php echo $res['type_bail']; ?></td>
							</tr>
							<tr>
								<td>Régime fiscal : </td>
								<td><?php echo $res['regime_fiscal']; ?></td>
							</tr>
							<tr>
								<td>Dépôt de garantie : </td>
								<td><?php echo $res['garantie']; ?></td>
							</tr>
						</table>
	
						<!-- SURFACES -->
						<table>
							<tr><th colspan="2">Surfaces</th></tr>
							<tr>
								<td style="text-align: center">Type</td>
								<td style="text-align: center">Surface</td>
							</tr>
							<tr class="claire">
								<td>Atelier : </td>
								<td><?php echo $res['atelier']; ?></td>
							</tr>
							<tr class="foncee">
								<td>Bureaux : </td>
								<td><?php echo $res['bureaux']; ?></td>
							</tr>
							<tr class="claire">
								<td>Dépot : </td>
								<td><?php echo $res['depot']; ?></td>
							</tr>
							<tr class="foncee">
								<td>Magasin : </td>
								<td><?php echo $res['magasin']; ?></td>
							</tr>
							<tr class="claire">
								<td>Terrain : </td>
								<td><?php echo $res['terrain']; ?></td>
							</tr>
							<tr style="background-color: #FF8686; font-weight: bold">
								<td>Total : </td>
								<td><?php echo $res['surface_total']; ?></td>
							</tr>
						</table>
		
						<!-- DISPONIBILITE -->
						<table>
							<tr><th colspan="2">Disponibilté</th></tr>
							<tr>
								<td>Locaux : </td>
								<td><?php echo $res['locaux']; ?></td>
							</tr>
							<tr>
								<td>Dispo location : </td>
								<td><?php echo $res['date_dispo_location']; ?></td>
							</tr>
							
							<tr>
								<td>Dispo vente : </td>
								<td><?php echo $res['date_dispo_vente']; ?></td>
							</tr>
						</table>
					</td>
				</table>
			</tr>
		</table>
	</div>
	<page_footer>
	<hr/>
		<table>
			<tr>
				<td>Document non contractuel édité le : </td>
				<td style="padding-left: 250px">Votre conseiller</td>
			</tr>
			<tr>
				<td><?php echo date("d/m/Y"); ?></td>
			</tr>
		</table>
		<hr/>
		<?php echo $pied; ?>
	</page_footer>
</page>