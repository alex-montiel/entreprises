<page>
	<?php echo $res['texte_document']; ?>
	
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
		<?php //echo $pied; ?>
	</page_footer>
</page>