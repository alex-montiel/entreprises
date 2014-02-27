<fieldset id="zone_liste_agence">
    <legend>Liste des agences</legend>
    <div id="liste_agence" class ="liste_agence">
        <table id="tableau_agence">
            <th></th>
            <th style="width: 100px;">Numero</th>
            <th style="width: 200px;">Nom</th>
            <th style="width: 200px;">Ville</th>
            <th style="width: 200px;">Telephone</th>
            <th style="width: 200px;">E-Mail</th>
    <?php

        $requete = "SELECT * FROM agence";
        $resultat = mysql_query($requete);

        while($tableArray = mysql_fetch_assoc($resultat)){

            $id_agence = $tableArray['id_agence'];
            $nom_agence = $tableArray['nom_agence'];
            $ville_agence = $tableArray['ville_agence'];
            $tel_agence = $tableArray['tel_agence'];
            $mail_agence = $tableArray['mail_agence'];      
    ?>          
        <tr>
            <td></td>
            <td><?php echo $id_agence; ?></td>
            <td><?php echo $nom_agence; ?></td>
            <td><?php echo $ville_agence; ?></td>
            <td><?php echo $tel_agence; ?></td>
            <td><?php echo $mail_agence; ?></td>
        </tr>

    <?php
        }

    ?>
        </table>
    </div>
</fieldset>  