<?php
require_once 'includes/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $pass1 = $_POST['password'] ?? '';
    $pass2 = $_POST['password_confirm'] ?? '';

    if ($name === '') {
        $errors[] = 'Введите имя';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный email';
    }

    if (strlen($pass1) < 6) {
        $errors[] = 'Пароль должен быть не менее 6 символов';
    }

    if ($pass1 !== $pass2) {
        $errors[] = 'Пароли не совпадают';
    }

    // 🔍 Проверка уникальности email
    if (empty($errors)) {
        $st = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $st->execute([$email]);
        if ($st->fetch()) {
            $errors[] = 'Пользователь с таким email уже существует';
        }
    }

    // ✅ Если ошибок нет — регистрируем
    if (empty($errors)) {
        $hash = password_hash($pass1, PASSWORD_BCRYPT);

        $st = $pdo->prepare(
            "INSERT INTO users(name, email, phone, password) VALUES(?,?,?,?)"
        );
        $st->execute([$name, $email, $phone, $hash]);

        header('Location: login.php');
        exit;
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Регистрация</title>
<link rel="stylesheet" href="assets/css/style.css">
<script defer src="assets/js/ui.js"></script>
</head>
<body>

<h2>Регистрация</h2>

<?php if (!empty($errors)): ?>
<div style="color:red">
    <ul>
        <?php foreach ($errors as $e): ?>
            <li><?=htmlspecialchars($e)?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="post">
    <input type="text" name="name" placeholder="Имя"
           value="<?=htmlspecialchars($_POST['name'] ?? '')?>" required><br><br>

    <input type="email" name="email" placeholder="Email"
           value="<?=htmlspecialchars($_POST['email'] ?? '')?>" required><br><br>

    <input type="text" name="phone" placeholder="Телефон"
           value="<?=htmlspecialchars($_POST['phone'] ?? '')?>"><br><br>

    <input type="password" name="password" placeholder="Пароль" required><br><br>

    <input type="password" name="password_confirm"
           placeholder="Повторите пароль" required><br><br>

    <button type="submit">Зарегистрироваться</button>
</form>

<p><a href="login.php">Уже есть аккаунт? Войти</a></p>

</body>
</html>
