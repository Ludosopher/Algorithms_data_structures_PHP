<?php

function findBrackets ($string) { // поиск в заданной строке скобок (круглых, квадратных и фигурных) левых и правых и подсчёт их количества
    $brackets = [];
    foreach (count_chars($string, 1) as $i => $val) {
        switch (chr($i)) {
            case ("("):
                $brackets[0] = $val;
                break;
            case (")"):
                $brackets[1] = $val;
                break;
            case ("["):
                $brackets[2] = $val;
                break;
            case ("]"):
                $brackets[3] = $val;
                break;
            case ("{"):
                $brackets[4] = $val;
                break;
            case ("}"):
                $brackets[5] = $val;
                break;
        }
    }
    return $brackets;
}

function testBrackets($string) {  // Определение сбалансированности скобок в строке. Если количество левый и правых скобок неравно, значит баланс нарушен
    $brs = findBrackets($string);
    if ($brs[0] != $brs[1] || $brs[2] != $brs[3] || $brs[4] != $brs[5]) {
        return "Дисбаланс скобок в строке!";
    }
    return "Скобки в строке сбалансированы.";
}

$string = "{Проверить баланс} (скобок в выражении), [игнорируя любые внуренние символы].";

echo testBrackets($string);
