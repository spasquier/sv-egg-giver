<?php
/**
 * Which method in which MVC set will be executed
 * for each defined action in this array.
 */
$actions = array(
    'welcome' => \Ragnaroq\App\Runner::mvcAction('example', 'greet'),
);

/**
 * Which of the previously defined actions will
 * be executed in each route.
 */
$routes = array(
    'GET' => array(
        'example' => $actions['welcome'],
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
