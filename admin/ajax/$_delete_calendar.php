<?php
/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require realpath(dirname(__FILE__)) . '/../../assets/vendors/calendarmaker/class/calendarMaker.php';

$id         = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();
echo json_encode( $cA->deleteCalendar($id) );