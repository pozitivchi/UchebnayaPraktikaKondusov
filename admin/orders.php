<?php
require_once '../includes/auth.php';
requireRole(['admin','manager']);
require_once '../includes/database.php';

// смена статуса (используем допустимые значения ENUM)
if (isset($_POST['id'], $_POST['status'])) {
    $allowedStatuses = ['Новый', 'В обработке', 'Отправлен', 'Доставлен', 'Отменен'];
    $status = $_POST['status'];
    if (in_array($status, $allowedStatuses)) {
        $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?")
            ->execute([$status, $_POST['id']]);
    }
}

$orders = $pdo->query(
    "SELECT o.*, u.name 
     FROM orders o 
     JOIN users u ON u.id = o.user_id 
     ORDER BY o.id DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Заказы</title>
</head>
<body>

<h2>Заказы</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th><th>Покупатель</th><th>Сумма</th>
    <th>Доставка</th><th>Оплата</th>
    <th>Адрес</th><th>Статус</th><th></th>
</tr>

<?php foreach ($orders as $o): ?>
<tr>
    <td><?= htmlspecialchars($o['id']) ?></td>
    <td><?= htmlspecialchars($o['name'] ?? '') ?></td>
    <td><?= htmlspecialchars($o['total'] ?? 0) ?> ₽</td>
    <td><?= htmlspecialchars($o['delivery_method'] ?? '') ?></td>
    <td><?= htmlspecialchars($o['payment_method'] ?? '') ?></td>
    <td><?= htmlspecialchars($o['delivery_address'] ?? '') ?></td>  <!-- исправлено: delivery_address -->
    <td><?= htmlspecialchars($o['status'] ?? '') ?></td>
    <td>
        <form method="post" style="display:inline">
            <input type="hidden" name="id" value="<?= $o['id'] ?>">
            <select name="status">
                <?php
                // допустимые статусы из ENUM таблицы orders
                $statuses = ['Новый', 'В обработке', 'Отправлен', 'Доставлен', 'Отменен'];
                foreach ($statuses as $s):
                ?>
                <option value="<?= $s ?>" <?= ($s == ($o['status'] ?? '')) ? 'selected' : '' ?>>
                    <?= $s ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button>✔</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>

<p><a href="dashboard.php">← Назад</a></p>

</body>
</html>