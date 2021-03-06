<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 **/

require_once 'model/shiftEndModel.php';
require_once 'model/adminModel.php';

function shiftEndHomePage()
{
    $TitlesLines = getGuardLines();
    $Titles = getSectionsTitles();
    require_once 'view/viewsShiftEnd/shiftEndHome.php';
}

function listShiftEnd($base_id)
{
    $Bases = getbases();
    $list = getGuardSheetsByBase($base_id);
    require_once 'view/viewsShiftEnd/ListShiftEnd.php';
}
?>
