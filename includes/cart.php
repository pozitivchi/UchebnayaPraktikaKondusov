<?php
require_once __DIR__ . '/database.php';

/**
 * Получить или создать корзину пользователя
 */
function getCartId($user_id){
    global $pdo;

    $st = $pdo->prepare("SELECT id FROM carts WHERE user_id=?");
    $st->execute([$user_id]);
    $id = $st->fetchColumn();

    if(!$id){
        $pdo->prepare("INSERT INTO carts(user_id) VALUES(?)")
            ->execute([$user_id]);
        return $pdo->lastInsertId();
    }
    return $id;
}

/**
 * Слияние локальной корзины с корзиной в БД
 */
function mergeCart($user_id, $localCart){
    global $pdo;

    if(empty($localCart['items'])) return;

    $cartId = getCartId($user_id);

    foreach($localCart['items'] as $item){
        $pid = $item['product_id'];
        $qty = $item['quantity'];

        $st = $pdo->prepare(
            "SELECT id, quantity FROM cart_items 
             WHERE cart_id=? AND product_id=?"
        );
        $st->execute([$cartId, $pid]);

        if($row = $st->fetch()){
            $pdo->prepare(
                "UPDATE cart_items SET quantity=? WHERE id=?"
            )->execute([
                $row['quantity'] + $qty,
                $row['id']
            ]);
        } else {
            $pdo->prepare(
                "INSERT INTO cart_items(cart_id, product_id, quantity)
                 VALUES(?,?,?)"
            )->execute([$cartId, $pid, $qty]);
        }
    }
}
