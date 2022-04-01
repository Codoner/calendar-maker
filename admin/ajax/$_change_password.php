<?php
/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require realpath(dirname(__FILE__)) . '/../../assets/vendors/calendarmaker/class/calendarMaker.php';

$id         = filter_input(INPUT_POST, "idUser", FILTER_SANITIZE_NUMBER_INT);
$pass       = filter_input(INPUT_POST, "newPassword", FILTER_SANITIZE_STRING);

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();

$arr = [];
$arr['id']      = $id;
$arr['pass']    = $pass;
$arr['action']  = 'change';

echo json_encode( $cA->changePwd($arr) );