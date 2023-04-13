<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", SRC_ROOT."mini_board/src/common/db_common.php" );
    define( "URL_HEADER", SRC_ROOT."mini_board/src/board_header.php");
    include_once( URL_DB );

    $http_method = $_SERVER["REQUEST_METHOD"];

    if( $http_method === "POST" )
    {
        $arr_post = $_POST;
        $result_cnt = insert_board_info($arr_post);
        
        header( "Location: board_list.php" );
        exit();
    }

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/board.css">
    <title>게시글 작성</title>
</head>
<body>
    <?php include_once( URL_HEADER ) ?>
    <div id="wrap">
        <img src="./img/1.png" class="bk_img1">
        <img src="./img/2.png" class="bk_img2">
        <div class="title">WRITE</div>
        <form method="post" action="board_insert.php">
            <label for="title">Title </label>
            <input type="text" name="board_title" id="title">
            <br>
            <label for="contents">게시글 내용 : </label>
            <input type="text" name="board_contents" id="contents">
            <br>
            <button type="submit">작성</button>
            <button type="button"><a href="board_list.php">취소</a></button>
        </form>
    </div>
</body>
</html>