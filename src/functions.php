<?php

// --------------------------------------
// Разбиение и объединение ФИО

// Метод позволяет склеить ФИО в единую строку.
// Принимает в сеюя Фамилию, Имя и Отчество.
function getFullnameFromParts($surname, $name, $patronomyc) {
    return "$surname $name $patronomyc";
}

// Позволяет разделить ФИО из единой строки в асоциотивный массив с Фамилиейй, именем и отчеством.
function getPartsFromFullname($fullname) {
    $nameArrKeys = [ 'surname', 'name', 'patronomyc'];
    $nameArrValues = explode(' ', $fullname);
    return array_combine($nameArrKeys, $nameArrValues);
}


// --------------------------------------
// Сокращение ФИО

// Преобразует полное ФИО в сокращенный вид
function getShortName($fullname) {
    $nameArr = getPartsFromFullname($fullname);

    $surname = mb_substr($nameArr['surname'], 0, 1);
    $name = $nameArr['name'];
    
    return "$name $surname.";
}


// --------------------------------------
// Функция определения пола по ФИО

function getGenderFromName($fullname) {
    $nameArr = getPartsFromFullname($fullname);
    
    $surname = $nameArr['surname'];
    $name = $nameArr['name'];
    $patronomyc = $nameArr['patronomyc'];

    $genderIndication = 0;

    // Проверка фамилии
    if (preg_match('/в$/i', $surname)) {
        $genderIndication++;
    } elseif (preg_match('/ва$/i', $surname)) {
        $genderIndication--;
    }

    // Проверка имени
    // Указал что было в условии А для девушек и Й и Н у мужчин...
    if (preg_match('/[йн]$/i', $name)) {             // по идее там Р, Д, и Н
        $genderIndication++;
    } elseif (preg_match('/а$/i', $name)) {          // по идее там А и Я
        $genderIndication--;
    }

    // Проверка отчества
    if (preg_match('/ич$/i', $patronomyc)) {
        $genderIndication++;
    } elseif (preg_match('/вна$/i', $patronomyc)) {
        $genderIndication--;
    }

    return match ($genderIndication <=> 0) {
        1 => 'мужской',
        -1 => 'женский',
        default => 'неопределенный',
    } . ' пол';
}

// --------------------------------------
// Определение возрастно-полового состава

function getGenderDescription($personsArray) {
    $genderCount = ['M' => 0, 'F' => 0, 'NON' => 0];        // массив - счетчик

    if (!is_array($personsArray) || count($personsArray) === 0) return 'Получить статистику не возможно, приложен не массив с сотрудниками!';

    // Пробегаемся по массыиву, смотрим сотрудников.
    foreach ($personsArray as $person) {
        if (array_key_exists('fullname', $person)) {
            // Получаем строку с определением полового признака при помощи функции getGenderFromName
            $genderString = getGenderFromName($person['fullname']);

            // При помощи ргулярного выражения определяем пол.
            if (preg_match('/^мужской/', $genderString)) $genderCount['M']++;
            elseif (preg_match('/^женский/', $genderString)) $genderCount['F']++;
            else $genderCount['NON']++;
        } else {
            // TODO тут можно посчитать ошибочные значения, где были присланы не верные данные
            // Так же выброс ошибки или предупреждения...
        }
    }

    // Данные все получены, обработаны. нужно получить значения в процентах
    $allPersonCount = count($personsArray);
    $percentageFemale = getPercentage($allPersonCount, $genderCount['F']);
    $percentageMale = getPercentage($allPersonCount, $genderCount['M']);
    $percentageNone = getPercentage($allPersonCount, $genderCount['NON']);

    // выводим результат.
    return <<<RESULT
    Гендерный состав аудитории: <br>
    --------------------------- <br>
    Мужчины - $percentageMale <br>
    Женщины - $percentageFemale <br>
    Не удалось определить - $percentageNone <br>
    RESULT;
}

// Вспомогательная функция для определения процента
function getPercentage($allPersonCount, $genderCount) {
    return number_format(($genderCount / $allPersonCount) * 100, 2);
}


// --------------------------------------
// Идеальный подбор пары

function getPerfectPartner($surname, $name, $patronomyc, $personsArray) {
    // приводить все не стал к нижнему, верхнему регистру не стал, использовал mb_convert_case для строки ФИО...
    $personFIO = mb_convert_case(getFullnameFromParts($surname, $name, $patronomyc), MB_CASE_TITLE_SIMPLE);

    // Определяем наш пол...
    $genderString = getGenderFromName($personFIO);

    // Проверим не пустой ли это массив и массив ли это вообще.
    if (!is_array($personsArray) || count($personsArray) === 0) return 'Получить пару не возможно, приложен не массив с сотрудниками!';

    // Дополнительные переменные счетчики, для безопастного выхода из вечного цикла.
    $numberAttempts = 0;
    $maxNumberAttempts = 25;
    // Запускаем вечный цикл с условием выхода, что нашли для человека пару с противоположным полом.
    while(true) {
        // Добавлен принудительный выход из вечного цикла, если произошло 100 и более попыток
        if ($numberAttempts >= $maxNumberAttempts) {
            return 'Не удалось получить пару, возможно в параметрах переданы не корректные данные.';
        }

        $numberAttempts++;

        // Получим рандомного сотрудника
        $randomPerson = $personsArray[random_int(0, count($personsArray) - 1)];
        // Получим пол рандомного сотрудника
        $randomPersonGender = getGenderFromName($randomPerson['fullname']);

        // Если пол с основным совпадает, то пропускаем его.
        if ($genderString === $randomPersonGender) continue;

        // Получаем коротние имена "счастливчиков"
        $ferstPersonName = getShortName($personFIO);
        $secondPersonName = getShortName($randomPerson['fullname']);

        // Получаем процентную составляющую.
        $parcentage = random_int(50, 100);
        $fractional = sprintf('%02d', random_int(0, 99));
        $randomParcentage = $parcentage . ($parcentage === 100 ? '' : ('.' . $fractional));    // Скобки в тернарном, для простоты чтения.

        // Возвращаем результат.
        return <<<IT_IS_LOVE
        $ferstPersonName + $secondPersonName = <br>
        ♡ Идеально на $randomParcentage% ♡
        IT_IS_LOVE;

    }   

}
