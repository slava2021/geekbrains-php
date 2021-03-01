<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- <?php phpinfo() ?> -->

    <?php

    declare(strict_types=1);

    ini_set('error_reporting', (string)E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    // 3. Объяснить, как работает данный код:
    $a = 5;
    $b = '05';
    var_dump($a == $b);         // Почему true? Переменные a и b число и строка равны. Сравнение выполняется по значениию.
    //Есть еще сравнение по значению и типу "===", тогда будет false.
    //Так же PHP не требуется указивать тип переменной, при необходимостимости можно задать тип переменной.
    var_dump((int)'012345');     // Почему 12345? В данной функции число преобразуется в целое, 0 удаляется.
    var_dump((float)123.0 === (int)123.0); // Почему false? Выполняется сравнение числа с плавающей точкой и целого, пожтому результат false
    var_dump((int)0 === (int)'hello, world'); // Почему true? Строка проебразуется в целое число функция int, т.е. = 0, поэтому
    //при сравнении по значению и типу, данные значения будут равны.

    // 5. *Используя только две переменные, поменяйте их значение местами. Например, если a = 1, b = 2, надо,
    //  чтобы получилось: b = 1, a = 2. Дополнительные переменные использовать нельзя.
    $a = 2;
    $b = 1;
    echo "<br>a = " . $a . " b = " . $b . "<br>";
    $a = $a - $b;
    echo "a = " . $a . "<br>";
    $b = $a + $b;
    echo "b = " . $b;

    ?>

</body>

</html>