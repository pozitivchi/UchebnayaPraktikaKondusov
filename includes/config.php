<?php
$DB_HOST = 'localhost';
$DB_NAME = 'shoestore';
$DB_USER = 'root';
$DB_PASS = '';

?>
<?php
// Запуск сессии
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Подключаем логгер
require_once __DIR__ . '/logger.php';

// Отображение ошибок (можно выключить на проде)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Логирование исключений
set_exception_handler(function($e) {
    $uid = $_SESSION['user']['id'] ?? null;
    logEvent(
        'error',
        'Exception: '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine(),
        $uid
    );
});

// Логирование ошибок PHP
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    $uid = $_SESSION['user']['id'] ?? null;
    logEvent(
        'error',
        "PHP error [$errno]: $errstr in $errfile:$errline",
        $uid
    );
    return false; // позволяем PHP обработать дальше
});
