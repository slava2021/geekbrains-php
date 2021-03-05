<?php
//  Выводим ошибки в любом случае, для отладки кода
declare(strict_types=1);

ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <?php
    // ДЗ1
    // 3. Объяснить, как работает данный код:
    // $a = 5;
    // $b = '05';
    // var_dump($a == $b);         // Почему true? Переменные a и b число и строка равны. Сравнение выполняется по значениию.
    //Есть еще сравнение по значению и типу "===", тогда будет false.
    //Так же PHP не требуется указивать тип переменной, при необходимостимости можно задать тип переменной.
    // var_dump((int)'012345');     // Почему 12345? В данной функции число преобразуется в целое, 0 удаляется.
    // var_dump((float)123.0 === (int)123.0); // Почему false? Выполняется сравнение числа с плавающей точкой и целого, пожтому результат false
    // var_dump((int)0 === (int)'hello, world'); // Почему true? Строка проебразуется в целое число функция int, т.е. в строке отсутствует символ 
    // число (при этом число должно быть первым символом), поэтому = 0, поэтому
    //при сравнении по значению и типу, данные значения будут равны.

    // 5. *Используя только две переменные, поменяйте их значение местами. Например, если a = 1, b = 2, надо,
    //  чтобы получилось: b = 1, a = 2. Дополнительные переменные использовать нельзя.
    // $a = 2;
    // $b = 7;
    // echo "<br>a = " . $a . " b = " . $b . "<br>--------------<br>";
    // $a += $b;
    // // echo "a = " . $a . "<br>";
    // $b = $a - $b;
    // echo "b = " . $b . "<br>";
    // $a -= $b;
    // echo "a = " . $a;

    // ДЗ2
    // 1. Объявить две целочисленные переменные $a и $b и задать им произвольные начальные
    //  значения. Затем написать скрипт, который работает по следующему принципу:
    // если $a и $b положительные, вывести их разность;
    // если $а и $b отрицательные, вывести их произведение;
    // если $а и $b разных знаков, вывести их сумму;
    // ноль можно считать положительным числом.
    $a = rand(-10, 10);
    $b = rand(-10, 10);
    echo "a = " . $a . " | b = " . $b;
    if ($a >= 0 && $b >= 0) {
        echo "<br>a - b = " . $sum = $a - $b;
    } else if ($a < 0 && $b < 0) {
        echo "<br>a * b = " . $sum = $a * $b;
    } else {
        echo "<br>a + b = " . $sum = $a + $b;
    }
    // 2. Присвоить переменной $а значение в промежутке [0..15].
    // С помощью оператора switch организовать вывод чисел от $a до 15.

    $a = rand(0, 10);
    echo "<br>a = " . $a;
    switch ($a) {
        case 0:
            echo "<br>0";
        case 1:
            echo "<br>1";
        case 2:
            echo "<br>2";
        case 3:
            echo "<br>3";
        case 4:
            echo "<br>4";
        case 5:
            echo "<br>5";
        case 6:
            echo "<br>6";
        case 7:
            echo "<br>7";
        case 8:
            echo "<br>8";
        case 9:
            echo "<br>9";
        case 10:
            echo "<br>10";
            break;
    }
    // 3. Реализовать основные 4 арифметические операции в виде функций с двумя параметрами.
    //  Обязательно использовать оператор return.
    $a = rand(-10, 10); // Переопределяем переменные a и b заново
    $b = rand(-10, 10);

    function sum($a, $b)
    {
        return $sum = $a + $b;
    }

    function sub($a, $b)
    {
        return $sum = $a - $b;
    }

    function mult($a, $b)
    {
        return $sum = $a * $b;
    }
    function div($a, $b)
    {
        return $sum = $a / $b;
    }

    // echo "<br>sum = " . sub($a, $b); // проверяем результат

    // 4. Реализовать функцию с тремя параметрами:
    //  function mathOperation($arg1, $arg2, $operation),
    //  где $arg1, $arg2 – значения аргументов,
    //  $operation – строка с названием операции.
    //  В зависимости от переданного значения операции выполнить одну
    //  из арифметических операций (использовать функции из пункта 3)
    //  и вернуть полученное значение (использовать switch).
    $operation = ["+", "-", "*", "/"];
    $arg1 = rand(0, 10); // Переопределяем переменные a и b заново
    $arg2 = rand(0, 10);
    $rnd = rand(0, (count($operation) - 1));

    $operation = $operation[$rnd];
    echo '<br>$arg1 = ' . $arg1 . ' | $arg2 = ' . $arg2 . " | operation = " . $operation;
    function mathOperation($arg1, $arg2, $operation)
    {
        switch ($operation) {
            case '+':
                $sum = sum($arg1, $arg2);
                break;
            case '-':
                $sum = sub($arg1, $arg2);
                break;
            case '*':
                $sum = mult($arg1, $arg2);
                break;
            case '/':
                $sum = div($arg1, $arg2);
                break;
        }
        return $sum;
    }
    echo "<br>sum = " . mathOperation($arg1, $arg2, $operation);
    ?>

</body>

</html>