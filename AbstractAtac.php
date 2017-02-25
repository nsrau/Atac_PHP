<?php

abstract class AbstractAtac
{
    const AUTH_VERSION = 1;
    const PATH_VERSION = 2;
    const PRIVATE_VERSION = 4;
    const PUBLIC_VERSION = 7;

    /**
     * @function percorso.Cerca(string token, string indirizzo_partenza, string indirizzo_arrivo, dict opzioni, string orario, string lang)
     */
    public function pathSearch(){}

    /**
     * @function paline.Previsioni(string token, int id_palina, string lingua)
     */
    public function palineForecasts(){}

    /**
     * @function paline.Fermate(string token, string id_percorso, string lingua)
     */
    public function palineStops(){}

    /**
     * @function paline.Percorsi(string token, string linea, string lingua)
     */
    public function palinePaths(){}

    /**
     * @function paline.Percorso(string token, string id_percorso, string id_veicolo, string data_partenze, string lingua)
     */
    public function palinePath(){}

    /**
     * @function paline.PalinaLinee(string token, int id_palina)
     */
    public function palinePalinaRoutes(){}

    /**
     * @function paline.ProssimaPartenza(string token, string id_percorso, string lingua)
     */
    public function palineNextDeparture(){}

    /**
     * @function paline.SmartSearch(string token, string query_string)
     */
    public function palineSmartSearch(){}

    /**
     * @function paline.Veicolo(string token, int id_veicolo, string id_percorso, string lingua)
     */
    public function palineVehicle(){}

    /**
     * @function ztl.Lista(string token)
     */
    public function ztlList(){}

    /**
     * @function ztl.Orari(string token, boolean modifiche_straordinarie, string data)
     */
    public function ztlTimetables(){}

}