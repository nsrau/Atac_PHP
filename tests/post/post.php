<?php

include "../../Atac.php";

$atac = new Atac();

$action = $_POST['action'];
$query = $_POST['query'];

if(isset($action) && $atac->getFunctionExist($action)) {

    if($atac->$action($query)) {
        header('Content-type: application/json');
        echo json_encode($atac->$action($query));
    }

    return false;
}

else
    $atac->_error(__FILE__, __LINE__, 'this function => ' . $action . ', not exist');
