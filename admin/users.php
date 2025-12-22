<?php
require_once '../includes/auth.php';
requireRole(['admin']);
require_once '../includes/database.php';
require_once '../includes/logger.php';

// обновление
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $pdo->prepare(
      "UPDATE users SET name=?, email=?, role=?, is_blocked=? WHERE id=?"
    )->execute([
      $_POST['name'], $_POST['email'],
      $_POST['role'], $_POST['is_blocked'], $_POST['id']
    ]);

    logEvent(
      'admin',
      "Изменён пользователь ID={$_POST['id']} роль={$_POST['role']} блок={$_POST['is_blocked']}",
      $_SESSION['user']['id']
    );
}

$edit = null;
if (isset($_GET['edit'])) {
    $st = $pdo->prepare("SELECT * FROM users WHERE id=?");
    $st->execute([$_GET['edit']]);
    $edit = $st->fetch();
}

$users = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
?>
<!doctype html>
<html><head><meta charset="UTF-8"><title>Пользователи</title></head>
<body>

<h2>Пользователи</h2>

<?php if($edit): ?>
<form method="post">
<input type="hidden" name="id" value="<?=$edit['id']?>">
<input name="name" value="<?=$edit['name']?>" required>
<input name="email" value="<?=$edit['email']?>" required>

<select name="role">
<option value="user" <?=$edit['role']=='user'?'selected':''?>>user</option>
<option value="manager" <?=$edit['role']=='manager'?'selected':''?>>manager</option>
<option value="admin" <?=$edit['role']=='admin'?'selected':''?>>admin</option>
</select>

<select name="is_blocked">
<option value="0" <?=$edit['is_blocked']==0?'selected':''?>>активен</option>
<option value="1" <?=$edit['is_blocked']==1?'selected':''?>>заблокирован</option>
</select>

<button>Сохранить</button>
<a href="users.php">Отмена</a>
</form>
<hr>
<?php endif; ?>

<table border="1" cellpadding="5">
<tr>
<th>ID</th><th>Имя</th><th>Email</th><th>Роль</th><th>Статус</th><th></th>
</tr>
<?php foreach($users as $u): ?>
<tr>
<td><?=$u['id']?></td>
<td><?=$u['name']?></td>
<td><?=$u['email']?></td>
<td><?=$u['role']?></td>
<td><?=$u['is_blocked']?'заблокирован':'активен'?></td>
<td><a href="?edit=<?=$u['id']?>">✏️</a></td>
</tr>
<?php endforeach; ?>
</table>

</body></html>
