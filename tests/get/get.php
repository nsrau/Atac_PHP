<?php

use atac\Atac;

include_once '../../Atac.php';

$data = $_GET;
$action = $data['action'];

$params = array(
    'user' => 'MY_USER',
    'key' => 'MY_KEY'
);

$atac = new Atac($params);

switch ($action) {

    case 'pathSearch':
        echo json_encode($atac->pathSearch($data['start_address'], $data['end_address'], $data['options'], $data['time']));
        break;
    case 'palineForecasts':
        $result = $atac->palineForecasts($data['id_palina']);
        echo json_encode($result);
        break;
    case 'palineStops':
        echo json_encode($atac->palineStops($data['id_path']));
        break;
    case 'palineSmartSearch':
        $results = $atac->palineSmartSearch($data['search_query_string']);
        echo json_encode($results);
        break;
    case 'palinePath':
        echo json_encode($atac->palinePath($data['id_route'], $data['id_vehicle'], $data['date_departure']));
        break;
    case 'palinePalinaRoutes':
        echo json_encode($atac->palinePalinaRoutes($data['id_palina']));
        break;
    case 'palineNextDeparture':
        echo json_encode($atac->palineNextDeparture($data['id_route']));
        break;
    case 'palinePaths':
        $results = $atac->palinePaths($data['id_palina']);
        echo json_encode($results);
        break;
    case 'palineVehicle':
        echo json_encode($atac->palineVehicle($data['id_vehicle'], $data['id_route']));
        break;
    case 'ztlList':
        echo json_encode($atac->ztlList());
        break;
    case 'ztlTimetables':
        echo json_encode($atac->ztlTimetables($data['changes'], $data['date']));
        break;
    default:
        $atac->_error(__FILE__, __LINE__, 'this function => ' . $action . ', not exist');
        break;

}