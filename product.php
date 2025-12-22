<?php
require_once 'includes/database.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) die('Нет товара');

$st = $pdo->prepare("SELECT * FROM products WHERE id=? AND status='active'");
$st->execute([$id]);
$product = $st->fetch(PDO::FETCH_ASSOC);
if(!$product) die('Товар не найден');

$st2 = $pdo->prepare("SELECT size, stock FROM product_sizes WHERE product_id=? AND stock>0 ORDER BY size");
$st2->execute([$id]);
$sizes = $st2->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title><?=$product['name']?></title>
</head>
<body>

<h2><?=htmlspecialchars($product['name'])?></h2>
<p><?=$product['description']?></p>
<p><b><?=$product['price']?> ₽</b></p>

<form method="post" action="cart.php">
<input type="hidden" name="product_id" value="<?=$product['id']?>">

<label>Размер:</label>
<select name="size" id="sizeSelect" required>
<option value="">Выберите размер</option>
<?php foreach($sizes as $s): ?>
  <option value="<?=$s['size']?>" data-stock="<?=$s['stock']?>">
    <?=$s['size']?> (<?=$s['stock']?> шт.)
  </option>
<?php endforeach; ?>
</select><br>

<label>Количество:</label>
<input type="number" name="quantity" id="qtyInput" value="1" min="1" required><br><br>

<button>Добавить в корзину</button>
</form>

<script>
const sizeSel = document.getElementById('sizeSelect');
const qtyInp = document.getElementById('qtyInput');

sizeSel.addEventListener('change', function(){
  const stock = this.options[this.selectedIndex].dataset.stock || 1;
  qtyInp.max = stock;
  if (qtyInp.value > stock) qtyInp.value = stock;
});
</script>

</body>
</html>
