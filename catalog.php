<?php
require_once 'includes/database.php';

$perPage = 12;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

// --- параметры ---
$q = trim($_GET['q'] ?? '');
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';
$size = $_GET['size'] ?? '';
$category = $_GET['category'] ?? '';
$brand = $_GET['brand'] ?? '';
$color = $_GET['color'] ?? '';
$sort = $_GET['sort'] ?? 'new';

// --- базовый SQL ---
$where = ["p.status='active'"];
$params = [];

if ($q !== '') {
    $where[] = "(p.name LIKE ? OR p.description LIKE ?)";
    $params[] = "%$q%";
    $params[] = "%$q%";
}
if ($min !== '') { $where[] = "p.price >= ?"; $params[] = $min; }
if ($max !== '') { $where[] = "p.price <= ?"; $params[] = $max; }
if ($category !== '') { $where[] = "p.category = ?"; $params[] = $category; }
if ($brand !== '') { $where[] = "p.brand = ?"; $params[] = $brand; }
if ($color !== '') { $where[] = "pc.color = ?"; $params[] = $color; }
if ($size !== '') { $where[] = "ps.size = ?"; $params[] = $size; }

$whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

$order = "p.created_at DESC";
if ($sort === 'price_asc') $order = "p.price ASC";
if ($sort === 'price_desc') $order = "p.price DESC";

// --- общее кол-во ---
$countSql = "
SELECT COUNT(DISTINCT p.id)
FROM products p
LEFT JOIN product_sizes ps ON ps.product_id=p.id
LEFT JOIN product_colors pc ON pc.product_id=p.id
$whereSql
";
$st = $pdo->prepare($countSql);
$st->execute($params);
$total = $st->fetchColumn();
$pages = ceil($total / $perPage);

// --- товары ---
$sql = "
SELECT DISTINCT p.*
FROM products p
LEFT JOIN product_sizes ps ON ps.product_id=p.id
LEFT JOIN product_colors pc ON pc.product_id=p.id
$whereSql
ORDER BY $order
LIMIT $perPage OFFSET $offset
";
$st = $pdo->prepare($sql);
$st->execute($params);
$products = $st->fetchAll(PDO::FETCH_ASSOC);

// --- данные для фильтров ---
$cats = $pdo->query("SELECT DISTINCT category FROM products")->fetchAll(PDO::FETCH_COLUMN);
$brands = $pdo->query("SELECT DISTINCT brand FROM products")->fetchAll(PDO::FETCH_COLUMN);
$sizes = $pdo->query("SELECT DISTINCT size FROM product_sizes ORDER BY size")->fetchAll(PDO::FETCH_COLUMN);
$colors = $pdo->query("SELECT DISTINCT color FROM product_colors")->fetchAll(PDO::FETCH_COLUMN);
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Каталог</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h2>Каталог обуви</h2>

<form method="get">
<input name="q" placeholder="Поиск" value="<?=htmlspecialchars($q)?>">

Цена:
<input name="min" style="width:70px" placeholder="от" value="<?=htmlspecialchars($min)?>">
<input name="max" style="width:70px" placeholder="до" value="<?=htmlspecialchars($max)?>">

<select name="category">
<option value="">Категория</option>
<?php foreach($cats as $c): ?>
<option value="<?=$c?>" <?=$c==$category?'selected':''?>><?=$c?></option>
<?php endforeach; ?>
</select>

<select name="brand">
<option value="">Бренд</option>
<?php foreach($brands as $b): ?>
<option value="<?=$b?>" <?=$b==$brand?'selected':''?>><?=$b?></option>
<?php endforeach; ?>
</select>

<select name="size">
<option value="">Размер</option>
<?php foreach($sizes as $s): ?>
<option value="<?=$s?>" <?=$s==$size?'selected':''?>><?=$s?></option>
<?php endforeach; ?>
</select>

<select name="color">
<option value="">Цвет</option>
<?php foreach($colors as $c): ?>
<option value="<?=$c?>" <?=$c==$color?'selected':''?>><?=$c?></option>
<?php endforeach; ?>
</select>

<select name="sort">
<option value="new" <?=$sort=='new'?'selected':''?>>Сначала новые</option>
<option value="price_asc" <?=$sort=='price_asc'?'selected':''?>>Цена ↑</option>
<option value="price_desc" <?=$sort=='price_desc'?'selected':''?>>Цена ↓</option>
</select>

<button>Применить</button>
</form>

<hr>

<div class="products">
<?php foreach($products as $p): ?>
<?php
$imgSt = $pdo->prepare(
 "SELECT image FROM product_images WHERE product_id=? LIMIT 1"
);
$imgSt->execute([$p['id']]);
$img = $imgSt->fetchColumn();
?>
<div class="product">
<?php if($img): ?>
<img src="uploads/<?=$img?>" width="150"><br>
<?php endif; ?>
<b><?=htmlspecialchars($p['name'])?></b><br>
<?=$p['brand']?> / <?=$p['category']?><br>
<?=$p['price']?> ₽<br>
<a href="product.php?id=<?=$p['id']?>">Подробнее</a>
</div>
<?php endforeach; ?>

<?php if(!$products): ?>
<p>Ничего не найдено.</p>
<?php endif; ?>
</div>

<hr>

<!-- Пагинация -->
<?php if($pages > 1): ?>
<p>
<?php for($i=1;$i<=$pages;$i++): ?>
<a href="?<?=http_build_query(array_merge($_GET,['page'=>$i]))?>"
 style="<?=$i==$page?'font-weight:bold':''?>">
<?=$i?>
</a>
<?php endfor; ?>
</p>
<?php endif; ?>

<p><a href="index.php">← На главную</a></p>

</body>
</html>
