<?php
/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require realpath(dirname(__FILE__)) . '/../../assets/vendors/calendarmaker/class/calendarMaker.php';

$user       = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$pass       = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();

$arr = [];
$arr['user']    = $user;
$arr['pass']    = $pass;

echo json_encode( $cA->loginUser($arr) );