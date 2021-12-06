<?php
// Testam GitHub - Razvan
require_once "DBController.php";
$dbcontroller = new DBController();
switch($_GET['action']) {
	case 'updateproduct':
		$sql = "UPDATE products SET name = ?, price = ? WHERE id=".$_GET['id']."";
		$inputs = array(['param_type' => 's', 'param_value'=>$_POST['name']],['param_type' => 's', 'param_value'=> $_POST['price']]);
		$dbcontroller->updateDB($sql, $inputs);
		header('location: administrator.php');
		break;
	case 'insertproduct':
	    $sql="INSERT INTO products(name, descr, price, rrp, quantity, img) VALUES('".$_POST['name']."', '".$_POST['desc']."', ".$_POST['price'].", ".$_POST['rrp'].", ".$_POST['quantity'].", '".$_POST['img']."')";
		$inputs = array(
		['param_type' => 's', 'param_value'=>$_POST['name']],
		['param_type' => 's', 'param_value'=>$_POST['desc']], 
		['param_type' => 'i', 'param_value'=>$_POST['price']], 
		['param_type' => 'i', 'param_value'=>$_POST['rrp']],
		['param_type' => 'i', 'param_value'=>$_POST['quantity']], 
		['param_type' => 's', 'param_value'=>$_POST['img']]);
        $dbcontroller -> updateDB($sql);
		header('location: administrator.php');
		break;
	case 'deleteproduct':
	    $sql="DELETE FROM products WHERE id=".$_GET['id']."";
		$inputs = array(['param_type' => 'i', 'param_value'=>$_POST['id']]);
		$dbcontroller ->updateDB($sql, $inputs);
		header('location: administrator.php');
		break;
    case 'update' :
	    $sql = "UPDATE users SET username = ?, email = ?, role=? WHERE id=".$_GET['id']."";
		$inputs = array(['param_type' => 's', 'param_value'=>$_POST['username']],['param_type' => 's', 'param_value'=> $_POST['email']],['param_type' => 'i', 'param_value'=> $_POST['role']]);
		$dbcontroller->updateDB($sql, $inputs);
		header('location: administrator.php');
		break;
	case 'delete':
	    $sql="DELETE FROM users WHERE id=".$_GET['id']."";
		$inputs = array(['param_type' => 'i', 'param_value'=>$_POST['id']]);
		$dbcontroller ->updateDB($sql, $inputs);
		header('location: administrator.php');
		break;
}
?>