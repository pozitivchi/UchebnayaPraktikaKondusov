<?php
require_once '../includes/auth.php';
requireRole(['admin','manager']);
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Админ-панель</title>
</head>
<body>

<h2>Админ-панель</h2>

<?php if(in_array($_SESSION['user']['role'], ['admin','manager'])): ?>
<p><a href="products.php">🛒 Управление товарами</a></p>
<p><a href="orders.php">📦 Заказы</a></p>
<?php endif; ?>

<?php if($_SESSION['user']['role']=='admin'): ?>
<p><a href="users.php">👥 Пользователи</a></p>
<p><a href="stats.php">📊 Статистика</a></p>
<p><a href="logs.php">📝 Логи системы</a></p>
<?php endif; ?>

<p><a href="../index.php">← На сайт</a></p>

</body>
</html>
