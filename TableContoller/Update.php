<?php
require '../TableModel/Table.php';
$UTable = new UserDAO();
$id = htmlspecialchars($_REQUEST['id']);
$value = $_REQUEST['editval'];
error_log($_REQUEST['editval']);
$column = htmlspecialchars($_REQUEST['column']);
$EditableUser = $UTable->getByUserId($id);
switch ($column) {
    case "Имя":
        $EditableUser[0]->setUsername($value);
        $UTable->save($EditableUser[0]);
        break;
    case "Возраст":
        $EditableUser[0]->setAge($value);
        $UTable->save($EditableUser[0]);
        break;
    case "Город":
        $EditableUser[0]->setCity($value);
        $UTable->save($EditableUser[0]);
        break;
}
