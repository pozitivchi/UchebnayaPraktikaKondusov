<?php
require_once 'includes/database.php';

$cart = json_decode(file_get_contents('php://input'), true);
$result = [];

if (!empty($cart['items'])) {
    foreach ($cart['items'] as $it) {
        $st = $pdo->prepare("SELECT name, price FROM products WHERE id=?");
        $st->execute([$it['product_id']]);
        if ($p = $st->fetch()) {
            $sum = $p['price'] * $it['quantity'];
            $result[] = [
                'product_id'=>$it['product_id'],
                'name'=>$p['name'],
                'price'=>$p['price'],
                'size'=>$it['size'],
                'quantity'=>$it['quantity'],
                'sum'=>$sum
            ];
        }
    }
}

echo json_encode($result);
