<?php
/**
 * Which method in which MVC set will be executed
 * for each defined action in this array.
 */
$actions = array(
    'index' => \Ragnaroq\App\Runner::mvcAction('home', 'index'),
    'welcome' => \Ragnaroq\App\Runner::mvcAction('example', 'greet'),
    'authorize' => \Ragnaroq\App\Runner::mvcAction('oauth2', 'authorizeCallback'),
);

/**
 * Which of the previously defined actions will
 * be executed in each route.
 */
$routes = array(
    'GET' => array(
        'homepage' => $actions['index'],
        'example' => $actions['welcome'],
        'authorize_callback' => $actions['authorize'],
    ),
    'POST' => array(

    ),
    'DELETE' => array(

    ),
    'PUT' => array(

    ),
    'OPTIONS' => array(

    ),
);

return $routes;
