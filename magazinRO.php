<?php
require_once "ShoppingCart.php";
session_start();

?>
<html>
<head>
    <title>Explore Romania </title>
    <style>
        .price{
            color: #524f4f;
            display: block;
        }
        .topnav {
            display: flex;
            flex-grow: 1;
            flex-basis:0;
            justify-content: center;
            align-items: center;
        }
        .topnav a {
            text-decoration: none;

            padding: 10px 16px;
            margin:0px 16px;
        }

        .topnav:hover{
            border-bottom: 1px solid #aaa;
            transform: scale(1.05);
            transition: transform 1s;
        }
        .product-image:hover{
            transform: scale(1.05);
            transition: transform 1s;
        }
        .product-image{
            width: 250px;
            height: 200px;
            margin-top: 300px auto;
            margin-left: 120px;
            display: inline-block;
            justify-content: center;
        }

        .f{
            display: block;
            font-weight: bold;
            font-family: sans-serif;
            margin:0;
            padding: 40px 0;
            font-size: 24px;
            text-align: center;
            width: 100%;
            border-bottom: 1px solid #EEEEEE;
        }

        .lang-button{
            background: rgb(214,172,255);
            border-radius: 3px;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            width: 200px;
        }
        .lang-button ul{
            list-style: none;
        }
        .lang-button ul li{

            margin: 10px;
            padding: 10px;
        }
        .sub-menu{
            display: none;
        }

        .lang-button:hover .sub-menu{
            display: block;
            background: rgb(214,172,255);

        }

        .lang-button ul li:hover .sub-menu ul{
            display: block;
            margin: 10px;
        }
        .lang-button ul li:hover .sub-menu ul li{
            width: 150px;
            padding: 10px;
            background: transparent;
        }
    </style>
</head>
<body>
<div class="topnav">
    <a class="active" href="magazin.php">Produse</a>
    <a href="Cos.php">Cos de cumparaturi</a>
    <?php
    if($_SESSION['role']==2):?>
        <a href="administrator.php">Administrator</a>
    <?php endif; ?>
    <a href="logout.php">Deconectare</a>
</div>
<div class="lang-button">
    <ul>
        <li><a href="#">Language</a></li>
        <div class="sub-menu">
            <ul>
                <li><a href="magazin.php">EN</a></li>
                <li><a href="magazinFR.php">FR</a></li>
                <li><a href="magazinRO.php">RO</a></li>
            </ul>
        </div>
    </ul>

</div>
<div>
    <div>
        <h1 class="f">Produse</h1></div>
    <br>
    <?php

    $shoppingCart = new ShoppingCart();
    $query = "SELECT * FROM products";
    $product_array = $shoppingCart->getAllProduct($query);
    if (! empty($product_array))
    {
    foreach ($product_array as $key => $value) {
    ?>
    <a href="product.php?id=<?php echo $product_array[$key]["id"];?>">

        <div class="product-image">
            <form method="post" action="Cos.php? action=add&id=<?php echo $product_array[$key]["id"]; ?>">

                <img style="width: 120px"   src="<?php echo $product_array[$key]["img"]; ?> ">
    </a>
    <div >
        <strong><?php echo $product_array[$key]["name"]; ?></strong>

        <span class="price">&dollar;<?=$product_array[$key]["price"]?>
            <?php if ($product_array[$key]["rrp"] > 0): ?>
                <span class="rrp"> <= &dollar;<?=$product_array[$key]["rrp"]?></span>
            <?php endif; ?>
<input type="text" name="quantity" value="1" size="2" />
 <input type="submit" value="Adauga in cos" />
            </form>
    </div>

</div>
<?php
}
}
?>
</div>
</body>
</html>