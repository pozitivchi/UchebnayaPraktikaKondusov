<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'includes/database.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// добавление в корзину
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['product_id'])) {
    $pid  = (int)$_POST['product_id'];
    $size = $_POST['size'] ?? '';
    $qty  = max(1, (int)$_POST['quantity']);

    // берём остаток из БД
    $st = $pdo->prepare(
        "SELECT stock FROM product_sizes WHERE product_id=? AND size=?"
    );
    $st->execute([$pid, $size]);
    $row = $st->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        die('Неверный размер');
    }

    $stock = (int)$row['stock'];
    $key = $pid.'_'.$size;
    $already = $_SESSION['cart'][$key]['quantity'] ?? 0;

    // не даём превысить склад
    if ($already + $qty > $stock) {
        $qty = $stock - $already;
    }

    if ($qty > 0) {
        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['quantity'] += $qty;
        } else {
            $_SESSION['cart'][$key] = [
                'product_id' => $pid,
                'size' => $size,
                'quantity' => $qty
            ];
        }
    }

    header('Location: cart.php');
    exit;
}

// удалить позицию
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header('Location: cart.php');
    exit;
}

// очистить
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header('Location: cart.php');
    exit;
}
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Корзина</title>
</head>
<body>

<h2>Корзина</h2>

<?php if (!$_SESSION['cart']): ?>
<p>Корзина пуста</p>
<?php else: ?>
<table border="1" cellpadding="5">
<tr>
  <th>Товар</th><th>Размер</th><th>Кол-во</th><th></th>
</tr>
<?php
$total = 0;
foreach($_SESSION['cart'] as $key=>$item):
    $st = $pdo->prepare("SELECT name, price FROM products WHERE id=?");
    $st->execute([$item['product_id']]);
    $p = $st->fetch(PDO::FETCH_ASSOC);
    if(!$p) continue;
    $sum = $p['price'] * $item['quantity'];
    $total += $sum;
?>
<tr>
  <td><?=htmlspecialchars($p['name'])?></td>
  <td><?=$item['size']?></td>
  <td><?=$item['quantity']?></td>
  <td><a href="?remove=<?=$key?>">Удалить</a></td>
</tr>
<?php endforeach; ?>
</table>

<p><b>Итого: <?=$total?> ₽</b></p>
<a href="?clear=1">Очистить корзину</a><br><br>
<a href="checkout.php">Оформить заказ</a>
<?php endif; ?>

</body>
</html>
