--	게시글 제목 : 제목n (n=숫자)
--	게시글 내용 : 내용n
--	작성일 : 현재 일자
	INSERT INTO board_info (
	board_title
	,board_contents
	,board_write_date
	)
	VALUES (
		'제목 20'
		,'내용 20'
		,NOW()
	);
    -- 한번에 적는법 (오라클은 지원x)
        -- INSERT INTO board_info ( board_title ,board_contents ,board_write_date )
        -- VALUES ('제목 1','내용 1',NOW())
        --     ,('제목 2','내용 2',NOW()) ...
        --     ,('제목 20','내용 20',NOW());