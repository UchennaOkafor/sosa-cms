<?php

use Cms\Database\Config\Database;

include "../../api/db/Database.php";

$db = Database::getInstance();
$db->errorInfo();

//Use this to perform checks to see if server can connect to database. if it cannot show an error page and die.