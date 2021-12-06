<html>
<head>
    <title>Explore Romania</title>
</head>
<body>
<center><img src="placedorder.png" style="width:300" margin-top:200></center>
<?php require_once "ShoppingCart.php";
session_start();
?>

<?php
$shoppingCart = new ShoppingCart();
$member_id=$_SESSION['id'];
$cartItem = $shoppingCart->getMemberCartId($member_id);
if (! empty($cartItem)) {
    $total = 0;
    foreach ($cartItem as $item =>$value){
        $shoppingCart->addToPlacedOrders($value['product_id'], $value['id'], $value['quantity'], $member_id);
    }
}
$shoppingCart->emptyCart($member_id)
;?>
<a href="magazin.php"><left><img src="back.png" width="100" style="margin-left="200""></left></a>
</body>
</div>
</html>