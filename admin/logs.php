<?php
require_once '../includes/auth.php';
requireRole(['admin']);
require_once '../includes/database.php';

$type = $_GET['type'] ?? '';
$where = '';
$params = [];

if ($type !== '') {
    $where = "WHERE l.type = ?";
    $params[] = $type;
}

$st = $pdo->prepare(
 "SELECT l.*, u.email
  FROM logs l
  LEFT JOIN users u ON u.id = l.user_id
  $where
  ORDER BY l.id DESC
  LIMIT 500"
);
$st->execute($params);
$logs = $st->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Логи системы</title>
</head>
<body>

<h2>Логи системы</h2>

<form method="get">
Фильтр:
<select name="type">
<option value="">Все</option>
<option value="admin" <?=$type=='admin'?'selected':''?>>admin</option>
<option value="order" <?=$type=='order'?'selected':''?>>order</option>
<option value="error" <?=$type=='error'?'selected':''?>>error</option>
</select>
<button>Применить</button>
</form>

<table border="1" cellpadding="5">
<tr>
<th>ID</th><th>Дата</th><th>Тип</th><th>Email</th><th>Сообщение</th>
</tr>
<?php foreach($logs as $l): ?>
<tr>
<td><?=$l['id']?></td>
<td><?=$l['created_at']?></td>
<td><?=$l['type']?></td>
<td><?=$l['email'] ?? '-'?></td>
<td><?=htmlspecialchars($l['message'])?></td>
</tr>
<?php endforeach; ?>
</table>

<p><a href="dashboard.php">← Назад</a></p>

</body>
</html>
