<?php
require_once 'includes/config.php';
require_once 'includes/database.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$st = $pdo->prepare(
    "SELECT * FROM orders WHERE user_id=? ORDER BY id DESC"
);
$st->execute([$_SESSION['user']['id']]);
$orders = $st->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Мои заказы</title>
</head>
<body>

<h2>Мои заказы</h2>

<?php if (isset($_GET['success'])): ?>
<p style="color:green;">Заказ успешно оформлен!</p>
<?php endif; ?>

<?php if (!$orders): ?>
<p>У вас пока нет заказов.</p>
<?php else: ?>
<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Дата</th>
    <th>Статус</th>
    <th>Адрес</th>
</tr>
<?php foreach ($orders as $o): ?>
<tr>
    <td><?= htmlspecialchars($o['id']) ?></td>
    <td><?= htmlspecialchars($o['order_date'] ?? '') ?></td>
    <td><?= htmlspecialchars($o['status']) ?></td>
    <td><?= htmlspecialchars($o['delivery_address'] ?? '') ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

</body>
</html>