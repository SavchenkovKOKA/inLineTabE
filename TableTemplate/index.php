<html lang="ru">
    <head>
        <meta charset="utf-8" />
        <title>Таблица пользователей</title>
        <link rel="stylesheet" href="libs/css/styles.css">
        <script src="libs/js/jquery-2.2.0.min.js"></script>
        <script src="libs/js/Scripts.js"></script>
        <script>
            
        </script>
    </head>
    <body>
        <div id="inputsfiels">
            <form id="regform"  method="post">
                <p> Имя*</p>
                <p><input id="nameInput" type="text" required name="name" /></p>
                <p>Возраст* </p>
                <p><input id="ageInput" type="text" required name="age" /></p>
                <p>Город </p>
                <p><input id ="cityInput" type="text" name="city"/></p>
                <p><button type="button"  class="myButton"id="formbutt">Добавить</button></p>
            </form>
        </div>
        <div id="main">
            <table  id="UserTable"class="tbl-qa">
                <thead>
                    <tr>
                        <th class="table-header" width="10%">ID</th>
                        <th class="table-header">Имя</th>
                        <th class="table-header">Возраст</th>
                        <th class="table-header">Город</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($userList as $k => $v) {
                        ?>
                        <tr class="table-row">
                            <td><?php echo $userList[$k]->getId(); ?></td>
                            <td><div tabindex="-1" contentEditable id=<?php echo $k . "name" ?> onblur="setTimeout(saveToDatabase('<?php echo $k . "name" ?>','Имя','<?php echo $userList[$k]->getId(); ?>'),200)"><?php echo $userList[$k]->getUsername(); ?></div></td>
                            <td><div tabindex="-1" contentEditable id=<?php echo $k . "age" ?>  onblur="setTimeout(saveToDatabase('<?php echo $k . "age" ?>','Возраст','<?php echo $userList[$k]->getId(); ?>'),200)"><?php echo $userList[$k]->getAge(); ?></div></td>
                            <td><div class="dropdown">
                                    <a href="#" id="<?php echo $k . "drop"; ?>" class="dropbtn"><?php echo $userList[$k]->getCity(); ?></a>
                                    <div class="dropdown-content">
                                        <?php
                                        foreach ($city_array as $s => $city) {
                                            ?>
                                            <a href="#" onclick="saveToDatabaseCity('<?php echo $city; ?>', 'Город', '<?php echo $userList[$k]->getId(); ?>', '<?php echo $k . "drop"; ?>')"><?php echo $city ?></a>
                                        <?php } ?>

                                    </div>
                                </div>	</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
