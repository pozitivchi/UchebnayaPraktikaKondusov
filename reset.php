<?php
require_once 'includes/database.php';

$token = $_GET['token'] ?? '';
$errors = [];
$success = false;

if (!$token) {
    die('Токен не указан');
}

$st = $pdo->prepare(
 "SELECT pr.user_id, pr.expires_at
  FROM password_resets pr
  WHERE pr.token=?"
);
$st->execute([$token]);
$row = $st->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die('Ссылка недействительна или устарела');
}

if (strtotime($row['expires_at']) < time()) {
    die('Срок действия ссылки истёк');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p1 = $_POST['password'] ?? '';
    $p2 = $_POST['password_confirm'] ?? '';

    if (strlen($p1) < 6) $errors[] = 'Пароль минимум 6 символов';
    if ($p1 !== $p2) $errors[] = 'Пароли не совпадают';

    if (empty($errors)) {
        $hash = password_hash($p1, PASSWORD_BCRYPT);

        $pdo->prepare("UPDATE users SET password=? WHERE id=?")
            ->execute([$hash, $row['user_id']]);

        $pdo->prepare("DELETE FROM password_resets WHERE user_id=?")
            ->execute([$row['user_id']]);

        $success = true;
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
<script defer src="assets/js/ui.js"></script>
<title>Новый пароль</title>
</head>
<body>

<h2>Сброс пароля</h2>

<?php if ($success): ?>
<p style="color:green">
Пароль обновлён. <a href="login.php">Войти</a>
</p>
<?php else: ?>

<?php if ($errors): ?>
<ul style="color:red">
<?php foreach ($errors as $e): ?>
<li><?=htmlspecialchars($e)?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<form method="post">
    <input type="password" name="password" placeholder="Новый пароль" required><br><br>
    <input type="password" name="password_confirm" placeholder="Повторите пароль" required><br><br>
    <button type="submit">Сохранить</button>
</form>

<?php endif; ?>

</body>
</html>
