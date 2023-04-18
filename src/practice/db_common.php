<?php
// ---------------------------------
// 함수명	: db_conn
// 기능		: DB Connection
// 파라미터	: Obj	&$param_conn
// 리턴값	: 없음
// ---------------------------------
function db_conn( &$param_conn ) {
    $host = "localhost";
    $user = "root";
    $pass = "root506";
    $charset = "utf8mb4";
    $db_name = "board";
    $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option = 
        array(
            PDO::ATTR_EMULATE_PREPARES     => false
            ,PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION
            ,PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC
        );

    try {
        $param_conn = new PDO( $dns, $user, $pass, $pdo_option );
    } 
    catch ( Exception $e ) { // 에러를 $e에 담겠다
        $param_conn = null;
        throw new Exception( $e->getMessage() );
    }
}

// ---------------------------------
// 함수명	: select_board_info_paging
// 기능		: 페이징_게시판 정보 검색
// 파라미터	: Array		&$param_arr
// 리턴값	: Array		$result
// ---------------------------------
function select_board_info_paging() {
    $sql =
        " SELECT "
        ."      board_no "
        ."      ,board_title "
        ."      ,board_write_date "
        ." FROM "
        ."      board_info "
        ." WHERE "
        ."      board_del_flg = '0' "
        ." ORDER BY "
        ."      board_no DESC "
        ;
    $arr_prepare = array();

    $conn = null;
    try {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare ); // 쿼리 실행 후 $result에 담기
        $result = $stmt->fetchAll();
    } 
    catch ( Exception $e ) {
        return $e->getMessage();
    } 
    finally {
        $conn = null;
    }

    return $result;
}

?>