<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 Codoner
 */

namespace ToolsMakers;
if(!isset($_SESSION)){ session_start(); }

require realpath(dirname(__FILE__)) . '/../assets/vendors/calendarmaker/class/calendarMaker.php';

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();
$cA->accessPage();
header("Location: "._DIR_BE."/list-calendar.php");