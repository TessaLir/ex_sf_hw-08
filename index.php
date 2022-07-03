<?php 
    $title = '12.6. Практическая работа.';

    // Подключаем файл PHP c исходными данными (аналог выгрузки из СУБД)
    require_once './src/data.php';

    // Подключаем файл PHP с функциями
    require_once './src/functions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" >
    <style>
        .row {
            margin-top: 56px;
        }
        .card {
            margin: 8px; 
            padding: 8px; 
            border: 1px solid black; 
            border-radius: 16px; 
            text-align: center;
        }
        .gender-card {
            background-color: lightcyan;
        }
        .love-card {
            background-color: lightcoral;
        }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <h1><?= $title ?></h1>
        </div>
    </header>

    <div class="main">

        <div class="container">

            <div class="row">
                <h4>Сокращение ФИО</h4>
                <ol>
                    <?php foreach($example_persons_array as $person): ?>
                        <li><?= getShortName($person['fullname']); ?> (<?= $person['job']; ?>)</li>
                    <?php endforeach; ?>
                </ol>
            </div>

            <hr>
            <div class="row">
                <h4>Определения пола по ФИО</h4>
                <?php foreach($example_persons_array as $person): ?>
                    <?php $nameArray = getPartsFromFullname($person['fullname']); ?>
                    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <p class="card gender-card">
                            <?= $person['fullname'] ?>
                            <br>
                            <?= getGenderFromName($person['fullname']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

            <hr>
            <div class="row">
                <h4>Определение возрастно-полового состава</h4>
                <p>
                    <?= getGenderDescription($example_persons_array); ?>
                </p>
            </div>

            <hr>
            <div class="row">
                <h4>Идеальный подбор пары</h4>
                <?php foreach($example_persons_array as $person): ?>
                    <?php $nameArray = getPartsFromFullname($person['fullname']); ?>
                    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <p class="card love-card">
                            <?= 
                                getPerfectPartner(
                                    $nameArray['surname'], 
                                    $nameArray['name'], 
                                    $nameArray['patronomyc'], 
                                    $example_persons_array
                                );
                            ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</body>
</html>