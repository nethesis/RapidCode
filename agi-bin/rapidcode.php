#!/usr/bin/env php
<?php

#
#    Copyright (C) 2017 Nethesis S.r.l.
#    http://www.nethesis.it - support@nethesis.it
#
#    This file is part of RapidCode FreePBX module.
#
#    RapidCode is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or any 
#    later version.
#
#    RapidCode is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with RapidCode.  If not, see <http://www.gnu.org/licenses/>.
#

include_once ("/etc/freepbx.conf");
define("AGIBIN_DIR", "/var/lib/asterisk/agi-bin");
define("DEBUG", "FALSE");
include(AGIBIN_DIR."/phpagi.php");

global $db;
$agi = new AGI();


