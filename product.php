<?php
session_start();
require_once "ShoppingCart.php";
require_once "DBController.php";
$shoppingCart = new ShoppingCart();
 $query = "SELECT * FROM products WHERE id=".$_GET["id"]."";
 $product_array = $shoppingCart->getProduct($query);
 if (! empty($product_array)):
 foreach ($product_array as $key => $value):
 ?>
<link href="style.css" type="text/css" rel="stylesheet" />
<body>
<div class="topnav">
  <a href="magazin.php">Products</a>
  <a href="Cos.php">Shopping Cart</a>
  <a href="administrator.php">Administrator</a>
  <a href="logout.php">Log out</a>
</div>
<form method="post" action="cos.php?action=add&id=<?php echo $product_array[$key]["id"]; ?>">
<div class="product content-wrapper">
    <img src="<?=$product_array[$key]["img"]?>" width="500" height="500" alt="<?=$product_array[$key]["name"]?>">
    <div>
        <h1 class="name"><?=$product_array[$key]["name"]?></h1>
		<span class="price">
            &dollar;<?php echo $product_array[$key]["price"];?>
            <?php if ($product_array[$key]["rrp"] > 0): ?>
            <span class="rrp"> <= &dollar;<?=$product_array[$key]["rrp"]?></span>
            <?php endif; ?>
        </span>
        
        <div class="description">
            <?php echo $product_array[$key]["descr"];?>
        </div>
    </div>
</div>
<?php
endforeach;
endif;
?>