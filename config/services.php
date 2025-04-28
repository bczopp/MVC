<?php
use Tornado\Controller\HomeController;
use Tornado\Repository\UserRepository;
use Tornado\Service\Container;
use Tornado\Service\View;

return [
    // PDO
    function(Container $container) {
        $container->set(PDO::class, function() {
            $host = getenv('DB_HOST');
            $db   = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');
            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
            return new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        });
    },

    // Repositories
    function(Container $container) {
        $container->set(UserRepository::class, function($container) {
            return new UserRepository($container->get(PDO::class));
        });
    },

    // Controller
    function(Container $container) {
        $container->set(HomeController::class, function($container) {
            return new HomeController(
                $container->get(UserRepository::class),
                new View()
            );
        });
    }
];
