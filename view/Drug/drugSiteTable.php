<?php
// David Roulet - Fabien Masson
// Projet CSU-NVB A1
// Drugs Section
$title = "CSU-NVB - Stupéfiants";
ob_start();

?>
    <div class="row m-2">
        <h1>Stupéfiants</h1>
    </div>
<?php
$jourDebutSemaine = getdate2($semaine); // recupere les jours de la semiane en fonction de la date selectioné
$novas = getnovas(); // Obient la liste des ambulance
$drugs = getDrugs(); // Obient la list des Drugs
//$stupSheet=readSheet(2);
$stupSheet = GetSheetbyWeek($semaine, $_SESSION["Selectsite"]);
$date = strtotime($jourDebutSemaine);
$site = getbasebyid($_SESSION["Selectsite"])["name"];
?>
    <h2>Site de <?= $site ?> , Semaine N° <?= $semaine ?>
        <form action="/index.php?action=LogStup" method="post">
            <button class="btn-dark" name="LogStup" value="<?= $stupSheet["id"] ?>"
            </button>Log
        </form>
    </h2>


<?php


$jours = array("Lundi", "Mardi", "Mercredi", "Jeudi", "vendredi", "samedi", "dimanche");

foreach ($jours as $jour) { ?>
    <table border="1" class="table table-dark">
        <tr>
            <td colspan="6" <?php if (date("Y-m-d", $date) == date("Y-m-d")){ ?>class="today"
                <?php } ?> > <?php
                echo $jour . " " . date("j M Y", $date) ?></td>
            <?php
            $date = strtotime(date("Y-m-d", $date) . " +1 day");
            ?>
        </tr>
        <tr>
            <td></td>
            <td>Pharmacie</td>
            <?php foreach ($stupSheet["nova"] as $nova) {
                echo "<td>" . $nova . "</td>";
            } ?>
            <td>Pharmacie</td>
        </tr>

        <?php foreach ($stupSheet["Drug"] as $drug) {
        $Drugname = readDrug($drug["Drug_id"]); ?>
        <tr>
            <td><?= $Drugname["name"] ?></td>
            <td></td>
            <td></td>

            <?php foreach ($stupSheet["nova"] as $nova) { ?>
                <td></td>
            <?php } ?>
        </tr>

        <?php

        foreach ($drug["batch_number"]["number"]["number2"] as $batch) {  //met dans $batch les numeros des batch
            ?>
        <tr>
            <td><?= $batch ?></td>
            <td><?php

                foreach ($stupSheet["Drug"][$drug["Drug_id"]]["batch_number"]["number"][$batch] as $checkpharma) { //foreach des pharmacheck par batch
                    if ($checkpharma["date"] == (date("Y-m-d", $date))) { //verifie si la date correspond a celle du fichier
                        echo $checkpharma["start"];
                    }
                }

                ?></td>

            <?php foreach ($stupSheet["nova"] as $nova) { ?>
                <td></td>
            <?php } ?>
            <td>

                <?php

                foreach ($stupSheet["Drug"][$drug["Drug_id"]]["batch_number"]["number"][$batch] as $checkpharma) { //foreach des pharmacheck par batch
                    if ($checkpharma["date"] == (date("Y-m-d", $date))) { //verifie si la date correspond a celle du fichier
                        echo $checkpharma["end"];
                    }
                }
                ?>
            </td>

            <?php }
            } ?>

        <tr>
            <td>Signature</td>
            <td colspan="5"></td>
        </tr>
    </table>
<?php }
$content = ob_get_clean();
require "view/gabarit.php";

?>