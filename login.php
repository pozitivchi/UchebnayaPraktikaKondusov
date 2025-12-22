<?php
require_once 'includes/config.php';   // session_start()
require_once 'includes/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Введите корректный email';
    }

    if ($pass === '') {
        $errors[] = 'Введите пароль';
    }

    if (empty($errors)) {
        $st = $pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $st->execute([$email]);
        $user = $st->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($pass, $user['password'])) {
            $errors[] = 'Неверный email или пароль';
        } elseif (!empty($user['is_blocked'])) {
            $errors[] = 'Ваш аккаунт заблокирован администратором';
        } else {
            // ✅ успешный вход
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role']
            ];

            header('Location: index.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
<script defer src="assets/js/ui.js"></script>
<title>Вход</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h2>Вход</h2>

<?php if ($errors): ?>
<div style="color:red">
<ul>
<?php foreach ($errors as $e): ?>
<li><?=htmlspecialchars($e)?></li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>

<form method="post">
<p>
<input type="email" name="email" placeholder="Email"
       value="<?=htmlspecialchars($_POST['email'] ?? '')?>" required>
</p>
<p>
<input type="password" name="password" placeholder="Пароль" required>
</p>
<button type="submit">Войти</button>
</form>

<p>
<a href="forgot_password.php">Забыли пароль?</a>
</p>

<p>
Нет аккаунта? <a href="register.php">Регистрация</a>
</p>

</body>
</html>
