<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../includes/auth.php';
requireRole(['admin','manager']);
require_once '../includes/database.php';
require_once '../includes/logger.php';

$uploadDir = __DIR__ . '/../uploads/';

// удаление товара
if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];

    // удалить изображения
    $imgs = $pdo->prepare("SELECT image FROM product_images WHERE product_id=?");
    $imgs->execute([$id]);
    foreach($imgs as $img){
        @unlink($uploadDir . $img['image']);
    }
    $pdo->prepare("DELETE FROM product_images WHERE product_id=?")->execute([$id]);

    // удалить размеры
    $pdo->prepare("DELETE FROM product_sizes WHERE product_id=?")->execute([$id]);

    // удалить товар
    $pdo->prepare("DELETE FROM products WHERE id=?")->execute([$id]);

    logEvent('admin', "Удалён товар ID=$id со всеми размерами и изображениями", $_SESSION['user']['id']);
    header('Location: products.php');
    exit;
}

// удаление изображения
if (isset($_GET['del_img'])) {
    $imgId = (int)$_GET['del_img'];
    $st = $pdo->prepare("SELECT image, product_id FROM product_images WHERE id=?");
    $st->execute([$imgId]);
    if ($img = $st->fetch(PDO::FETCH_ASSOC)) {
        @unlink($uploadDir . $img['image']);
        $pdo->prepare("DELETE FROM product_images WHERE id=?")->execute([$imgId]);
        logEvent('admin', "Удалено изображение {$img['image']} товара ID={$img['product_id']}", $_SESSION['user']['id']);
        header('Location: products.php?edit='.$img['product_id']);
        exit;
    }
}

// получение товара, размеров и изображений
$edit = null;
$sizesEdit = [];
$imagesEdit = [];

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];

    $st = $pdo->prepare("SELECT * FROM products WHERE id=?");
    $st->execute([$id]);
    $edit = $st->fetch(PDO::FETCH_ASSOC);

    $st2 = $pdo->prepare("SELECT size, stock FROM product_sizes WHERE product_id=? ORDER BY size");
    $st2->execute([$id]);
    $sizesEdit = $st2->fetchAll(PDO::FETCH_ASSOC);

    $st3 = $pdo->prepare("SELECT id, image FROM product_images WHERE product_id=?");
    $st3->execute([$id]);
    $imagesEdit = $st3->fetchAll(PDO::FETCH_ASSOC);
}

// сохранение товара
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?: null;

    $data = [
        $_POST['name'],
        $_POST['description'],
        $_POST['category'],
        $_POST['brand'],
        $_POST['price'],
        $_POST['materials'],
        $_POST['status']
    ];

    if ($id) {
        $pdo->prepare(
            "UPDATE products 
             SET name=?, description=?, category=?, brand=?, price=?, materials=?, status=? 
             WHERE id=?"
        )->execute([...$data, $id]);

        logEvent('admin', "Обновлён товар ID=$id", $_SESSION['user']['id']);
    } else {
        $pdo->prepare(
            "INSERT INTO products (name,description,category,brand,price,materials,status)
             VALUES (?,?,?,?,?,?,?)"
        )->execute($data);

        $id = $pdo->lastInsertId();
        logEvent('admin', "Добавлен товар ID=$id", $_SESSION['user']['id']);
    }

    // размеры
    $pdo->prepare("DELETE FROM product_sizes WHERE product_id=?")->execute([$id]);
    if (!empty($_POST['sizes'])) {
        foreach ($_POST['sizes'] as $i=>$size) {
            $size = trim($size);
            $stock = (int)($_POST['stocks'][$i] ?? 0);
            if ($size !== '') {
                $pdo->prepare(
                    "INSERT INTO product_sizes (product_id,size,stock) VALUES (?,?,?)"
                )->execute([$id, $size, $stock]);
            }
        }
        logEvent('admin', "Обновлены размеры товара ID=$id", $_SESSION['user']['id']);
    }

    // загрузка изображений
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $i=>$tmp) {
            if (is_uploaded_file($tmp)) {
                $name = time().'_'.basename($_FILES['images']['name'][$i]);
                move_uploaded_file($tmp, $uploadDir.$name);
                $pdo->prepare(
                    "INSERT INTO product_images (product_id, image) VALUES (?,?)"
                )->execute([$id, $name]);
                logEvent('admin', "Добавлено изображение $name к товару ID=$id", $_SESSION['user']['id']);
            }
        }
    }

    header('Location: products.php?edit='.$id);
    exit;
}

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Товары</title>
<script>
function addSizeRow(size='', stock='') {
    const d = document.createElement('div');
    d.innerHTML = `
      Размер: <input name="sizes[]" value="${size}" style="width:60px;">
      Остаток: <input name="stocks[]" type="number" value="${stock}" style="width:80px;">
      <button type="button" onclick="this.parentNode.remove()">✖</button>
    `;
    document.getElementById('sizesBox').appendChild(d);
}
</script>
</head>
<body>

<h2>Товары</h2>

<h3><?= $edit ? 'Редактировать товар' : 'Добавить товар' ?></h3>

<form method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=htmlspecialchars($edit['id'] ?? '')?>">

<input name="name" placeholder="Название" required value="<?=htmlspecialchars($edit['name'] ?? '')?>"><br>
<input name="price" placeholder="Цена" required value="<?=htmlspecialchars($edit['price'] ?? '')?>"><br>
<input name="category" placeholder="Категория" value="<?=htmlspecialchars($edit['category'] ?? '')?>"><br>
<input name="brand" placeholder="Бренд" value="<?=htmlspecialchars($edit['brand'] ?? '')?>"><br>
<input name="materials" placeholder="Материалы" value="<?=htmlspecialchars($edit['materials'] ?? '')?>"><br>

<select name="status">
  <option value="active" <?=($edit['status'] ?? '')==='active'?'selected':''?>>active</option>
  <option value="hidden" <?=($edit['status'] ?? '')==='hidden'?'selected':''?>>hidden</option>
</select><br>

<textarea name="description" placeholder="Описание"><?=htmlspecialchars($edit['description'] ?? '')?></textarea><br>

<h4>Размеры и остатки</h4>
<div id="sizesBox">
<?php foreach($sizesEdit as $s): ?>
<div>
  Размер: <input name="sizes[]" value="<?=$s['size']?>" style="width:60px;">
  Остаток: <input name="stocks[]" type="number" value="<?=$s['stock']?>" style="width:80px;">
  <button type="button" onclick="this.parentNode.remove()">✖</button>
</div>
<?php endforeach; ?>
</div>
<button type="button" onclick="addSizeRow()">+ Добавить размер</button>

<h4>Изображения</h4>
<?php foreach($imagesEdit as $img): ?>
  <div>
    <img src="../uploads/<?=$img['image']?>" width="80">
    <a href="?del_img=<?=$img['id']?>" onclick="return confirm('Удалить изображение?')">🗑</a>
  </div>
<?php endforeach; ?>

<input type="file" name="images[]" multiple><br><br>

<button>Сохранить</button>
<?php if($edit): ?><a href="products.php">Отмена</a><?php endif; ?>
</form>

<hr>

<table border="1" cellpadding="5">
<tr><th>ID</th><th>Название</th><th>Цена</th><th>Статус</th><th></th></tr>
<?php foreach($products as $p): ?>
<tr>
<td><?=$p['id']?></td>
<td><?=htmlspecialchars($p['name'])?></td>
<td><?=$p['price']?></td>
<td><?=$p['status']?></td>
<td>
  <a href="?edit=<?=$p['id']?>">✏️</a>
  <a href="?del=<?=$p['id']?>" onclick="return confirm('Удалить?')">🗑</a>
</td>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>
