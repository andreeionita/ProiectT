<?php
require_once "ShoppingCart.php";
session_start();
// Dacă utilizatorul nu este conectat redirecționează la pagina de autentificare ...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
// pt membrii inregistrati
$member_id=$_SESSION['id'];
$shoppingCart = new ShoppingCart();
if (! empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            $productResult = $shoppingCart->getProductByCode($_GET["id"]);
            $cartResult = $shoppingCart->getCartItemByProduct($productResult[0]["id"], $member_id);
            if ( empty($_POST["quantity"])) {
                // Modificare cantitate in cos
                $newQuantity = $cartResult[0]["quantity"] + $_POST["quantity"];
                $shoppingCart->updateCartQuantity($newQuantity, $cartResult[0]["id"]);
            } else {
                // Adaugare in tabelul cos
                $shoppingCart->addToCart($productResult[0]["id"], $_POST["quantity"], $member_id);
            }

            break;
        case "remove":
            // Sterg o sg inregistrare
            $shoppingCart->deleteCartItem($_GET["id"]);
            break;
        case "empty":
            // Sterg cosul
            $shoppingCart->emptyCart($member_id);
            break;
        case "update":
            $shoppingCart->updateCartQuantity($_POST["quantity"], $_GET["id"]);
    }

}
?>
<html>
<head>
    <title>Explore Romania</title>
    <link href="style.css" type="text/css" rel="stylesheet" />
    <style>
        .lang-button{
            background: rgb(214,172,255);
            border-radius: 3px;
            text-align: center;
            padding: 0;
            margin: 0;
            list-style: none;
            box-sizing: border-box;

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
<div class="topnav">
    <a href="magazin.php">Products</a>
    <a class="active" href="Cos.php">Shopping Cart</a>
    <?php
    if($_SESSION['role']==2):?>
        <a href="administrator.php">Administrator</a>
    <?php endif; ?>
    <a href="logout.php">Log out</a>
</div>
<div class="lang-button">
    <ul>
        <li><a href="#">Language</a></li>
        <div class="sub-menu">
            <ul>
                <li><a href="Cos.php">EN</a></li>
                <li><a href="CosFR.php">FR</a></li>
                <li><a href="CosRO.php">RO</a></li>
            </ul>
        </div>
    </ul>

</div>
<body>
<div id="shopping-cart">
    <div class="txt-heading">
        <div><h1>Shopping Cart</h1></div> <a id="btnEmpty" href="cos.php?action=empty"><img src="empty-cart.png" alt="empty-cart" title="Empty Cart" /></a>
    </div>
    <?php
    $cartItem = $shoppingCart->getMemberCartItem($member_id);
    if (! empty($cartItem)) {
    $item_total = 0;
    ?>
    <table cellpadding="10" cellspacing="1">
        <tbody>
        <tr>
            <th style="text-align: left;"><strong>Name</strong></th>
            <th style="text-align: left;"><strong>Code</strong></th>
            <th style="text-align: right;"><strong>Quantity</strong></th>
            <th style="text-align: right;"><strong>Price</strong></th>
            <th style="text-align: center;"><strong>Action</strong></th>

        </tr>
        <?php
        foreach ($cartItem as $item) {
            ?>
            <tr>
                <form method="post" action="cos.php?action=update&id=<?php echo $item["cart_id"]; ?>">
                    <td style="text-align: left; border-bottom: #F0F0F0 1px solid;"><strong><?php echo $item["name"] ; echo " postcard" ; ?></strong></td>
                    <td style="text-align: left; border-bottom: #F0F0F0 1px solid;"><?php echo $item["id"];?></td>
                    <td style="text-align: right; border-bottom: #F0F0F0 1px solid;"><input type="number" name="quantity" value=<?php echo $item["quantity"] ;?> min=1></td>
                    <td style="text-align: right; border-bottom: #F0F0F0 1px solid;"><?php echo "$".$item["rrp"]; ?></td>
                    <td style="text-align: center; border-bottom: #F0F0F0 1px solid;">
                        <a href="cos.php?action=remove&id=<?php echo $item["cart_id"]; ?>" class="btnRemoveAction">
                            <img src="icon-delete.png" alt="icon-delete" title="Remove Item" />
                        </a>
                    </td>
                    <td style="text-align: center; border-bottom: #F0F0F0 1px solid;">

                    </td>
                    <td style="text-align: left; border-bottom: #F0F0F0 1px solid;">
                        <input class="button" type="submit" value="Update">
                    </td>
                </form>
            </tr>
            <?php
            $item_total += ($item["price"] * $item["quantity"]);
        }
        ?>
        <tr>
            <td colspan="3" align=right><strong>Total</strong></td>
            <td align=right><?php echo "$".$item_total; ?></td>
            <td></td>
        </tr>
        </tbody>
    </table>
    <?php if (isset($_SESSION['loggedin'])): ?>
    <form method="post" action="placeorder.php">
        <?php else: ?>
        <form method="post" action="autentificare.php">
            <?php endif?>
            <input type="submit" value="Place Order">
        </form>
        <?php
        }
        ?>
        <div style="margin-top:100px; margin-left:150px">
            Please write the address of your special person who will receive the postcard. Also,
            you could write a small message too. :)

            <form action="https://formspree.io/f/mbjwrqzb" method="post">
                <label for="email">Write to your loved ones </label><br>
                <input name="Email" id="email" type="email" placeholder="lovedone@adress.com"><br>
                <textarea name="Message" placeholder="Short message"></textarea><br>
                <button type="submit">Submit</button>
            </form>
        </div>
</div>
</body>
</html>