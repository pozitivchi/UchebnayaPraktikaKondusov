<?php
require_once 'config.php';

function requireAuth() {
    if (!isset($_SESSION['user'])) {
        header('Location: /shoestore/login.php');
        exit;
    }
}

function requireRole(array $roles) {
    requireAuth();
    if (!in_array($_SESSION['user']['role'], $roles)) {
        die('Нет доступа');
    }
}
