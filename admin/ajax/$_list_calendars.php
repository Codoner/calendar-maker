<?php
/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require realpath(dirname(__FILE__)) . '/../../assets/vendors/calendarmaker/class/calendarMaker.php';

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();
$cals = $cA->getCalendar(null, "all");

if($cals['status'] === false) { echo json_encode(["status" => false, "msg" => $cals['msg'], "data" => [0 => ["ID" => "n/a", "Name" => "n/a", "TxColor" => "n/a", "BgColor" => "n/a", "Actions" => "n/a", "UUID" => "n/a"]] ]); exit; }
if($cals['calendar'] == null ){ echo json_encode(["status" => true, "data" => [] ]); exit; }

for($i=0; $i<count($cals['calendar']); $i++){
    $arr[] = [
        "ID" => "&nbsp;".$cals['calendar'][$i]['id'],
        "Name" => $cals['calendar'][$i]['name'],
        "Lang" => $cals['calendar'][$i]['language'],
        "TxColor" => "<i class='fa fa-stop' style='color:".$cals['calendar'][$i]['textColor']."'></i>&nbsp;" . $cals['calendar'][$i]['textColor'],
        "BgColor" => "<i class='fa fa-stop' style='color:".$cals['calendar'][$i]['bgColor']."'></i>&nbsp;" . $cals['calendar'][$i]['bgColor'],
        "Actions" => "<a class='buttonLink view' href='./view-calendar.php?uuid=".$cals['calendar'][$i]['uuid']."'>view</a><a class='buttonLink edit' href='./edit-calendar.php?uuid=".$cals['calendar'][$i]['uuid']."'>edit</a><a class='buttonLink delete' href='javascript:deleteCal(".$cals['calendar'][$i]['id'].")'>delete</a>",
        "UUID" => $cals['calendar'][$i]['uuid']
    ];
}
echo json_encode(["status" => true, "data" => $arr]);