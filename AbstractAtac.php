<?php

abstract class AbstractAtac
{
    const AUTH_VERSION = 1;
    const PATH_VERSION = 2;
    const PRIVATE_VERSION = 4;
    const PUBLIC_VERSION = 7;

    /**
     * @param $start_address
     * @param $end_address
     * @param $options
     * @param $time
     *
     * @function percorso.Cerca(string token, string indirizzo_partenza, string indirizzo_arrivo, dict opzioni, string orario, string lang)
     *
     */
    public function pathSearch($start_address, $end_address, $options, $time){}

    /**
     * @param $id_palina
     *
     * @function paline.Previsioni(string token, int id_palina, string lingua)
     */
    public function palineForecasts($id_palina){}

    /**
     * @param $id_path
     *
     * @function paline.Fermate(string token, string id_percorso, string lingua)
     */
    public function palineStops($id_path){}

    /**
     * @param $id_path
     *
     * @function paline.Percorsi(string token, string linea, string lingua)
     */
    public function palinePaths($id_path){}

    /**
     * @param $id_route
     * @param $id_vehicle
     * @param $date_departure
     *
     * @function paline.Percorso(string token, string id_percorso, string id_veicolo, string data_partenze, string lingua)
     */
    public function palinePath($id_route, $id_vehicle, $date_departure){}

    /**
     * @param $id_palina
     *
     * @function paline.PalinaLinee(string token, int id_palina)
     */
    public function palinePalinaRoutes($id_palina){}

    /**
     * @param $id_route
     *
     * @function paline.ProssimaPartenza(string token, string id_percorso, string lingua)
     */
    public function palineNextDeparture($id_route){}

    /**
     * @param $search_query_string
     *
     * @function paline.SmartSearch(string token, string query_string)
     */
    public function palineSmartSearch($search_query_string){}

    /**
     * @param $id_vehicle
     * @param $id_route
     *
     * @function paline.Veicolo(string token, int id_veicolo, string id_percorso, string lingua)
     */
    public function palineVehicle($id_vehicle, $id_route){}

    /**
     * @function ztl.Lista(string token)
     */
    public function ztlList(){}

    /**
     * @param $changes
     * @param $date
     *
     * @function ztl.Orari(string token, boolean modifiche_straordinarie, string data)
     */
    public function ztlTimetables($changes, $date){}

}