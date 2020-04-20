<?php
/**
 * Title: CSUNVB
 * USER: marwan.alhelo
 * DATE: 13.02.2020
 * Time: 11:29
 **/
ob_start();
$title = "CSU-NVB - Tâches hebdomadaires";

$days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

?>
<h1 class="center p-4"><?= $title ?></h1>
<div class="week text-center">


        <?php
        foreach ($datesoftheweek as $index => $onedate){
            echo "<div class='bg-primary text-white day hour col-md h4 font-weight-bold'>{$days[$index-1]}<br>".date("Y-m-d", $onedate)." </div>";
        }
        ?>

</div>

<div class="week border border-dark">


    <div class="day col-md">

        <?php  foreach ($dayThingsForSunday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>

    <div class="day col-md">

        <?php  foreach ($dayThingsForMonday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
    <div class="day col-md">
        <?php  foreach ($dayThingsForTuesday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
    <div class="day col-md">
        <?php  foreach ($dayThingsForWednesday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
    <div class="day col-md">
        <?php  foreach ($dayThingsForThursday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
    <div class="day col-md">
        <?php  foreach ($dayThingsForFriday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
    <div class="day col-md">
        <?php  foreach ( $dayThingsForSaturday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
</div>

<div class="week border border-dark">
    <div class="day col-md">

        <?php  foreach ($nightThingsForSunday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>

    <div class="day col-sm">

        <?php  foreach ($nightThingsForMonday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
    <div class="day col-md">
        <?php  foreach ($nightThingsForTuesday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
    <div class="day col-md">
        <?php  foreach ($nightThingsForWednesday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
    <div class="day col-md">
        <?php  foreach ($nightThingsForThursday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
    <div class="day col-md">
        <?php  foreach ($nightThingsForFriday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
    <div class="day col-md">
        <?php  foreach ($nightThingsForSaturday as $thing) { ?>
            <a href="?action=Edittodo&<?= $thing['id'] ?> " class="over"><div class="hour"><?= $thing['description'] ?></div> </a>
        <?php }?>
    </div>
</div>

<?php
$content = ob_get_clean();
require "view/gabarit.php";
?>
