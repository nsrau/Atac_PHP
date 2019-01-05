# PHP Atac API
PHP library for Muoversi Roma Real time API

<h2>Example</h2>
<h4>GET method</h4>

``` php
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
```

<h4>POST method</h4>

``` php
<?php

use atac\Atac;

include "../../Atac.php";

$action = $_POST['action'];
$query = $_POST['query'];

$params = array(
    'user' => 'MY_USER',
    'key' => 'MY_KEY'
);

$atac = new Atac($params);

if(isset($action) && $atac->getFunctionExist($action)) {

    if($atac->$action($query)) {
        header('Content-type: application/json');
        echo json_encode($atac->$action($query));
    }

}
else {
    $atac->_error(__FILE__, __LINE__, 'this function => ' . $action . ', not exist');
}
```

## Documentation local
see documentation [readme_api](https://raw.githubusercontent.com/nsrau/Atac_PHP/master/readme/readme_api) <br>
see documentation private functions [private](https://github.com/nsrau/Atac_PHP/tree/master/readme/private) <br>
see documentation public functions [public](https://github.com/nsrau/Atac_PHP/tree/master/readme/public)
## Documentation online
see online documentation [romamobilita](https://romamobilita.it/it/azienda/open-data/api-real-time)
## List id_paline
list in [html](tests/get/id_paline/id_paline_20_02_17.html)
<br>
list in [xml](tests/get/id_paline/id_paline_20_02_17.xml)
## List id_percorsi
list in [html](tests/get/id_percorsi/id_percorsi_18_02_17.html)
<br>
list in [xml](tests/get/id_percorsi/id_percorsi_18_02_17.xml)
<br>
list in [json](tests/get/id_percorsi/id_percorsi_18_02_17.json)
