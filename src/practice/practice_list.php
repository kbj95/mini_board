<?php
    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    define("URL_DB", DOC_ROOT."mini_board/src/practice/db_common.php");
    
    include_once( URL_DB );

    $result_list = select_board_info_paging();
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
        foreach( $result_list as $val )
        {
    ?>
    <ul>
        <li><?php echo $val["board_no"] ?></li>
        <li><?php echo $val["board_title"] ?></li>
        <li><?php echo $val["board_write_date"] ?></li>
    </ul>
    <?php
        }
    ?>
</body>
</html>