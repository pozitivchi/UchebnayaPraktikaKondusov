<?php
require_once 'includes/auth.php';
requireAuth();

$user = $_SESSION['user'];
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
<script defer src="assets/js/ui.js"></script>
<title>Профиль</title>
</head>
<body>

<h2>Профиль</h2>

<p><b>Имя:</b> <?=htmlspecialchars($user['name'])?></p>
<p><b>Email:</b> <?=htmlspecialchars($user['email'])?></p>
<p><b>Роль:</b> <?=htmlspecialchars($user['role'])?></p>

<?php if(in_array($user['role'], ['admin','manager'])): ?>
<p><a href="admin/dashboard.php">⚙ Админ-панель</a></p>
<?php endif; ?>

<p><a href="logout.php">Выйти</a></p>

</body>
</html>
