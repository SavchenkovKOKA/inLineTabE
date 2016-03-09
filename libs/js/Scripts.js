function DropDownControll() {
    document.getElementById("myDropdown").classList.toggle("show");
}
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

function saveToDatabase(editLine, column, id) {

    var error = false;
    if (column === "Город") {
        var text = editLine;
    } else {
        var text = $('#' + editLine).text();
        if (!(/^[а-яА-ЯёЁa]+$/.test(text) && text.length <= 30) && column === "Имя") {
            error = true;
            alert('Неверный формат ввода. Для имени разрешается использовать только русские буквы.');
            location.reload();
        }
        if (!(/^(?:100|[1-9]\d|[6-9])$/.test(text) && text.length <= 30) && column === "Возраст") {
            error = true;
            alert('Неверный формат Возраста');
            location.reload();
        }
    }
    if (!error) {
        $.ajax({
            url: "TableContoller/Update.php",
            type: "POST",
            data: 'column=' + column + '&editval=' + text + '&id=' + id,
            success: function (data) {
                //alert('ok');
            }
        });
    }
}
function saveToDatabaseCity(editLine, column, id, element_id) {
    saveToDatabase(editLine, column, id);
    var ui = '#' + element_id;
    $(ui).text(editLine);
}
$(document).ready(function () {
    $("#nameInput").blur(function () {
        checkName(this);
    });
    $("#formbutt").click(function () {
        UpdateTable();
    });
    $("#ageInput").blur(function () {
        checkAge(this);
    });
    $("#cityInput").blur(function () {
        checkCity(this);
    });
    function checkName(elem) {
        if (elem.value !== '') {
            if (!((/^[а-яА-ЯёЁa]+$/.test(elem.value)
                    && elem.value.length <= 30)) || elem.value === '') {
                alert('Неверный формат ввода.' +
                        ' Для имени разрешается использовать только русские буквы.');
                elem.value = '';
            }
        }
    }
    function checkAge(elem) {
        if (this.value !== '') {
            if (!(/^(?:100|[1-9]\d|[6-9])$/.test(elem.value)
                    && elem.value.length <= 30)) {
                alert('Неверный формат Возраста.');
                elem.value = '';
            }
        }
    }
    function checkCity(elem) {
        if (elem.value !== '') {
            if (!(/^[а-яА-ЯёЁa]+$/.test(elem.value)
                    && elem.value.length <= 30)) {
                alert('Неверный формат ввода.' +
                        'Для Города разрешается использовать только русские буквы.');
                elem.value = '';
            }
        }
    }
    function UpdateTable() {
        if ( $("#nameInput").val().length ==0 ||$("#ageInput").val().length ==0) {
            alert("Имеются незаполненные поля ввода");
        } else {
            $.ajax({
                url: "TableContoller/Add.php",
                type: "POST",
                data: 'name=' + $("#nameInput").val() + '&age=' + $("#ageInput").val() + '&city=' + $("#cityInput").val(),
                success: function (data) {
                    $('#regform')[0].reset();
                    location.reload();
                }
            });
        }
    }
});