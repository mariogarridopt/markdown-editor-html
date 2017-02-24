<?php
/*
    $res["error" = 0, "text" = "save success"];
    $res["error" = -1, "text" = "unknown error"];
    $res["error" = 10, "text" = "empty content";];
    $res["error" = -10, "text" = 'Could not connect Mysql: ' . mysqli_error();];
    $res["error" = -20, "text" = 'Could not connect database: ' . mysqli_error();];
    $res["error" = -30, "text" = 'Could not find: ' . mysqli_error();];
 */
    $res = [];
    $res["error"] = -1;
    $res["text"] = "unknown error";

    $getId = $_GET["id"];
    if (empty($getId)) {
        $res["error"] = 10;
        $res["text"] = "empty id";
        exitWith($res);
    }

    require 'config.php';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
    if(! $conn ) {
        $res["error"] = -10;
        $res["text"] = 'Could not connect Mysql: ' . mysqli_error();
        exitWith($res);
    }
    if (!mysqli_select_db( $conn, $dbname )) {
        $res["error"] = -20;
        $res["text"] = 'Could not connect database: ' . mysqli_error();
        exitWith($res);
    }
    $sql = "SELECT content from OnlineMarkdown where id = ".$getId.";";
    $retval = mysqli_query( $conn, $sql );
    if(! $retval ) {
        $res["error"] = -30;
        $res["text"] = 'Could not find: ' . mysqli_error();
        exitWith($res);
    }
    mysqli_close($conn);
    $res["content"] = htmlspecialchars_decode(mysqli_fetch_assoc($retval)["content"]);
    if (empty($res["content"])) {
    	$res["error"] = -30;
        $res["text"] = 'Could not find: ' . mysqli_error();
        exitWith($res);
    }
    $res["error"] = 0;
    $res["text"] = "load success";
    exitWith($res);

    function exitWith ($errorCode) {
        echo json_encode($errorCode);
        exit();
    }
?>