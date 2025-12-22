<?php
require_once 'includes/config.php';
require_once 'includes/database.php';

if (!isset($_SESSION['user'])) {
    exit('Нет доступа');
}

$data = json_decode(file_get_contents('php://input'), true);

$delivery = $data['delivery'] ?? '';
$payment  = $data['payment'] ?? '';
$address  = $data['address'] ?? '';
$cart     = $data['cart'] ?? [];

if (empty($cart['items'])) {
    exit('Корзина пуста');
}

$userId = $_SESSION['user']['id'];

$pdo->beginTransaction();

try {
    $total = 0;

    foreach ($cart['items'] as $it) {
        $st = $pdo->prepare("SELECT price FROM products WHERE id=?");
        $st->execute([$it['product_id']]);
        $price = $st->fetchColumn();
        $total += $price * $it['quantity'];
    }

    $st = $pdo->prepare(
      "INSERT INTO orders(user_id,total,delivery_method,payment_method,address)
       VALUES(?,?,?,?,?)"
    );
    $st->execute([$userId,$total,$delivery,$payment,$address]);
    $orderId = $pdo->lastInsertId();

    foreach ($cart['items'] as $it) {
        $st = $pdo->prepare("SELECT price FROM products WHERE id=?");
        $st->execute([$it['product_id']]);
        $price = $st->fetchColumn();

        $pdo->prepare(
          "INSERT INTO order_items(order_id,product_id,size,price,quantity)
           VALUES(?,?,?,?,?)"
        )->execute([$orderId,$it['product_id'],$it['size'],$price,$it['quantity']]);

        $upd = $pdo->prepare(
          "UPDATE product_sizes
           SET stock = stock - ?
           WHERE product_id=? AND size=? AND stock >= ?"
        );
        $upd->execute([
            $it['quantity'],
            $it['product_id'],
            $it['size'],
            $it['quantity']
        ]);

        if ($upd->rowCount() == 0) {
            throw new Exception('Недостаточно товара на складе');
        }
    }

    $pdo->commit();

    echo "<h2>✅ Заказ №$orderId успешно оформлен!</h2>
          <p><a href='catalog.php'>В каталог</a></p>";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Ошибка: ".$e->getMessage();
}
