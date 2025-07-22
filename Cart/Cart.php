<?php
namespace cart;
use PDO;
use select\Select;

require_once '../utility_class/Select.php';
class Cart
{

    function addToCart($pdo, $user_id, $product_id, $quantity)
    {
        $query = $pdo->prepare('SELECT * FROM cart_items WHERE product_id=:product_id AND user_id=:user_id');
        $query->execute([':product_id' => $product_id, ':user_id' => $user_id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $query = $pdo->prepare('UPDATE cart_items SET quantity=:quantity WHERE product_id=:product_id AND user_id=:user_id');
            $query->execute([':quantity' => $quantity, ':product_id' => $product_id, ':user_id' => $user_id]);
        } else {
            $query = $pdo->prepare('INSERT INTO cart_items(user_id,product_id,quantity) VALUES(:user_id,:product_id,:quantity)');
            $query->execute([':user_id' => $user_id, ':product_id' => $product_id, ':quantity' => $quantity]);
        }
    }

    function removeFromCart($pdo, $user_id, $product_id)
    {
        $query = $pdo->prepare('DELETE FROM cart_items where user_id=:user_id AND product_id=:product_id');
        $query->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    }

    function showCart($pdo)
    {
        $select = new Select();
        $user = $select->fetch($pdo, 'user', 'email', $_SESSION['email']);
        $carts = $select->fetchAll($pdo, 'cart_items', 'user_id', $user['ID']);
        foreach ($carts as $cart) {
            $products = $select->fetchAll($pdo, 'product', 'ID', $cart['product_id']);
            return $products;
        }

    }

    function showProducts($pdo)
    {
        $products = $this->showCart($pdo);
        foreach ($products as $product) {
            return $product;
        }
    }
}