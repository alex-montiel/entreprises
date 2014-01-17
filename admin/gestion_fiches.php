<?php	
$query = "SELECT * FROM infos_fiches";
$result = mysql_query($query);

$res = mysql_fetch_assoc($result);
?>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		elements : "text",
		    plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,ibrowser", 
		 
		    // Theme options 
		    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,<gras>ibrowser</gras>,fontsizeselect", 
		    theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,undo,redo,|,link,unlink,anchor,image,code,|,preview,|,forecolor,backcolor", 
		    theme_advanced_buttons3 : "tablecontrols,|,hr,|,charmap,|,fullscreen", 

		theme_advanced_toolbar_location : "top",

		theme_advanced_toolbar_align : "left",
		width:"500" ,
		height:"400",
		language : "fr"
	});
</script>

<table style="width:80%; margin: auto;">
	<tr>
		<th>Entête</th>
		<th>Pied</th>
	</tr>
	<tr>
		<td>
			<form action="change_haut_page.php" method="post">
				<textarea style="width: 100%;" name="content"><?php echo $res['texte_haut']; ?></textarea>
				<input name="send" type="submit" value="Actualiser" />
			</form>
		</td>
		<td>
			<form action="change_bas_page.php" method="post">
				<textarea style="width: 100%;" name="content"><?php echo $res['texte_bas']; ?></textarea>
				<input name="send" type="submit" value="Actualiser" />
			</form>
		</td>
	</tr>
</table>