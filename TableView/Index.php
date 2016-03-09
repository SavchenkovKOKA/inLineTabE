<?php
require_once 'TableModel/Table.php';
$UTable = new UserDAO();
$userList = $UTable->getUsers();
$city_array = $UTable->GetAllUsersCities();
require 'TableTemplate/index.php';