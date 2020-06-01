<?php

function even($num) // Определение чётности числа.
{
    if ($num % 2 == 0) return true;
}

function groupsSteps($cols, $rows) // Формирование последовательных групп шагов в развёртывании прямоугольной спирали при движении по горизонтали и вертикали между её углами.
    // Например, в спирали 3*3, имеющей вид: 123 такими группами шагов между углами будут: 1,2,3(3 шага); 4,5(2 шага); 6,7 (2 шага); 8,9 (2 шага).
    //                                       894
    //                                       765
    // Данная функция должна определить количество групп и их размер в шагах. В данном примере, мы должны получить в качестве результата массив [3,2,2,2].
{
    $spiralSize = $cols * $rows;
    $arr = [];
    $sum = 0;
    $evenMinus = 0;
    $oddMinus = 1;
    for ($i = 0; $sum < $spiralSize; $i++) { // Цикл заполнения массива групп.
        if (even($i)) {  // Определение группы шагов при движении по горизонтали квадратной спирали и её запись в итоговый массив.
            if ($cols - $evenMinus == 1) { // Если при движении по квадратной спирали незаполненной осталась область шириной лишь в одну колонку, то текущая группа становится последней и включает в себя всю оставшуюся сумму шагов
                $arr[] = $spiralSize - $sum;
                $sum = $spiralSize;
            } else {
                $arr[] = $cols - $evenMinus;
                $sum += $cols - $evenMinus;
            }
            $evenMinus++;
        }
        if (!even($i)) { // Определение группы шагов при движении по вертикали квадратной спирали и её запись в итоговый массив.
            if ($rows - $oddMinus == 1) { // Если при движении по квадратной спирали незаполненной осталась область высотой лишь в одну строку, то текущая группа становится последней и включает в себя всю оставшуюся сумму шагов
                $arr[] = $spiralSize - $sum;
                $sum = $spiralSize;
            } else {
                $arr[] = $rows - $oddMinus;
                $sum += $rows - $oddMinus;
            }
            $oddMinus++;
        }
    }
    return $arr;
}

function height ($pastEnd, $length) // Создание возрастающего на единицу массива.
{
    $arr = [];
    for ($i = 0; $i < $length; $i++) {
        $arr[] += $pastEnd + 1;
        $pastEnd++;
    }
    return $arr;
}

function decline ($pastEnd, $length) // Создание убывающнго на единицу массива.
{
    $arr = [];
    for ($i = 0; $i < $length; $i++) {
        $arr[] += $pastEnd - 1;
        $pastEnd--;
    }
    return $arr;
}

function retention ($pastEnd, $length) // Создание массива одинаковых чисел.
{
    $arr = [];
    for ($i = 0; $i < $length; $i++) {
        $arr[] += $pastEnd;
    }
    return $arr;
}

function dynamics ($pastTrend, $pastEnd, $group, $is_endGroup) // Выбор тренда (рост, снижение или неизменность значения) для текущей группы шагов
{
    $arr = [];
    if ($is_endGroup) { // Выбор и формироввание тренда для последней группы шагов спирали.
        if ($pastTrend == "нс") {
            $arr = height($pastEnd - 1, $group);
        }
        if ($pastTrend == "нр") {
            $arr = decline($pastEnd + 1, $group);
        }
        if ($pastTrend == "сн") {
            $arr = retention($pastEnd + 1, $group);
        }
        if ($pastTrend == "рн") {
            $arr = retention($pastEnd - 1, $group);
        }
    return $arr;
    }
    switch ($pastTrend) { // Выбор и формирование тренда для всех групп шагов спирали кроме последней.
        case "сн":
            $arr = height($pastEnd, $group);
            break;
        case "рн":
            $arr = decline($pastEnd, $group);
            break;
        case "нр" || "нс":
            $arr = retention($pastEnd, $group);
            break;
    }
    return $arr;
}

function changeTrendNum ($trendNum) // Определение для группы шагов индекса тренда в массиве трендов.
{
    if ($trendNum == 3) return 0;
    return $trendNum + 1;
}

function coordinates ($groups) // Определение координат шагов, последовательно формирующих спираль.
{
    $alterTrends = ['сн', 'нр', 'рн', 'нс']; // Варианты двух предшествующих текущей группе тенденций формирования координат точек спирали: 'сн' - снижение неизменность; 'нр' - неизменность рост; 'рн' - рост неизменность; 'нс' - неизменность снижение
                   // ['+', '0', '-', '0']
    $colTrendNum = 0;
    $rowTrendNum = 3;
    $colArr = [];
    $rowArr = [];
    $arr = [];
    $colPastEnd = 0;
    $rowPastEnd = 1;
    $isEndGroup = Null;
    for ($i = 0; $i < count($groups); $i++) { // Создание массива координат строк и столбцов шагов спирали через итерацию массива групп шагов

        if ($i == count($groups) - 1) { // Определение, является ли текущая группа последней.
            $isEndGroup = true;
        }
        // Определение последних двух трендов координат шагов спирали перед тегущей группой шагов; отдельно для строк и столбцов.
        $pastColTrend = $alterTrends[$colTrendNum];
        $pastRowTrend = $alterTrends[$rowTrendNum];
        // Формирование массивов координат шагов спирали текущей группы шагов; отдельно для строк и столбцов.
        $thisColArr = dynamics($pastColTrend, $colPastEnd, $groups[$i], $isEndGroup);
        $thisRowArr = dynamics($pastRowTrend, $rowPastEnd, $groups[$i], $isEndGroup);
        // Формирование общих массивов координат шагов спирали; отдельно для строк и столбцов.
        $colArr = array_merge($colArr, $thisColArr);
        $rowArr = array_merge($rowArr, $thisRowArr);
        // Фиксация последнего значения координат шагов в общих массивах координат после каждой итерации; отдельно для строк и столбцов.
        $colPastEnd = $thisColArr[count($thisColArr) - 1];
        $rowPastEnd = $thisRowArr[count($thisRowArr) - 1];
        // Формирование номера тренда для следующей группы шагов.
        $colTrendNum = changeTrendNum($colTrendNum);
        $rowTrendNum = changeTrendNum($rowTrendNum);
    }

    $arr = [$colArr, $rowArr]; // Создание одного массива, включающего в себя массив координат строк и массив координат колонок шагов спирали.
    return $arr;
}

function spiralArray ($coordinates) // Создание двумерного массива значений спирали.
{
    $spiralArr = [];
    $rowArr = $coordinates[1];
    $colArr = $coordinates[0];

    for ($i = 0; $i < count($coordinates[0]); $i++) {
        $rowCoord = $rowArr[$i] - 1;
        $colCoord = $colArr[$i] - 1;
        $spiralArr[$rowCoord][$colCoord] = $i + 1;
    }

    return $spiralArr;
}

function squareSpiral($columns, $rows) // Итоговая функция - создание двумерного массива шагов квадратной спирали снаружи внутрь и её вывод на экран.
{
    if ($columns == 0 || $rows == 0) echo "Ошибка! Число строк и колонок должно быть больше нуля.";

    $groups = groupsSteps($columns, $rows); // Формирование последовательных групп шагов в развёртывании прямоугольной спирали при движении снаружи внутрь. Группа шагов - это последовательность шагов в развёртывании прямоугольной спирали от одного угла до другого в соответствии с общим трендом (рост, снижение или сохранение значения).
    $coordinates = coordinates($groups); // Создание массивов координат шагов спирали на основе массива групп шагов и порядка чередования трендов (рост, снижение или сохранение значения).
    $spiralArray = spiralArray($coordinates); // Создание массива шагов прямоугольной спирали на основе массива её координат.
    // Вывод спирали на экран.
    echo "<table style = 'border: 1px solid Silver; border-collapse: collapse;'>";
    foreach ($spiralArray as $value) {
        ksort($value);
        echo "<tr>";
        foreach ($value as $val) {
            echo "<td style = 'border: 1px solid Silver; text-align: center; color: DarkSlateGrey;'>{$val}</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}


squareSpiral(4, 3);


