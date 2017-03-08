<?php
	/* Connect to Mysql */
	require 'config.php';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
	if(! $conn ) {
		die('Could not connect Mysql: ' . mysqli_error());
	}
	echo 'Connected Mysql successfully.<br>';
    /* Connect to Database */
	if (!mysqli_select_db( $conn, $dbname )) {
		die('Could not connect database.');
	}
	echo 'Connected database successfully.<br>';
	/* Create table */
	$sql = "CREATE TABLE OnlineMarkdown( ".
		"id BIGINT(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, ".
		"content LONGTEXT, ".
		"time DATETIME NOT NULL".
		") ";
	$retval = mysqli_query( $conn, $sql );
	if(! $retval ) {
		die('Could not create table: ' . mysqli_error($conn));
	}
	echo 'Created table successfully.<br>';
	/* Insert default info */
	$sql = "INSERT INTO OnlineMarkdown ".
		"(content, time) ".
		"VALUES ".
		"(null, NOW());";
	$retval = mysqli_query( $conn, $sql );
	if(! $retval ) {
		die('Could not insert default info: ' . mysqli_error($conn));
	}
	echo 'Inserted default info successfully.<br>';
	mysqli_close($conn);
	/* All done */
	echo 'All done.<br>';
?>