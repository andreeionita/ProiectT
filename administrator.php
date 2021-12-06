<?php
session_start();
require_once "ShoppingCart.php";
require_once "DBController.php";
?>
<html>
<head>
<title>Explore Romania</title>
<link href="style.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
 if( $_SESSION['role'] == 2) {
?>
<div class="topnav">
  <a href="magazin.php">Products</a>
  <a href="Cos.php">Shopping Cart</a>
  <a class="active" href="administrator.php">Administrator</a>
  <a href="logout.php">Log out</a>
</div>
<div id="product-grid">
 <div><h1>Products</h1></div>
 <?php
$shoppingCart = new ShoppingCart();
 $query = "SELECT * FROM products";
 $product_array = $shoppingCart->getAllProduct($query);
 if (! empty($product_array)) {
 foreach ($product_array as $key => $value) {
 ?>
 <div class="product-item">
 <form method="post" action="adminfunction.php?action=updateproduct&id=<?php echo $product_array[$key]["id"]; ?>">
 <div class="product-image">
 <img style="width: 100px" src="<?php echo $product_array[$key]["img"]; ?>">
 </div>
 <div>
 <input type="text" name = "name" value="<?php echo $product_array[$key]["name"]; ?>">
 </div>
 <div>
 <input type="text" name = "price" value="<?php echo $product_array[$key]["price"]; ?>">
 </div>
 <div>
 <input type="submit" value="Save">
 </div>
 </form>
 <form method="post" action="adminfunction.php?action=deleteproduct&id=<?php echo $product_array[$key]["id"]; ?>">
 <input type="submit" value="Delete">
 </form>
 </div>
 <?php
 }
 }
 ?>
 <form method="post" action="adminfunction.php?action=insertproduct">
 <div>
 Product Name: <input type="text" required name="name" >
 </div>
 <div>
 Description: <input type="text" name="desc">
 </div>
 <div>
 Price: <input type="text" required name="price">
 </div>
 <div>
 Retail Price: <input type="text" required name="rrp">
 </div>
 <div>
 Quantity: <input type="text" required name="quantity">
 </div>
 <div>
 Img name: <input type="text" required name="img">
 </div>
 <input type="submit" value="Insert">
 </form>
</div>
<div id="product-grid">
 <div><h1>Users</h1></div>
<?php
	$dbController = new DBController();
	$sql = "SELECT * FROM users";
	$users = $dbController->getDBResult($sql);
	//echo var_dump($users);
	if(!empty($users)){
		foreach($users as $key => $value){
?>
<div class="product-item">
 <form method="post" action="adminfunction.php?action=delete&id=<?php echo $users[$key]["id"]; ?>">
 <div>
 <input type="text" name = "username" value="<?php echo $users[$key]["username"]; ?>">
 </div>
 <div>
 <input type="text" name = "email" value="<?php echo $users[$key]["email"]; ?>">
 </div>
 <div>
 <input type="text" name="role" value="<?php echo $users[$key]["role"]; ?>">
 </div>
 <div>
 <input type="submit" value="Save"><br>
 </div>
 </form>
 <form method="post" action="adminfunction.php?action=delete&id=<?php echo $users[$key]["id"]; ?>">
 <input type="submit" value="Delete">
 </form>
 </div>
<?php
}
?>
<?php
 }
 
?>
 </div>
 

<?php
 
 }
?>
</body>
</html>