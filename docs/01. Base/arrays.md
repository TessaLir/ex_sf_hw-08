[В начало](../../README.md)

---

## **Массивы**



В PHP можно определить несколько характеристик отдельных массивов:

- Числовые (индексированные) массивы — массивы, в которых ключами являются числа;
- Ассоциативные массивы — массивы, в которых ключами являются строки;
- оОномерные массивы — массивы, которые не содержат в себе других массивов;
- Многомерные массивы — массивы, которые содержат в себе другие массивы;
- Рекурсивные массивы — массивы, которые содержат в себе ссылку на самих себя.

### **Числовые массивы**

Тут все как везде, плюс - минус.

Пример создания числового массива, если пропустить какие-либо индексы, они не заполняются null-ами

```php
$array = [1, 13=>'Android', true];

// Такой массив можно перебирать ТОЛЬКО foreach-ем

print_r ($array);
// -> Array
// -> (
// ->     [0] => 1
// ->     [13] => Android
// ->     [14] => 1
// -> )
```

А чтобы поместить новое значение на последующий ключ в массив используется запись вида:

```php
$fruits[] = 'coconut';
```
### **Ассоциативные массивы**

Ассоциативные массивы отличаются от индексированных тем, что ключи в них задаются в виде строк (ассоциаций):


```php
$favorite_fruits = ['Mike'=>'banana', 'Andrew'=>'orange', 'Ann'=>'grape'];


// Стоит отметить, что ключи в массивах регистрозависимые
$favorite_fruits['MIKE'] = 'pineapple';
print_r($favorite_fruits);
// -> Array
// -> (
// ->     [Mike] => banana
// ->     [Andrew] => orange
// ->     [Ann] => grape
// ->     [MIKE] => pineapple
// -> )
```

### **Многомерные массивы**

```php 
$vacancies = [
    'developer'=> [
        'frontend-developer' => [
            'Junior Frontend разработчик (Яндекс)',
            'Middle Frontend разработчик (Авито)',
        ],
        'backend-developer' => [],
    ], 
    'tester' => [],
];

print_r($vacancies);
// -> Array
// -> (
// ->     [developer] => Array
// ->         (
// ->             [frontend-developer] => Array
// ->                 (
// ->                     [0] => Junior Frontend разработчик (Яндекс)
// ->                     [1] => Middle Frontend разработчик (Авито)
// ->                 )
// ->             [backend-developer] => Array()
// ->         )
// ->     [tester] => Array()
// -> )

---

// Чтобы прочитать (или присвоить) значение $vacancies строим цепочку индексов:

echo $vacancies['developer']['frontend-developer']['1']; 
// => Middle Frontend разработчик (Авито)

```

### **Операции над массивами**

`count` - предоставляет длину массива.

```bach=
$arr = [0, 1, 2, 3, 4, 5];
echo count($arr) . '<br>';
// -> 6
```

`array_merge($a,$b)` - Функция принимающая в качестве параметров массивы $a и $b, результатом выполнения является новый массив, сочетающий в себе значения из обоих массивов, при этом сохранятся только уникальные ключи. Повторяющиеся ключи запишутся значениями из $b, пример:

```php
$male_favorite_fruits = [
    'Mike' => 'banana', 
    'Andrew' => 'pineapple', 
    'Alex' => 'orange', 
];
$female_favorite_fruits = [
    'Alex' => 'cherry', 
    'Ann' => 'grape', 
];

print_r(array_merge($male_favorite_fruits, $female_favorite_fruits));
// -> Array
// -> (
// ->     [Mike] => banana
// ->     [Andrew] => pineapple
// ->     [Alex] => cherry
// ->     [Ann] => grape
// -> )
```

`array_combine($a,$b)` - Функция создаёт новый массив, в котором ключами станут значения из $a, а значениями — значения из $b<br>
*Если длина массива разная, то произойдет ошибка!*

```php
$persons = [
    'Mike', 
    'Andrew', 
    'Alex', 
];
$fruits = [
    'cherry', 
    'grape', 
    'banana', 
];

print_r(array_combine($persons, $fruits));
// -> Array
// -> (
// ->     [Mike] => cherry
// ->     [Andrew] => grape
// ->     [Alex] => banana
// -> )
```

`array_values($array)` -  возвращает значения VALUES из массива.

```php
$favorite_fruits = [
    'Mike' => 'banana', 
    'Andrew' => 'pineapple', 
    'Alex' => 'orange', 
];

print_r(array_values($favorite_fruits));
// -> Array
// -> (
// ->     [0] => banana
// ->     [1] => pineapple
// ->     [2] => orange
// -> )
```

`array_keys($array)` - возвращает значения KEYS из массива.

```php
$favorite_fruits = [
    'Mike' => 'banana', 
    'Andrew' => 'pineapple', 
    'Alex' => 'orange', 
];

print_r(array_keys($favorite_fruits));
// -> Array
// -> (
// ->     [0] => Mike
// ->     [1] => Andrew
// ->     [2] => Alex
// -> )
```

`array_flip($array)` - Функция меняет ключи и значения местами и вернет в виде нового массива:

```php
$favorite_fruits = [
    'Mike' => 'banana', 
    'Andrew' => 'pineapple', 
    'Alex' => 'orange', 
];

print_r(array_flip($favorite_fruits));
// -> Array
// -> (
// ->     [banana] => Mike
// ->     [pineapple] => Andrew
// ->     [orange] => Alex
// -> )
```

`array_filter($array, $function)` - Действие функции аналогично действию метода .filter для объекта-обертки Array в языке JavaScript. Функция проходит по всем элементам массива $array, вызывая для каждого из значений функцию $function (должна возвращать true или false), при true включает значение в результирующий массив: $numbers = [20, -3, 50, -99, 55];

```php
$numbers = [0, 7, 21, 54, 11, 1234, 4, 126];

$numbersMultiplesOf3 = array_filter($numbers, function($number) {
    return ($number % 3) == 0;
});

print_r($numbersMultiplesOf3);
// -> Array
// -> (
// ->     [0] => 0
// ->     [2] => 21
// ->     [3] => 54
// ->     [7] => 126
// ->)
```

`array_unique($array)` - Функция возвращает новый массив содержащий в себе только уникальные значения из $array:

```php
$boysOfMaria = [
    'Alex',
    'Andy',
    'Alex',
    'Tony',
    'Alex',
    'Alex',
    'Tony',
    'Tony',
    'Tony',
    'Abdula',
    'Tony',
    'Tony',
];

$boys_names = array_unique($boysOfMaria);

print_r(count($boys_names));
// -> 4
```

`array_diff($a, $b)` - Функция возвращает новый массив содержащий значения, различающиеся в $a и $b:

```php
$a = ['a' => '1', 'b' => '2', 'c' => '3'];
$b = ['a' => '1', 'b' => '3', 'D' => '3'];

print_r(array_diff($a, $b));
// -> Array
// -> (
// ->     [b] => 2
// -> )
```

`sort($a, $flags)` - функция сортирует переданный массив $a в соответствии с флагами из $flags и помещает результат в $a.

Эта функция присваивает новые ключи элементам array. Она удалит все существующие ключи, а не просто переупорядочит их.

Вторым параметром передаются флаги сортировки:

- SORT_REGULAR — обычное сравнение элементов; подробности описаны в разделе «Операторы сравнения», флаг по умолчанию;
- SORT_NUMERIC — числовое сравнение элементов;
- SORT_STRING — строковое сравнение элементов;
- SORT_LOCALE_STRING — сравнивает элементы, как строки с учётом текущей локали. Используется локаль, которую можно изменять с помощью функции setlocale();
- SORT_NATURAL — сравнение элементов как строк, используя естественное упорядочение;
- SORT_FLAG_CASE — может быть объединен (через побитовое ИЛИ) с SORT_STRING или SORT_NATURAL для сортировки строк без учета регистра.

```php
$images = [
    'img12.png', 
    'img10.png', 
    'img2.png', 
    'img24.png',
    'IMG23.png', 
    'img1.png',
];

sort($images);
echo "SORT_REGULAR\n";
print_r($images);
// -> SORT_REGULAR
// -> Array
// -> (
// ->     [0] => IMG23.png
// ->     [1] => img1.png
// ->     [2] => img10.png
// ->     [3] => img12.png
// ->     [4] => img2.png
// ->     [5] => img24.png
// -> )

sort($images, SORT_NATURAL);
echo "\nSORT_NATURAL\n";
print_r($images);
// -> SORT_NATURAL
// -> Array
// -> (
// ->     [0] => IMG23.png
// ->     [1] => img1.png
// ->     [2] => img2.png
// ->     [3] => img10.png
// ->     [4] => img12.png
// ->     [5] => img24.png
// -> )

sort($images, SORT_STRING | SORT_FLAG_CASE );
echo "\nSORT_STRING with SORT_FLAG_CASE\n";
print_r($images);
// -> SORT_STRING with SORT_FLAG_CASE
// -> Array
// -> (
// ->     [0] => img1.png
// ->     [1] => img10.png
// ->     [2] => img12.png
// ->     [3] => img2.png
// ->     [4] => IMG23.png
// ->     [5] => img24.png
// -> )

sort($images, SORT_NATURAL | SORT_FLAG_CASE );
echo "\nSORT_NATURAL with SORT_FLAG_CASE\n";
print_r($images);
// -> SORT_NATURAL with SORT_FLAG_CASE
// -> Array
// -> (
// ->     [0] => img1.png
// ->     [1] => img2.png
// ->     [2] => img10.png
// ->     [3] => img12.png
// ->     [4] => IMG23.png
// ->     [5] => img24.png
// -> )
```