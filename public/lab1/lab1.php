<?php
//1
echo "Hello, World!<br>";  // виводить текст на екран

echo "<hr>";

//2
$name = "Олександр";     // рядок 
$age = 20;               // ціле число
$average = 4.75;         // число з плаваючою комою 
$isStudent = true;       // булеве значення 

// Виводимо значення
echo "Ім'я: $name <br>";
echo "Вік: $age <br>";
echo "Середній бал: $average <br>";
echo "Студент: $isStudent <br><br>";

// Виводимо типи 
var_dump($name);     echo "<br>";
var_dump($age);      echo "<br>";
var_dump($average);  echo "<br>";
var_dump($isStudent);echo "<br>";

echo "<hr>";

//3
$firstName = "Тарас";
$lastName = "Шевченко";

// Об'єднуємо через крапку
$fullName = $firstName . " " . $lastName;
echo "Повне ім'я: " . $fullName . "<br>";

echo "<hr>";

//4
$number = 23;

if ($number % 2 == 0) {
    echo "Число $number — парне<br>";
} else {
    echo "Число $number — непарне<br>";
}

echo "<hr>";

//5
echo "Цикл for (1 → 10): ";
for ($i = 1; $i <= 10; $i++) {
    echo $i . " ";
}
echo "<br>";

echo "Цикл while (10 → 1): ";
$j = 10;
while ($j >= 1) {
    echo $j . " ";
    $j--;
}
echo "<br>";

echo "<hr>";

//6
$student = [
    "ім'я"          => "Марія",
    "прізвище"      => "Коваленко",
    "вік"           => 19,
    "спеціальність" => "Комп'ютерні науки"
];

// Виводимо кожен елемент
foreach ($student as $key => $value) {
    echo ucfirst($key) . ": $value <br>";
}

// Додаємо новий елемент
$student["середній бал"] = 4.8;

echo "<br>Оновлений масив:<br>";
foreach ($student as $key => $value) {
    echo ucfirst($key) . ": $value <br>";
}

?>