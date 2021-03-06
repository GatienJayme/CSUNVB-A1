<?php
session_start();

// Include all controllers
require "controler/adminControler.php";
require "controler/shiftEndControler.php";
require "controler/todoListControler.php";
require "controler/drugControler.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION["Selectsite"] = $_POST['base'];
    $baselogin = $_POST['base'];
    $_SESSION['site'] = $_POST['base'];
}
if (isset($_POST["LogStup"])) {
    $Stupheet = $_POST["LogStup"];
}

if (isset($_POST["semaine"])) {
    $semaine = $_POST["semaine"];
}
if (isset($_POST["site"])) {
    $_SESSION["Selectsite"] = $_POST["site"];
}
if (isset($_GET["batchtoupdate"]) && isset($_GET["PharmaUpdateuser"]) && isset($_GET["sheetid"]) && isset($_POST["Pharmastart"]) && isset($_POST["Pharmaend"])) {
    $batchtoupdate = $_GET["batchtoupdate"];
    $PharmaUpdateuser = $_GET["PharmaUpdateuser"];
    $sheetid = $_GET["sheetid"];
    $Pharmaend = $_POST["Pharmaend"];
    $Pharmastart = $_POST["Pharmastart"];
    $date = $_GET["date"];
}
$action = $_GET['action'];
if (isset($_SESSION['username']) || $action == 'trylogin') {
    $action = $_GET['action'];
} else {
    $action = ' ';
}
if (isset($_GET["batch_id"])) {
    $pharmacheck_batch = $_GET["batch_id"];
}
if (isset($_GET["stupsheet_id"])) {
    $pharmacheck_sheetid = $_GET["stupsheet_id"];
}
if (isset($_GET["date"])) {
    $pharmacheck_date = $_GET["date"];
}
switch ($action) {
    case 'home' :
        require_once 'view/home.php';
        break;
    case 'admin':
        adminHomePage();
        break;
    case 'shiftend':
        shiftEndHomePage();
        break;
    case 'listShiftEnd':
        if (isset($_POST["site"])) {
            $base_id = $_POST["site"];
        } else {
            $base_id = $_SESSION['site'];
        }
        listShiftEnd($base_id);
        break;
    case 'disconnect':
        disconnect();
        break;
    case 'login':
        login();
        break;
    case 'todolist':

        if (isset($_POST['selectBase'])) {
            $selectedBase = $_POST['selectBase'];
        }else{
            $selectedBase = $_SESSION['username']['base']['id'];
        }
        todoListHomePage($selectedBase);
        break;
    case 'edittod':
        $sheetid = $_GET['sheetid'];
        edittodopage($sheetid);
        break;


    case 'drugs':
        drugHomePage();
        break;
    case "drugSiteTable":
        drugSiteTable($semaine);
        break;
    case "trylogin":
        trylogin($username, $password, $baselogin);
        break;
    case 'LogStup':
        LogStup($Stupheet);
        break;
    case 'adminCrew' :
        adminCrew();
        break;
    case 'adminBases' :
        adminBases();
        break;
    case 'adminNovas' :
        adminNovas();
        break;
    case 'updatePharmaCheck':
        pharmacheck($pharmacheck_sheetid, $pharmacheck_date, $pharmacheck_batch);
        break;
    case 'adminDrugs' :
        adminDrugs();
        break;
    case "PharmaUpdate":
        PharmaUpdate($batchtoupdate, $PharmaUpdateuser, $Pharmastart, $Pharmaend, $sheetid,$date);
        break;
    case 'changeUserAdmin' :
        $changeUser = $_GET['idUser'];
        changeUserAdmin($changeUser);
        break;
    case 'newUser' :
        newUser();
        break;
    case 'saveNewUser' :
        $prenomUser = $_POST['prenomUser'];
        $nomUser = $_POST['nomUser'];
        $initialesUser = $_POST['initialesUser'];
        $adminUser = $_POST['adminUser'];
        saveNewUser($prenomUser, $nomUser, $initialesUser, $adminUser);
        break;
    case 'changeFirstPassword' :
        $passwordchange = $_POST['passwordchange'];
        $confirmpassword = $_POST['confirmpassword'];
        changeFirstPassword($passwordchange, $confirmpassword);
        break;
    case 'modifBase' :
        $modifBase = $_GET['modifbase'];
        modifBase($modifBase);
        break;
    case 'newBase' :
        newBase();
        break;
    case 'createBase' :
        $baseName = $_POST['baseName'];
        createBase($baseName);
        break;
    default: // unknown action
        if (isset($_SESSION['username'])) {
            require_once 'view/home.php';
        } else if ($_SESSION['username']['firstconnect'] == true) {
            require_once 'view/firstLogin.php';
        } else {
            require_once 'view/login.php';
        }
        break;
}

?>
