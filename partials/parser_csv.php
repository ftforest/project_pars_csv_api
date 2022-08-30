<?php
echo "page: parser-csv<br>\n";
?>

<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
<form enctype="multipart/form-data" action="/parser-csv" method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Отправить этот файл: <input name="userfile" type="file" />
    <input type="submit" name="submit" value="Отправить файл" />
</form>

<?php
// var
$simple_view = false; // простое отображение
// actions
if (isset($_POST['submit'])) {
    $model = new ModelAktikom();
    if ($_FILES['userfile']['tmp_name'] != '') {
        $model->read_file_in_array($_FILES['userfile']['tmp_name']);
    } else {
        $model->read_file_in_array("./upload/".$_FILES['userfile']['name']);
    }
    $model->view($simple_view,5);
}
?>
