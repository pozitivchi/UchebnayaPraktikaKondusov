<?php
require_once __DIR__.'/database.php';

function logEvent($type, $message, $userId = null) {
    global $pdo;
    $st = $pdo->prepare(
      "INSERT INTO logs(user_id,type,message) VALUES(?,?,?)"
    );
    $st->execute([$userId, $type, $message]);
}
