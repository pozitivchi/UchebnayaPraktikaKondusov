<?php
require_once 'includes/config.php';
require_once 'includes/database.php';

// только для авторизованных
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// корзина из сессии
if (empty($_SESSION['cart'])) {
    die('Корзина пуста');
}

$error = '';

// оформление заказа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address  = trim($_POST['address'] ?? '');
    $delivery = $_POST['delivery'] ?? '';
    $payment  = $_POST['payment'] ?? '';

    if ($address === '' || $delivery === '' || $payment === '') {
        $error = 'Заполните все поля';
    } else {
        try {
            $pdo->beginTransaction();

            // подсчёт общей суммы корзины
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $stp = $pdo->prepare("SELECT price FROM products WHERE id = ?");
                $stp->execute([$item['product_id']]);
                $price = $stp->fetchColumn();
                if ($price === false) {
                    throw new Exception("Товар с ID {$item['product_id']} не найден");
                }
                $total += $price * $item['quantity'];
            }

            // создаём заказ (имена полей соответствуют таблице)
            $st = $pdo->prepare(
                "INSERT INTO orders (user_id, status, delivery_address, delivery_method, payment_method, total, order_date)
                 VALUES (?, 'Новый', ?, ?, ?, ?, NOW())"
            );
            $st->execute([$_SESSION['user']['id'], $address, $delivery, $payment, $total]);
            $orderId = $pdo->lastInsertId();

            // проверяем и списываем склад, добавляем позиции
            foreach ($_SESSION['cart'] as $item) {
                $pid  = $item['product_id'];
                $size = $item['size'];
                $qty  = $item['quantity'];

                // блокируем строку для избежания гонок
                $st = $pdo->prepare(
                    "SELECT stock FROM product_sizes 
                     WHERE product_id = ? AND size = ? FOR UPDATE"
                );
                $st->execute([$pid, $size]);
                $row = $st->fetch(PDO::FETCH_ASSOC);

                if (!$row || $row['stock'] < $qty) {
                    throw new Exception("Недостаточно товара (ID=$pid, размер $size)");
                }

                // цена товара (уже есть в переменной $price, но можно запросить ещё раз для каждой позиции)
                $stp = $pdo->prepare("SELECT price FROM products WHERE id = ?");
                $stp->execute([$pid]);
                $price = $stp->fetchColumn();

                // добавляем позицию заказа
                $pdo->prepare(
                    "INSERT INTO order_items (order_id, product_id, size, quantity, price)
                     VALUES (?, ?, ?, ?, ?)"
                )->execute([$orderId, $pid, $size, $qty, $price]);

                // списываем склад
                $pdo->prepare(
                    "UPDATE product_sizes 
                     SET stock = stock - ? 
                     WHERE product_id = ? AND size = ?"
                )->execute([$qty, $pid, $size]);
            }

            $pdo->commit();

            // очищаем корзину
            $_SESSION['cart'] = [];

            header('Location: orders.php?success=1');
            exit;

        } catch (Exception $e) {
            $pdo->rollBack();
            $error = 'Ошибка оформления: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Оформление заказа</title>
</head>
<body>

<h2>Оформление заказа</h2>

<?php if ($error): ?>
<p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
<label>Адрес доставки:</label><br>
<textarea name="address" required></textarea><br><br>

<label>Способ доставки:</label><br>
<select name="delivery" required>
  <option value="">Выберите</option>
  <option value="Курьер">Курьер</option>
  <option value="Самовывоз">Самовывоз</option>
</select><br><br>

<label>Способ оплаты:</label><br>
<select name="payment" required>
  <option value="">Выберите</option>
  <option value="Карта">Карта</option>
  <option value="Наличные">Наличные</option>
</select><br><br>

<button>Подтвердить заказ</button>
</form>

</body>
</html>