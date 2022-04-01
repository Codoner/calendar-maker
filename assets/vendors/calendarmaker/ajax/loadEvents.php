<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
header("Cache-Control: no-cache, must-revalidate");

require dirname(__FILE__) . '/../class/calendarMaker.php';

$arr = [];
$arr['start']       = filter_input(INPUT_GET, "start", FILTER_SANITIZE_STRING);
$arr['end']         = filter_input(INPUT_GET, "end", FILTER_SANITIZE_STRING);
$arr['timeZone']    = filter_input(INPUT_GET, "timeZone", FILTER_SANITIZE_STRING);
$arr['lang']        = filter_input(INPUT_GET, "lang", FILTER_SANITIZE_STRING);
$arr['uuid']        = filter_input(INPUT_GET, "uuid", FILTER_SANITIZE_STRING);
$arr['category']    = filter_input(INPUT_GET, "category", FILTER_SANITIZE_STRING);

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();

echo json_encode( $cA->loadEvents($arr) );