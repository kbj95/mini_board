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
        <table>
            <thead>
                <tr>
                    <th class="th1">NO.<?php echo $result_info["board_no"] ?></th>
                    <th class="th_title"><?php echo $result_info["board_title"] ?></th>
                    <th class="th_date"><?php echo $result_info["board_write_date"] ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="th1">게시글 내용 </th>
                    <td colspan="2"><?php echo $result_info["board_contents"] ?></td>
                </tr>
            </tbody>
        </table>
        <div class="btn_area">
            <button type="button" class="a_btn">
                <a class="fc_red" href="board_update.php?board_no=<?php echo $result_info["board_no"] ?>">수정</a>
            </button>
            <button type="button" class="a_btn">
                <a class="fc_red" href="board_delete.php?board_no=<?php echo $result_info["board_no"] ?>">삭제
                </a>
            </button>
        </div>
    </div>
</body>
</html>