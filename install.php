<?php
	require 'config.php';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
	if(! $conn ) {
		die('Could not connect Mysql: ' . mysqli_error());
	}
	echo 'Connected Mysql successfully.';
	if (!mysqli_select_db( $conn, $dbname )) {
		die('Could not connect database');
	}
	echo 'Connected database successfully.';
	$sql = "CREATE TABLE OnlineMarkdown( ".
		"id BIGINT(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, ".
		"content LONGTEXT, ".
		"time DATETIME NOT NULL".
		") ";
	$retval = mysqli_query( $conn, $sql );
	if(! $retval ) {
		die('数据表创建失败: ' . mysqli_error($conn));
	}
	echo '数据表创建成功';
	$sql = "INSERT INTO OnlineMarkdown ".
		"(content, time) ".
		"VALUES ".
		"(null, NOW());";
	$retval = mysqli_query( $conn, $sql );
	if(! $retval ) {
		die('数据表初始化失败: ' . mysqli_error($conn));
	}
	echo '数据表初始化成功';
	mysqli_close($conn);
?>