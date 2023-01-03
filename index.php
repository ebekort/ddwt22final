<?php

include 'model.php';

/* connect to database */
$db = connect_db('localhost', 'ddwt22_final', 'ddwt22', 'ddwt22');

/* array for navigation */
$template = Array(
    1 => Array(
        'name' => 'Home',
        'url' => '/final'
    ),
    2 => Array(
        'name' => 'Rooms',
        'url' => '/final/rooms/'
    ),
    3 => Array(
        'name' => 'My Account',
        'url' => '/final/myaccount'
    ),
    4 => Array(
        'name' => 'Add Room',
        'url' => '/final/add'
    ),
    5 => Array(
        'name' => 'Registration',
        'url' => '/final/register'
    ));

/* home page */
if (new_route('/final/', 'get')) {
    /* page info */
    $page_title = 'student rooms';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/final/', True)
    ]);
    $navigation = get_navigation($template, 1);
    $page_subtitle = 'here you can rent and advertise student rooms';
    $page_content = 'hello';

    include use_template('main');
}

if (new_route('/final/rooms/', 'get')) {
    /* page info */
    $page_title = 'student rooms';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/final/', True)
    ]);
    $navigation = get_navigation($template, 2);
    $page_subtitle = 'overview of all rooms';
    $rooms = get_rooms($db);
    $page_content = get_rooms_exp($rooms);

    include use_template('main');
}

if (new_route('/final/myaccount', 'get')) {
    /* page info */
    $page_title = 'student rooms';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT22/week2/', True)
    ]);
    $navigation = get_navigation($template, 3);
    $page_subtitle = 'myaccount';
    $page_content = 'account';

    include use_template('main');
}

if (new_route('/final/add', 'get')) {
    /* page info */
    $page_title = 'student rooms';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT22/week2/', True)
    ]);
    $navigation = get_navigation($template, 4);
    $page_subtitle = 'add room';
    $page_content = 'room';

    include use_template('main');
}

if (new_route('/final/register', 'get')) {
    /* page info */
    $page_title = 'student rooms';
    $breadcrumbs = get_breadcrumbs([
        'Home' => na('/DDWT22/week2/', True)
    ]);
    $navigation = get_navigation($template, 2);
    $page_subtitle = 'register';
    $page_content = 'register';

    include use_template('main');
}