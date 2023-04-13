<?php
// ---------------------------------
// 함수명	: db_conn
// 기능		: DB Connection
// 파라미터	: Obj	&$param_conn
// 리턴값	: 없음
// ---------------------------------
function db_conn( &$param_conn )
{
    $host = "localhost";
    $user = "root";
    $pass = "root506";
    $charset = "utf8mb4";
    $db_name = "board";
    $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option =
        array(
            PDO::ATTR_EMULATE_PREPARES => false
            ,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

    try
    {
        $param_conn = new PDO( $dns, $user, $pass, $pdo_option );
    }
    catch( Exception $e )
    {
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
function select_board_info_paging( &$param_arr )
{
    $sql =
        " SELECT " 
        ." board_no "
        ." ,board_title "
        ." ,board_write_date "
        ." FROM "
        ."    board_info "
        ." WHERE "
        ."    board_del_flg = '0' "
        ." ORDER BY "
        ."    board_no DESC "
        ." LIMIT :limit_num OFFSET :offset "
        ;

    $arr_prepare =
        array(
            ":limit_num"    => $param_arr["limit_num"]
            ,":offset"      => $param_arr["offset"]
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        // return false;
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result;
}

// ---------------------------------
// 함수명	: select_board_info_cnt
// 기능		: 게시판 정보 테이블 레코드 카운트 검색
// 파라미터	: 없음
// 리턴값	: Array		$result
// ---------------------------------
function select_board_info_cnt()
{
    $sql =
        " SELECT "
        ."  COUNT(*) cnt"
        ." FROM "
        ."  board_info "
        ." WHERE "
        ."  board_del_flg = '0' "
        ;
    $arr_prepare = array();

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result;
}

//-------------------------------------------------------------------------------
// ---------------------------------
// 함수명	: select_board_info_no
// 기능		: 게시판 특정 게시글 정보 검색
// 파라미터	: INT		&$param_no
// 리턴값	: Array		$result
// ---------------------------------
function select_board_info_no( &$param_no )
{
    $sql =
        " SELECT " 
        ." board_no "
        ." ,board_title "
        ." ,board_contents "
        ." ,board_write_date" // 0412 작성일 추가
        ." FROM "
        ."    board_info "
        ." WHERE "
        ."    board_no = :board_no "
        ;

    $arr_prepare =
        array(
            ":board_no" => $param_no
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        // return false;
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result[0];
}
// select랑 다름!!! update,insert,delete는 아래참조
// ---------------------------------
// 함수명	: update_board_info_no
// 기능		: 게시판 특정 게시글 정보 수정
// 파라미터	: Array		&$param_arr
// 리턴값	: INT/STRING	$result_cnt/ERRMSG
// ---------------------------------
function update_board_info_no( &$param_arr )
{
    $sql =
        " UPDATE "
        ."  board_info "
        ." SET "
        ."  board_title = :board_title "
        ."  ,board_contents = :board_contents "
        ." WHERE "
        ."  board_no = :board_no "
        ;

    $arr_prepare =
        array(
            ":board_title" => $param_arr["board_title"]
            ,":board_contents" => $param_arr["board_contents"]
            ,":board_no" => $param_arr["board_no"]
        );

    $conn = null;
    try
    {
        db_conn( $conn ); // PDO object set(DB 연결)
        $conn->beginTransaction(); // Transaction 시작
        $stmt = $conn->prepare( $sql ); // statement object 셋팅
        $stmt->execute( $arr_prepare ); // DB request
        $result_cnt = $stmt->rowCount(); // query 적용 recode 갯수
        $conn->commit();
    }
    catch( Exception $e )
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result_cnt;
}

// ---------------------------------
// 함수명	: delete_board_info_no
// 기능		: 게시판 특정 게시글 정보 삭제플러그 갱신
// 파라미터	: Array		&$param_no
// 리턴값	: INT/STRING	$result_cnt/ERRMSG
// ---------------------------------
function delete_board_info_no( &$param_no )
{
    $sql =
        " UPDATE "
        ." board_info "
        ." SET "
        ." board_del_flg = '1' "
        ." ,board_del_date = NOW() "
        ." WHERE "
        ." board_no = :board_no "
        ;
    
    $arr_prepare =
        array(
            ":board_no" => $param_no
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    }
    catch( Exception $e )
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    return $result_cnt;
}

// ---------------------------------
// 함수명	: insert_board_info_
// 기능		: 게시글 생성
// 파라미터	: Array		&$param_arr
// 리턴값	: INT/STRING	$result_cnt/ERRMSG
// ---------------------------------
function insert_board_info( &$param_arr )
{
    $sql = 
        " INSERT INTO "
        ." board_info( "
        ." board_title "
        ." ,board_contents "
        ." ,board_write_date "
        ." ) "
        ." VALUES( "
        ." :board_title "
        ." ,:board_contents "
        ." ,NOW()"
        ." ) ";
    $arr_prepare =
        array(
            ":board_title" => $param_arr["board_title"]
            ,":board_contents" => $param_arr["board_contents"]
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    }
    catch( Exception $e )
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    return $result_cnt;
}

// TODO : test Start
// $arr =
//     array(
//         "limit_num" => 5
//         ,"offset"    => 0
//     );
// $result = select_board_info_paging( $arr );

// print_r( $result );

// $i = 20;
// print_r(select_board_info_no($i));

// $arr = 
//     array(
//         "board_no" => 1
//         ,"board_title" => "test1"
//         ,"board_contents" => "testtest1"
//     );

// echo update_board_info_no($arr);

// TODO : test End
?>