--  erdcloud
--	게시글 정보테이블
--	게시글 번호, 게시글 제목, 게시글내용, 작성일, 삭제여부, 삭제일, (작성자)--나중에
	CREATE DATABASE board;

	USE board; 

	CREATE TABLE board_info (
		board_no INT PRIMARY KEY AUTO_INCREMENT
		,board_title VARCHAR(100) NOT NULL
		,board_contents VARCHAR(1000) NOT NULL
		,board_write_date DATETIME NOT NULL
		,board_del_flg CHAR(1) DEFAULT('0') NOT NULL
		,board_del_date DATETIME
	);

	DESC board_info;