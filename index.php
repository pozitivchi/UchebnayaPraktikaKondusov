<?php require_once 'includes/database.php'; ?>
<?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] != 'user'): ?>
    <a href="admin/dashboard.php">Админ-панель</a> |
<?php endif; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Магазин обуви</title>
<link rel="stylesheet" href="assets/css/style.css">
<script defer src="assets/js/ui.js"></script>
</head>
<body>
<header>
  <a href="index.php">Главная</a> |
  <a href="catalog.php">Каталог</a> |
  <a href="cart.php">Корзина</a> |
  <?php if(isset($_SESSION['user'])): ?>
    <a href="profile.php">Профиль</a> |
    <a href="logout.php">Выход</a>
  <?php else: ?>
    <a href="login.php">Вход</a> |
    <a href="register.php">Регистрация</a>
  <?php endif; ?>
</header>

<h1>Добро пожаловать в магазин обуви</h1>
<div class="products">
<?php
$stmt = $pdo->query("SELECT * FROM products WHERE status='active' ORDER BY created_at DESC LIMIT 6");
while($p = $stmt->fetch()): ?>
<div class="product">
  <h3><?= htmlspecialchars($p['name']) ?></h3>
  <p><?= $p['price'] ?> ₽</p>
  <a href="product.php?id=<?= $p['id'] ?>">Подробнее</a>
</div>
<?php endwhile; ?>
</div>
</body>
</html>