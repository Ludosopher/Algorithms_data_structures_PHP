<?php
class FileExtensionFilter extends FilterIterator
{
    public function accept() { // фильтр для удаления из списка содержимого директорий ".", ".." и папок, которые начинаются с ".".
        $dot = $this->isDot();
        $name = $this->__toString();
        return !$dot && substr($name,0,1) !== '.';
    }
}

$dir = new FileExtensionFilter(new DirectoryIterator("./img")); // создание отфильтрованной корневой директории (img) в случае если массив $_GET пуст

if ($_GET['el']) {

    $dir = new FileExtensionFilter(new DirectoryIterator("{$_GET['el']}")); // создание отфильтрованной дочерней директории при нажатии на её ссылку в родительской директории
    $back_path = substr($_GET['el'], 0, strripos($_GET['el'], '\\')); // получение адреса родительской директории относительно текущей
    if ($back_path) {echo "<a href ='./?el={$back_path}'>Назад</a>" . "<br><br>";} // вывод на страницу ссылки "назад"
    echo "<p>Текущая папка: \"<span><b>{$_GET['el']}</b></span>\"</p>" . "<br>"; // вывод на страницу названия текущей директории

} else {
     echo "<p>Текущая папка: \"<span><b>./img</b></span>\"</p>" . "<br>";
}

foreach ($dir as $item) { // вывод на страницу содержимого текущей директории

    if ($item->isDir()) {

        echo "<a href ='./?el={$item->getPathname()}'>{$item}</a>" . "<br>"; // вывод ссылки на директорию внутри текущей директории

    } else {
         echo "<a href ='{$item->getPathname()}'>{$item}</a>" . "<br>"; // вывод ссылки на файл внутри текущей директории
     }
}