<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require dirname(__FILE__) . '/../class/calendarMaker.php';

$id         = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$eventDate  = filter_input(INPUT_POST, "eventDate", FILTER_SANITIZE_STRING);
$lang       = filter_input(INPUT_POST, "lang", FILTER_SANITIZE_STRING);
$uuid       = filter_input(INPUT_POST, "uuid", FILTER_SANITIZE_STRING);

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();

echo json_encode( $cA->deleteEvent($id, $eventDate, $uuid) );