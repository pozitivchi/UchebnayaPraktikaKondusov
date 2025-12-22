<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? null;
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>ShoeStore</title>
<style>
body { margin:0; font-family: Arial, sans-serif; background:#f6f6f6; }
header { background:#222; color:#fff; padding:10px 20px; }
nav a {
  color:#fff; margin-right:15px; text-decoration:none; font-weight:bold;
}
nav a:hover { text-decoration:underline; }
.container { padding:20px; }
#loader {
  display:none;
  position:fixed;
  inset:0;
  background:rgba(255,255,255,0.8);
  z-index:9999;
  text-align:center;
  padding-top:200px;
  font-size:24px;
}
</style>
</head>
<body>

<!-- Loader -->
<div id="loader">Загрузка...</div>

<header>
  <nav>
    <a href="/shoestore/index.php">Главная</a>
    <a href="/shoestore/catalog.php">Каталог</a>
    <a href="/shoestore/cart.php">Корзина</a>

    <?php if($user): ?>
        <a href="/shoestore/orders.php">Мои заказы</a>
        <a href="/shoestore/profile.php">Профиль</a>

        <?php if(in_array($role, ['admin','manager'])): ?>
            <a href="/shoestore/admin/products.php">Админка</a>
        <?php endif; ?>

        <a href="/shoestore/logout.php">Выход</a>
    <?php else: ?>
        <a href="/shoestore/login.php">Вход</a>
        <a href="/shoestore/register.php">Регистрация</a>
    <?php endif; ?>
  </nav>
</header>

<div class="container">
