<?php
require_once 'includes/database.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    $st = $pdo->prepare("SELECT id FROM users WHERE email=?");
    $st->execute([$email]);
    $u = $st->fetch(PDO::FETCH_ASSOC);

    if ($u) {
        // удалим старые токены
        $pdo->prepare("DELETE FROM password_resets WHERE user_id=?")
            ->execute([$u['id']]);

        $token = bin2hex(random_bytes(32));
        $exp = date('Y-m-d H:i:s', time() + 3600);

        $pdo->prepare(
          "INSERT INTO password_resets(user_id, token, expires_at)
           VALUES(?,?,?)"
        )->execute([$u['id'], $token, $exp]);

        $link = "http://localhost/shoestore/reset.php?token=$token";
        $msg = "Ссылка для восстановления (учебный режим):<br>
                <a href=\"$link\">$link</a>";
    } else {
        $msg = "Если такой email существует, ссылка будет отправлена.";
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
<script defer src="assets/js/ui.js"></script>
<title>Восстановление пароля</title>
</head>
<body>

<h2>Восстановление пароля</h2>
<?= $msg ? "<p>$msg</p>" : "" ?>

<form method="post">
    <input type="email" name="email" placeholder="Введите email" required>
    <button type="submit">Отправить</button>
</form>

<p><a href="login.php">← Назад</a></p>

</body>
</html>
