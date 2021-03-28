<?php
require_once 'app/Model/Customer.php';

$customer = new Customer();
$customer = $customer->get($_GET['id']);

if($customer){
    $delete_customer = new Customer();
    $delete_customer->delete($_GET['id']);
    $_SESSION['delete_success'] = 'Deleted Successfully';
    header('location: index.php?page=home');
}else {
    header("location: index.php?page=home");
}