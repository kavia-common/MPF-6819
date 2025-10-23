<?php
    require __DIR__. "/vendor/autoload.php";

    use MPF\Core\Router;
    use MPF\Core\View;
    use MPF\Core\Res;

    // Health endpoint for container readiness checks
    Router::get('/health', function () {
        Res::status(200);
        header("Content-Type: text/plain; charset=utf-8");
        echo "OK";
        return;
    });

    // Root route
    Router::get('/', function () {
        return View::view('welcome');
    });
    
    Router::fallback('404');

    // If a public directory exists, expose it as static assets
    Router::static("/public/"); 
    
    Router::run();
 