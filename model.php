<?php

function connect_db($host, $db, $user, $pass){
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        echo sprintf("Failed to connect. %s",$e->getMessage());
    }
    return $pdo;
}

function new_route($route_uri, $request_type){
    $route_uri_expl = array_filter(explode('/', $route_uri));
    $current_path_expl = array_filter(explode('/',parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    if ($route_uri_expl == $current_path_expl && $_SERVER['REQUEST_METHOD'] == strtoupper($request_type)) {
        return True;
    } else {
        return False;
    }
}

function use_template($template){
    $template_doc = sprintf("views/%s.php", $template);
    return $template_doc;
}

function get_breadcrumbs($breadcrumbs) {
    $breadcrumbs_exp = '
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">';
    foreach ($breadcrumbs as $name => $info) {
        if ($info[1]){
            $breadcrumbs_exp .= '<li class="breadcrumb-item active" aria-current="page">'.$name.'</li>';
        }else{
            $breadcrumbs_exp .= '<li class="breadcrumb-item"><a href="'.$info[0].'">'.$name.'</a></li>';
        }
    }
    $breadcrumbs_exp .= '
    </ol>
    </nav>';
    return $breadcrumbs_exp;
}

function get_rooms_exp($rooms) {
    $rooms_exp = '<div>';
    foreach ($rooms as $index => $indexvalue) {
        $rooms_exp .= '<div class="box"><div class="list">';
        foreach ($indexvalue as $column => $value) {
            if ($column == 'head_img') {
                $rooms_exp .= '</div> <img src="/final/img/'.$value.'" alt="">';
            }
            else {
                $rooms_exp .= '<div>' . $column . ': ' . $value . '</div>';
            }
        }
        $rooms_exp .= '</div>';
    }
    $rooms_exp .= '</div>';
    return $rooms_exp;
}

function get_rooms($pdo) {
    $stmt = $pdo->prepare('SELECT * FROM rooms');
    $stmt->execute();
    $rooms = $stmt->fetchAll();
    $rooms_exp = Array();

    /* Create array with htmlspecialchars */
    foreach ($rooms as $key => $value){
        foreach ($value as $user_key => $user_input) {
            $series_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $series_exp;
}

function na($url, $active){
    return [$url, $active];
}

function get_navigation($template, $active_id){
    $navigation_exp = '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">Student rooms</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">';
    foreach ($template as $name => $info) {
        if ($name == $active_id){
            $navigation_exp .= '<li class="nav-item active">';
            $navigation_exp .= '<a class="nav-link" href="'.$info["url"].'">'.$info["name"].'</a>';
        }else{
            $navigation_exp .= '<li class="nav-item">';
            $navigation_exp .= '<a class="nav-link" href="'.$info["url"].'">'.$info["name"].'</a>';
        }

        $navigation_exp .= '</li>';
    }
    $navigation_exp .= '
    </ul>
    </div>
    </nav>';
    return $navigation_exp;
}

function check_login(){
    if (isset($_SESSION['user_id'])){
        return True;
    } else {
        return False;
    }
}