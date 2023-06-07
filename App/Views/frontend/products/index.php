<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Tất cả sản phẩm</h1>
    <?php

    foreach ($datas as $key => $data) {
        echo $data->name . "<br>";
    }
    ?>
</body>

</html>