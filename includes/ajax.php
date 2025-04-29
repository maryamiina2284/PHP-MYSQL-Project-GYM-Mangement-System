<?php 

include 'functions.php';
if(isset($_POST['action']) and $_POST['action']=='forUpdate'){
    $result = read_where($_POST['table']," id=".$_POST['id']);
    echo json_encode($result[0]);
}


if(isset($_POST['action']) and $_POST['action']=='forPayment'){
    $result = read_where("chargesveiw"," member_id=".$_POST['memberid']." and status = 'Unpaid'");
    echo json_encode($result);
}