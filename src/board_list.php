<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", SRC_ROOT."mini_board/src/common/db_common.php" );
    define( "URL_HEADER", SRC_ROOT."mini_board/src/board_header.php");
    include_once( URL_DB );

    // GET 체크
    if ( array_key_exists( "page_num", $_GET ) )
    {
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1; //현재 페이지
    }

    $limit_num = 10;

    // 게시판 정보 테이블 전체 카운트 획득
    $result_cnt = select_board_info_cnt();

    // max page number
    $max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num );

    // offset : 1페이지일때 0, 2페이지 일때5, 3페이지 일때 10 ...
    $offset = ( $page_num * $limit_num ) - $limit_num;

    $arr_prepare = 
        array(
            "limit_num" => $limit_num
            ,"offset"   => $offset
        );
    $result_paging = select_board_info_paging( $arr_prepare );
    // print_r( $max_page_num );
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/board_list.css">
    <link rel="stylesheet" href="./css/board.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <title>게시판</title>
    <style>
    </style>
</head>
<body>
    <?php include_once( URL_HEADER ) ?>
    <div id="wrap">
        <img src="./img/1.png" class="bk_img1">
        <img src="./img/2.png" class="bk_img2">
        <div class="snowflakes" aria-hidden="true">
            <div class="snowflake">
            <!-- ❅❆❄ -->
            ♥
            </div>
            <div class="snowflake">
            ♥
            </div>
            <div class="snowflake">
            ♥
            </div>
            <div class="snowflake">
            ♥
            </div>
            <div class="snowflake">
            ♥
            </div>
            <div class="snowflake">
            ♥
            </div>
            <div class="snowflake">
            ♥
            </div>
            <div class="snowflake">
            ♥
            </div>
            <div class="snowflake">
            ♥
            </div>
            <div class="snowflake">
            ♥
            </div>
        </div>
        <div class="title">
            <i class="bi bi-postcard-heart"></i> BOARD LIST
        </div>
        <button type="button" class="a_btn"><a href="board_insert.php" class="fc_red">게시글 작성</a></button>
        <table>
            <thead>
                <tr>
                    <th>게시글 번호</th>
                    <th>게시글 제목</th>
                    <th>작성일</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach( $result_paging as $recode )
                    {
                ?>
                        <tr>
                            <td class="notice_no"><?php echo $recode["board_no"] ?></td>
                            <td class="notice_title"><a href="board_detail.php?board_no=<?php echo $recode["board_no"] ?>"><?php echo $recode["board_title"] ?></a></td>
                            <td class="notice_date"><?php echo $recode["board_write_date"] ?></td>
                        </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        <div class="a_margin">
            <!-- 페이징 번호 -->
            <?php
            if( $page_num != 1 )
            {
            ?>
                <a class="a_btn" href="board_list.php?page_num=1">◀</a>
            <?php
            }else{
            ?>
                <a class="a_btn hidden" href="board_list.php?page_num=1"><</a>
            <?php
            }
            ?>
            <?php
                for($i = 1; $i <= $max_page_num; $i++)
                {
            ?>
                    <a class="a_btn" href="board_list.php?page_num=<?php echo $i ?>"><?php echo $i ?></a>
            <?php
                }
            ?>
            <a class="a_btn" href="board_list.php?page_num=<?php echo $max_page_num ?>">▶</a>
        </div>
    </div>
</body>
</html>
