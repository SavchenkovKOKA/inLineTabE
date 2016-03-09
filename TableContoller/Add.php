<?php
require '../TableModel/Table.php';
mb_internal_encoding("UTF-8");
function mysql_fix_string($string)
{
if (get_magic_quotes_gpc()) $string = stripslashes($string);
return mysql_real_escape_string($string);
}
function mb_ucfirst($text) {
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}
$UTable= new UserDAO();
$User = new UserVO();

$User->setUsername(mb_ucfirst(mb_strtolower(htmlspecialchars(mysql_fix_string($_REQUEST['name'])))));
$User->setAge(htmlspecialchars(mysql_fix_string($_REQUEST['age'])));
$User->setCity(mb_ucfirst(mb_strtolower(htmlspecialchars(mysql_fix_string($_REQUEST['city'])))));
if(empty($_REQUEST['city'])){$User->setCity('Не указан');}
$UTable->save($User);

