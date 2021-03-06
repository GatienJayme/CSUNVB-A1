<?php
/**
 * Auteur: David Roulet / Fabien Mason
 * Date: Aril 2020
 **/


/**
 *  Retours les sheet en fonction de la semaine et de la base
 *
 */
function GetSheetbyWeek($week, $base)
{
    $Sheets = getStupSheets();
    foreach ($Sheets as $Sheet) {
        if ($Sheet["week"] == $week && $Sheet["base_id"] == $base) {
            return $Sheet;

        }
    }
}

/**
 * Retours tout les fichiers des semaines avec les nova qui corresonde et les batch ainsi que les pharma check pour chaqun des batch
 */
function getStupSheets()
{
    $novasheets = getstupnova(); // nova utilisé par sheet
    $Sutupbatchs = getsutpbatch(); // batch utiilisé par les sheet
    $pharmachecks = getpharmachecks(); // donée pharmatice
    $drug = getDrugs();
    $stupsheets = json_decode(file_get_contents("model/dataStorage/stupsheets.json"), true);

    foreach ($stupsheets as $stupsheet) {
        $SheetsArray[$stupsheet["id"]] = $stupsheet;
        foreach ($novasheets as $novasheet) {
            if ($novasheet["stupsheet_id"] == $stupsheet["id"]) {
                $nova = readnova($novasheet["nova_id"]);
                $SheetsArray[$stupsheet["id"]]["nova"][] = $nova;
            }
        }
        foreach ($Sutupbatchs as $Sutupbatch) //met dans $sheetsArray les batchs en fonction de la semaine et de la drogue
        {
            if ($Sutupbatch["stupsheet_id"] == $stupsheet["id"]) {
                $batch = readbatche($Sutupbatch["batch_id"]);
                if ($batch["drug_id"] != null) {
                    $SheetsArray[$stupsheet["id"]]["Drug"][$batch["drug_id"]]["batch_number"]["number"]["number2"][] = $batch;
                    $SheetsArray[$stupsheet["id"]]["Drug"][$batch["drug_id"]]["Drug_id"] = $batch["drug_id"];
                    foreach ($pharmachecks as $pharma) {
                        if ($pharma["batch_id"]==$batch["id"]&&$pharma["stupsheet_id"]==$stupsheet["id"])
                        {
                            $SheetsArray[$stupsheet["id"]]["Drug"][$batch["drug_id"]]["batch_number"]["number"][$batch["number"]][] = $pharma;
                        }
                    }


                }
            }
        }
    }
    return $SheetsArray;
}

/**
 * Obient un restock en fonction de la batch et de la nova
 */

function getRestocksbyBatchandNovas($batch_id,$nova_id)
{
    $restocks = getrestocks();
    foreach ($restocks as $restock)
    {
        if($batch_id == $restock["batch_id"] && $nova_id == $restock["nova_id"])
        {
            return $restock;
        }
    }
}


/**
 * Retourne un item précis, identifié par son id
 * ...
 */
function readSheet($id)
{
    $SheetsArray = getStupSheets();
    $Sheet = $SheetsArray[$id];
    return $Sheet;
}

/**
 * Sauve l'ensemble des items dans le fichier json
 * et enleve les elements en trop
 */
function updateSheets($items)
{
    foreach ($items as $item) {
        unset($items[$item["id"]]["Drug"]);
        unset($items[$item["id"]]["nova"]);
    }
    file_put_contents("model/dataStorage/stupsheets.json", json_encode($items));
}

/**
 * Modifie un item précis.
 * Le paramètre $item est un item complet (donc un tableau associatif)
 * ...
 */
function updateSheet($item)
{
    $sheets = getStupSheets();
    $sheets[$item["id"]] = $item;
    updateSheets($sheets);
}

/**
 * Détruit un item précis, identifié par son id
 * ...
 */
function destroySheet($id)
{
    $items = getStupSheets();
    unset($items[$id]);
    updateSheets($items);
}

/**
 * Ajoute un nouvel item
 * Le paramètre $item est un item complet (donc un tableau associatif), sauf que la valeur de son id n'est pas valable
 * puisque le modèle ne l'a pas encore traité
 * ...
 */
function createSheet($item)
{
    $items = getStupSheets();
    $newid = max(array_keys($items))+1;
    $item["id"] = $newid ;
    $items[] = $item;
    updateSheets($items);
    return $item;
}

/**
 * Retours la liste de tout les items
 */
function getBatches()
{
    $Array = json_decode(file_get_contents("model/dataStorage/batches.json"), true);
    foreach ($Array as $p) {
        $SheetsArray[$p["id"]] = $p;
    }
    return $SheetsArray;
}
/**
 * Retourne un item précis, identifié par son id
 * ...
 */
function readbatche($id)
{
    $SheetsArray = getBatches();
    $Sheet = $SheetsArray[$id];
    return $Sheet;
}
/**
 * Sauve l'ensemble des items dans le fichier json
 * ...
 */
function updateBatches($items)
{
    file_put_contents("model/dataStorage/batches.json", json_encode($items));
}

/**
 * met un jours un item precis
 */
function updateBatche($item)
{
    $sheets = getBatches();
    $sheets[$item["id"]] = $item;
    updateBatches($sheets);
}

/**
 * Crée un item et l ajoute au fichier
 */
function createbatch($item)
{
    $items = getBatches();
    $newid = max(array_keys($items))+1;
    $item["id"] = $newid;
    $items[] = $item;
    updateBatches($items);
    return $item;
}

/**
 *Retours une batches avec son numero
 *
 */
function FindBatchewhitNumber($number)
{
    $batches = getBatches();
    foreach ($batches as $batch) {
        if ($batch["number"] == $number) {
            return $batch;
        }
    }
}

/**
 * Suprime un item en fonction de son id
 */
function destroybatch($id)
{
    $items = getBatches();

    unset($items[$id]);
    updateBatches($items);

}
/**
 * Retours la liste de tout les items
 */
function getnovas()
{
    $Array = json_decode(file_get_contents("model/dataStorage/novas.json"), true);
    foreach ($Array as $p) {
        $SheetsArray[$p["id"]] = $p;
    }
    return $SheetsArray;
}
/**
 * Retourne un item précis, identifié par son id
 * ...
 */
function readnova($id)
{
    $SheetsArray = getnovas();
    $Sheet = $SheetsArray[$id];
    return $Sheet;
}

/**
 * Sauve l'ensemble des items dans le fichier json
 * ...
 */
function updatenovas($items)
{
    file_put_contents("model/dataStorage/novas.json", json_encode($items));
}

/**
 * Met un jours un item précis
 */
function updateNova($item)
{
    $sheets = getnovas();
    $sheets[$item["id"]] = $item;
    updatenovas($sheets);

}
/**
 * Crée un item et l ajoute au fichier
 */
function createnova($item)
{
    $items = getnovas();
    $newid = max(array_keys($items))+1;
    $item["id"] = $newid;
    $items[] = $item;
    updatenovas($items);
    return $item;
}

/**
 * supprime un item en fonction de son id
 *
 */
function destroyNova($id)
{
    $items = getnovas();
    unset($items[$id]);
    updatenovas($items);

}
/**
 * Retours la liste de tout les items
 * Avec toutes les batches assosier
 */
function getDrugs()
{
    $batches = getBatches();
    $Array = json_decode(file_get_contents("model/dataStorage/drugs.json"), true);
    foreach ($Array as $p) {
        $SheetsArray[$p["id"]] = $p;
    }
    foreach ($SheetsArray as $item) {
        foreach ($batches as $batch) {
            if ($item["id"] == $batch["drug_id"]) {
                $SheetsArray[$item["id"]]["batches"][] = $batch["number"];
            }
        }
    }
    $sheets = $SheetsArray;
    foreach ($sheets as $item) {
        unset($sheets[$item["id"]]["batches"]);
    }
    updateDrugs($sheets);
    return $SheetsArray;
}

/**
 * Retourne un item précis, identifié par son id
 * ...
 */
function readDrug($id)
{
    $SheetsArray = getDrugs();
    $Sheet = $SheetsArray[$id];
    $batches = getBatches();
    foreach ($batches as $batch) {
        if ($id == $batch["drug_id"]) {
            $Sheet["batches"][] = $batch["number"];
        }
    }
    return $Sheet;
}

/**
 * Sauve l'ensemble des items dans le fichier json
 * ...
 */
function updateDrugs($items)
{
    unset($items["id"]["batches"]);
    file_put_contents("model/dataStorage/Drugs.json", json_encode($items));
}

/**
 * Met un jours un item precis en fonction de l'id
 */
function updateDrug($item)
{

    $sheets = getDrugs();
    $sheets[$item["id"]]["name"] = $item["name"];
    foreach ($sheets as $iteme) {
        unset($sheets[$iteme["id"]]["batches"]);
    }
    updateDrugs($sheets);
}

/**
 * Crée un nouvelle items et l ajoute au fichier
 */
function createDrug($item)
{
    $items = getDrugs();
    $newid = max(array_keys($items))+1;
    $item["id"] = $newid ;
    $items[] = $item;
    updateDrugs($items);
    return $item;
}

/**
 * supprmier un item précis en fonction de son id
 */
function destroyDrug($id)
{
    $items = getDrugs();
    unset($items[$id]);
    updateDrugs($items);

}

/**
 * obients tout la liste des items
 */
function getsutpbatch()
{
    $Array = json_decode(file_get_contents("model/dataStorage/stupsheet_use_batch.json"), true);
    foreach ($Array as $p) {
        $SheetsArray[$p["id"]] = $p;
    }
    return $SheetsArray;
}
/**
 * obients tout la liste des items
 */
function getstupnova()
{
    $Array = json_decode(file_get_contents("model/dataStorage/stupsheet_use_nova.json"), true);
    foreach ($Array as $p) {
        $SheetsArray[$p["id"]] = $p;
    }
    return $SheetsArray;
}
/**
 * obients un items precis en fonction de son batch,date,stupsheet_id
 */
function getpharmacheckbydateandbybatch($date,$batch,$stupsheet_id){
    $Array = getpharmachecks();
    foreach ($Array as $check) {
        if ($check["date"] == $date && $check["batch_id"] == $batch&&$check["stupsheet_id"]==$stupsheet_id) {
            return $check;
        }
    }
    return false;
}
/**
 * Retourne un item précis, identifié par son id
 * ...
 */
function readpharmacheck($id)
{
    $SheetsArray = getpharmachecks();
    if(isset( $SheetsArray[$id])){
    $base = $SheetsArray[$id];
    return $base;
    }else{
        return false;
    }
}
/**
 * Crée un enrgistrement d un item precis
 * ...
 */
function createpharmacheck($item)
{
    $items = getpharmachecks();
    $newid = max(array_keys($items))+1;
    $item["id"] = $newid;
    $items[] = $item;
    updatepharmachecks($items);
    return $item;
}
/**
 * Sauve l'ensemble des items dans le fichier json
 * ...
 */
function updatepharmachecks($items)
{
    file_put_contents("model/dataStorage/pharmachecks.json", json_encode($items));
}
/**
 * Savuase un item precis
 */
function updatepharmacheck($item)
{

    $sheets = getpharmachecks();
    $sheets[$item["id"]]["id"] = $item["id"];
    $sheets[$item["id"]]["date"] = $item["date"];
    $sheets[$item["id"]]["start"] = $item["start"];
    $sheets[$item["id"]]["end"] = $item["end"];
    $sheets[$item["id"]]["batch_id"] = $item["batch_id"];
    $sheets[$item["id"]]["user_id"] = $item["user_id"];
    $sheets[$item["id"]]["stupsheet_id"] = $item["stupsheet_id"];
    updatepharmachecks($sheets);
}
/**
 * obients tout la liste des items
 */
function getpharmachecks()
{
    $Array = json_decode(file_get_contents("model/dataStorage/pharmachecks.json"), true);
    foreach ($Array as $p) {
        $SheetsArray[$p["id"]] = $p;
    }
    return $SheetsArray;
}
/**
 * obients tout la liste des items
 */
function getrestocks()
{
    $Array = json_decode(file_get_contents("model/dataStorage/restocks.json"), true);
    foreach ($Array as $p) {
        $SheetsArray[$p["id"]] = $p;
    }
    return $SheetsArray;
}
/**
 * obients tout la liste des items en fonction de l'id de la stupsheet
 */
function getLogsBySheet($sheetid)
{
    $Array = json_decode(file_get_contents("model/dataStorage/logs.json"), true);
    foreach ($Array as $p) {
        $SheetsArray[$p["id"]] = $p;
    }
    foreach ($SheetsArray as $sheet) {
        if ($sheet["item_type"] == 1 && $sheet["item_id"] == $sheetid) {
            $user = readuser($sheet["author_id"]);
            $sheet["author"] = $user["initials"];
            $LogSheets[] = $sheet;
        }
    }
    return $LogSheets;
}
/**
 * Retourne un item précis, identifié par son id
 * ...
 */
function readuser($id)
{
    $SheetsArray = getUsers();
    foreach ($SheetsArray as $arry) {
        if ($id == $arry["id"]) {
            return $arry;
        }
    }

}

?>
