<?php
if (!empty($_GET["action"])) {
    $productId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

    switch ($_GET["action"]) {
        case "add":
            $quantity = 1; // Set the quantity to 1

            $stmt = $db->prepare("SELECT * FROM fotografet WHERE d_id = ?");
            $stmt->bind_param('i', $productId);
            $stmt->execute();
            $productDetails = $stmt->get_result()->fetch_object();

            $itemArray = array(
                $productDetails->d_id => array(
                    'title' => $productDetails->title,
                    'd_id' => $productDetails->d_id,
                    'quantity' => $quantity,
                    'price' => $productDetails->price
                )
            );

            if (!empty($_SESSION["cart_item"])) {
                if (array_key_exists($productDetails->d_id, $_SESSION["cart_item"])) {
                    $_SESSION["cart_item"][$productDetails->d_id]["quantity"] += $quantity;
                } else {
                    $_SESSION["cart_item"] = $_SESSION["cart_item"] + $itemArray;
                }
            } else {
                $_SESSION["cart_item"] = $itemArray;
            }

            break;

        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($productId == $v['d_id']) {
                        unset($_SESSION["cart_item"][$k]);
                    }
                }
            }
            break;

        case "empty":
            unset($_SESSION["cart_item"]);
            break;

        case "check":
            header("location:checkout.php");
            break;
    }
}
?>
