<?php
/*
    $res["error" = 0, "text" = "save success"];
    $res["error" = -1, "text" = "unknown error"];
    $res["error" = 10, "text" = "empty content";];
    $res["error" = -10, "text" = 'Could not connect Mysql: ' . mysqli_error();];
    $res["error" = -20, "text" = 'Could not connect database: ' . mysqli_error();];
    $res["error" = -30, "text" = 'Could not add to Mysql: ' . mysqli_error();];
    $res["error" = -40, "text" = 'Could not get ID: ' . mysqli_error();];
 */
    $res = [];
    $res["error"] = -1;
    $res["text"] = "unknown error";
    /* Check content is not empty */
    $getContents = $_GET["contents"];
    if (empty($getContents)) {
        $res["error"] = 10;
        $res["text"] = "empty content";
        exitWith($res);
    }
    $getContents = htmlspecialchars($getContents);
    /* Connect to Mysql */
	require 'config.php';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
    if(! $conn ) {
        $res["error"] = -10;
        $res["text"] = 'Could not connect Mysql: ' . mysqli_error();
        exitWith($res);
    }
    /* Connect to Database */
    if (!mysqli_select_db( $conn, $dbname )) {
        $res["error"] = -20;
        $res["text"] = 'Could not connect database: ' . mysqli_error();
        exitWith($res);
    }
    /* Insert info */
    $sql = "INSERT INTO OnlineMarkdown ".
        "(content, time) ".
        "VALUES ".
        "(\"".$getContents."\",NOW());";
    /* Check Mysql status */
    $retval = mysqli_query( $conn, $sql );
    if(! $retval ) {
        $res["error"] = -30;
        $res["text"] = 'Could not add to Mysql: ' . mysqli_error();
        exitWith($res);
    }
    /* Get ID */
    $sql = "SELECT  LAST_INSERT_ID();";
    $retval = mysqli_query( $conn, $sql );
    if(! $retval ) {
        $res["error"] = -40;
        $res["text"] = 'Could not get ID: ' . mysqli_error();
        exitWith($res);
    }
    mysqli_close($conn);
    $res["id"] = mysqli_fetch_assoc($retval)["LAST_INSERT_ID()"];
    if ($res["id"] == 0) {
        $res["error"] = -40;
        $res["text"] = 'Could not get ID: ' . mysqli_error();
    }
    /* All done */
    $res["error"] = 0;
    $res["text"] = "save success";
    exitWith($res);
    /* Function */
    function exitWith ($errorCode) {
        echo json_encode($errorCode);
        exit();
    }
?>