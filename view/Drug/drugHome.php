<?php
// David Roulet - Fabien Masson
// Projet CSU-NVB A1
// Drugs Section
ob_start();
$title = "CSU-NVB - Stupéfiants";
$year = 20;
?>
<div class="row m-2">
    <h1>Stupéfiants</h1>
</div>

<FORM action="/index.php?action=drugHomePage" method="post">
    <SELECT name="site" size="1">
        <OPTION value="4" <?php if($_SESSION["username"][1]=="Payerne"){?> selected="selected" <?php }?> >Payerne
        <OPTION value="1" <?php if($_SESSION["username"][1]=="Yverdon"){?> selected="selected" <?php }?>>Yverdon
        <OPTION value="3" <?php if($_SESSION["username"][1]=="Saint-Loup"){?> selected="selected" <?php }?>>Saint-Loup
        <OPTION value="2" <?php if($_SESSION["username"][1]=="Sainte-Croix"){?> selected="selected" <?php }?>>Sainte-Croix
        <OPTION value="5" <?php if($_SESSION["username"][1]=="Vallée-de-Joux"){?> selected="selected" <?php }?>>Vallée-de-Joux
    </SELECT>
    <button type="submit">Recharger</button>
</FORM>


<div class="row m-2">
        <?php
        $liste = getStupSheets();
        foreach ($liste as $item) {
            if ($item["base_id"] == $_SESSION["Selectsite"]) {
                $weeks[] = $item;
            }
        } ?>
    </div>

<div class="row">
    <table class="table table-bordered">
        <thead>
        <th>Date</th>
        <th>État</th>
        </thead>
        <tbody>
        <?php foreach ($weeks as $week) { ?>
            <tr>
                <form action="/index.php?action=drugSiteTable" method="post">
                    <td><button class ="btn" name="semaine" value="<?= $week["week"] ?>"> <?php echo $week["week"] ?> </button></td><td><?=$week['state']?></td>
                </form>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
require "view/gabarit.php";
?>
