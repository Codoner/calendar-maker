<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require realpath(dirname(__FILE__)) . '/../assets/vendors/calendarmaker/class/calendarMaker.php';

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();

$cA->logout();
header("location: ".LOGIN_PAGE);