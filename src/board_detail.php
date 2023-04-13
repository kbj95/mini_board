<?php
define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB", SRC_ROOT."mini_board/src/common/db_common.php" );
define( "URL_HEADER", SRC_ROOT."mini_board/src/board_header.php");
include_once( URL_DB );

// Request Parameter 획득(GET)
$arr_get = $_GET;

// DB에서 게시글 정보 획득
$result_info = select_board_info_no( $arr_get["board_no"] );

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/board.css">
    <link rel="stylesheet" href="./css/board_detail.css">
    <title>Detail</title>
</head>
<body>
    <?php include_once( URL_HEADER ) ?>
    <div id="wrap">
        <img src="./img/1.png" class="bk_img1">
        <img src="./img/2.png" class="bk_img2">
        <div class="title">BOARD</div>
        <table class="contents">
            <thead>
                <tr>
                    <th>게시글 번호 : <?php echo $result_info["board_no"] ?></th>
                    <th>게시글 제목 : <?php echo $result_info["board_title"] ?></th>
                    <th>작성일 : <?php echo $result_info["board_write_date"] ?></th>
                <tr>
            <thead>
            <tbody>
                <tr>
                    <th>게시글 내용 : <?php echo $result_info["board_contents"] ?>
                    </th>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
        <button type="button">
            <a href="board_update.php?board_no=<?php echo $result_info["board_no"] ?>">수정</a>
        </button>
        <button type="button">
            <a href="board_delete.php?board_no=<?php echo $result_info["board_no"] ?>">삭제
            </a>
        </button>
    </div>
</body>
</html>