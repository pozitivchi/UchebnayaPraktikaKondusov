<?php
require_once '../includes/auth.php';
requireRole(['admin']);
require_once '../includes/database.php';

$users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$sales = $pdo->query("SELECT SUM(total) FROM orders WHERE status!='Отменен'")->fetchColumn();
$products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
?>
<!doctype html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Статистика</title></head>
<body>

<h2>Статистика</h2>

<ul>
<li>Пользователей: <?=$users?></li>
<li>Товаров: <?=$products?></li>
<li>Заказов: <?=$orders?></li>
<li>Сумма продаж: <?=$sales?> ₽</li>
</ul>

<p><a href="dashboard.php">← Назад</a></p>

</body>
</html>
