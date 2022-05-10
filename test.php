<?php
include "common/test.php";

testEverything();

include "common/medewerker.php";
$obj = new Employees($database);

//debug_dump($obj);

$obj->print_select_employee();

$obj->print_select_employee(10002);

$obj->print_select_employee(10010);

$obj->print_option();
?>