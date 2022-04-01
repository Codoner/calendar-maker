<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
header('Content-Type: text/html; charset=utf-8');

require dirname(__FILE__) . '/../class/calendarMaker.php';

$id         = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$uuid       = filter_input(INPUT_POST, "uuid", FILTER_SANITIZE_STRING);

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();

echo json_encode( $cA->getEvent($id, $uuid) );