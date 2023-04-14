<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", SRC_ROOT."mini_board/src/common/db_common.php" );
    define( "URL_HEADER", SRC_ROOT."mini_board/src/board_header.php");
    include_once( URL_DB ); // include_once("C:/Apache24/htdocs/mini_board/src/common/db_common.php");

    // Request Method를 획득
    $http_method = $_SERVER["REQUEST_METHOD"];

    //var_dump($_SERVER, $_GET, $_POST); // 모르면 찍어보기

    // GET 일때
    if( $http_method === "GET")
    {
        // GET 체크
        $board_no = 1;
        if ( array_key_exists( "board_no", $_GET ) )
        {
            $board_no = $_GET["board_no"];
        }
        $result_info = select_board_info_no( $board_no );
    }
    // POST 일때
    else
    {
        $arr_post = $_POST;
        $arr_info =
            array(
                "board_no" => $arr_post["board_no"]
                ,"board_title" => $arr_post["board_title"]
                ,"board_contents" => $arr_post["board_contents"]
            );

        // update
        $result_cnt = update_board_info_no( $arr_info );
        // var_dump($result_cnt);
        // select
        // $result_info = select_board_info_no( $arr_info["board_no"] ); // 0412 del

        header( "Location: board_detail.php?board_no=".$arr_post["board_no"] );
        exit(); // 윗행에서 redirect 했기 떄문에 이후의 소스코드는 실행할 필요가 없다. 
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
        crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/board.css">
    <link rel="stylesheet" href="./css/board_update.css">
    <title>게시글</title> 
    <script>
        // 1번째 input 태그 처리
        const $title = document.getElementById("title");
        $title.value = $result_info['board_title']; // 새로 value를 설정 해줘야 커서가 뒤로 간다.
    </script>
</head>
<body>
    <?php include_once( URL_HEADER ) ?>
    <div id="wrap">
        <img src="./img/1.png" class="bk_img1">
        <img src="./img/2.png" class="bk_img2">
        <div class="title">UPDATE</div>
        <form method="post" action="board_update.php">
            <ul class="flex ul_top">
                <li class="li_width">
                    NO.<?php echo $result_info["board_no"] ?>
                    <input type="hidden" name="board_no" value="<?php echo $result_info["board_no"] ?>">
                </li>
                <li>
                    <input type="text" name="board_title" id="title" value="<?php echo $result_info["board_title"] ?>" autofocus>
                </li>
            </ul>
            <ul class="flex contents">
                <li class="li_width">내용</li>
                <li>
                    <textarea name="board_contents"><?php echo $result_info["board_contents"] ?></textarea>
                </li>
            </ul>
            <div class="btn_area">
                <button type="submit" class="a_btn">확인</button>
                <button type="button" class="a_btn"><a class="fc_red" href="board_detail.php?board_no=<?php echo $result_info["board_no"] ?>">취소</a></button>
            </div>
        </form>
        <!-- <button type="button" class="a_btn"><a class="fc_red" href ="board_list.php">LIST</a></button> -->
    </div>
</body>
</html>
