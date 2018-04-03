<?php

require_once "library/IXR_library.php";
require_once "AbstractAtac.php";

namespace atac;

class Atac extends AbstractAtac
{
    protected $_service_url = null;
    protected $_client = null;
    protected $_user = null;
    protected $_lang = "it";
    protected $_key = null;
    protected $_url = "http://muovi.roma.it/ws/xml/";

    const AUTH_LOGIN = "autenticazione.Accedi";
    const AUTH = "autenticazione";

    const QUERY_TEST = '337';

    const DEBUG = false;

    /**
     * Atac constructor.
     * @param array $params user && key || lang
     */
    public function __construct($params = array())
    {
        if (is_array($params) && !empty($params)) {
            if (isset($params['user']) && !empty($params['user'])) {
                $this->setUser($params['user']);
            } else {
                $msg = 'isset user in params';
                $this->_error(__FILE__, __LINE__, $msg);

                return false;
            }
            if (isset($params['key']) && !empty($params['key'])) {
                $this->setKey($params['key']);
            } else {
                $msg = 'isset key in params';
                $this->_error(__FILE__, __LINE__, $msg);

                return false;
            }

            if (isset($params['lang']) && !empty($params['lang'])) {
                $this->setLang($params['lang']);
            }

            if(!$this->checkToken()) {
                $this->createToken();
            }

        } else {
            $msg = 'define params: user="MY_USER", key="MY_KEY"';
            $this->_error(__FILE__, __LINE__, $msg);

            return false;
        }

        return true;
    }

    /**
     * @param $file
     * @param int $line
     * @param string $msg
     * @return bool|null
     */
    public function _error($file, $line = 0, $msg = '')
    {
        if($this::DEBUG) {
            echo sprintf('FILE: ' . $file . ' <br> error_line: %s <br> msg: %s', $line, $msg . "<br>");
            return null;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getServiceUrl()
    {
        return $this->_service_url;
    }

    /**
     * @param $service_url
     */
    protected function setClient($service_url)
    {
        $this->_client = new IXR_Client($service_url);
    }

    /**
     * @return IXR_Client|bool
     */
    protected function getClient()
    {
        if ($this->_client) {
            return $this->_client;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param string $user
     */
    protected function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @return string
     */
    protected function getUser()
    {
        return $this->_user;
    }

    /**
     * @param string $key
     */
    protected function setKey($key)
    {
        $this->_key = $key;
    }

    /**
     * @return string
     */
    protected function getKey()
    {
        return $this->_key;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->_lang = $lang;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->_lang;
    }

    /**
     * @return string
     */
    public function getUrlAuth()
    {
        return $this->_url . $this::AUTH . '/' . $this::AUTH_VERSION;
    }

    /**
     * @param $token
     */
    protected function setToken($token)
    {
        session_start();
        $_SESSION['token'] = $token;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        session_start();
        return $_SESSION['token'];
    }

    /**
     * @return bool
     */
    public function getAuth()
    {
        if ($this->getClient()) {
            return $this->getClient()->query($this::AUTH_LOGIN, $this->getKey(), $this->getUser());
        }

        return false;
    }

    /**
     * @param string $function_name
     * @return bool
     */
    public function getFunctionExist($function_name = '')
    {
        return is_callable(array($this, $function_name)) ? true : false;
    }

    /**
     * create and set token
     * @return bool
     */
    protected function createToken()
    {
        session_start();
        unset($_SESSION['token']);

        $url_auth = $this->getUrlAuth();
        $this->setClient($url_auth);

        $client = $this->getClient();

        if (!$this->getAuth()) {
            $msg = sprintf("Error authentication - %s : %s", $client->getErrorCode(), $client->getErrorMessage());
            $this->_error(__FILE__, __LINE__, $msg);

            return false;
        }

        $this->setToken($this->getResponse());

        return true;
    }

    /**
     * @return mixed|bool
     */
    protected function getResponse()
    {
        if ($this->getClient()) {
            return $this->getClient()->getResponse();
        }

        $msg = "An error occurred with get response";
        $this->_error(__FILE__, __LINE__, $msg);

        return false;
    }

    /**
     * @return bool
     */
    protected function checkToken()
    {
        $token = $this->getToken();

        if(!isset($token) || empty($token)) {
            $this->createToken();
        }

        $token = $this->getToken();

        $query_test = $this->query('paline.SmartSearch', $token, $this::QUERY_TEST);
        if(!$query_test) return false;

        return true;
    }

    /**
     * @return bool|mixed
     */
    protected function query()
    {
        $args = func_get_args();
        $method = $args[0];

        $query_service = explode('.', $method);
        if ($query_service[0] === 'paline') {
            $version = $this::PUBLIC_VERSION;
        } else if ($query_service[0] === 'percorso') {
            $version = $this::PATH_VERSION;
        } else {
            $version = $this::PRIVATE_VERSION;
        }
        $service_url = $this->getUrl() . $query_service[0] . '/' . $version;

        $this->setClient($service_url);

        $client = $this->getClient();
        $query = call_user_func_array(array($client, 'query'), $args);

        if (!$query) {
            $msg = sprintf("An error occurred - %s : %s", $client->getErrorCode(), $client->getErrorMessage());
            $this->_error(__FILE__, __LINE__, $msg);

            return false;
        }

        return $this->getResponse();
    }

    /**
     * @param $start_address
     * @param $end_address
     * @param $options
     * @param $time
     * @return bool|mixed
     */
    public function pathSearch($start_address, $end_address, $options, $time)
    {
        return $this->query('percorso.Cerca', $this->getToken(), $start_address, $end_address, $options, $time, $this->getLang());
    }

    /**
     * @param $id_palina
     * @return bool|mixed
     */
    public function palineForecasts($id_palina)
    {
        return $this->query('paline.Previsioni', $this->getToken(), $id_palina, $this->getLang());
    }

    /**
     * @param $id_path
     * @return bool|mixed
     */
    public function palineStops($id_path)
    {
        return $this->query('paline.Fermate', $this->getToken(), $id_path, $this->getLang());
    }

    /**
     * @param $id_path
     * @return bool|mixed
     */
    public function palinePaths($id_path)
    {
        return $this->query('paline.Percorsi', $this->getToken(), $id_path, $this->getLang());
    }

    /**
     * @param $id_route
     * @param $id_vehicle
     * @param $date_departure
     * @return bool|mixed
     */
    public function palinePath($id_route, $id_vehicle, $date_departure)
    {
        return $this->query('paline.Percorso', $this->getToken(), $id_route, $id_vehicle, $date_departure, $this->getLang());
    }

    /**
     * @param int $id_palina
     * @return bool|mixed
     */
    public function palinePalinaRoutes($id_palina)
    {
        return $this->query('paline.PalinaLinee', $this->getToken(), $id_palina, $this->getLang());
    }

    /**
     * @param $id_route
     * @return bool|mixed
     */
    public function palineNextDeparture($id_route)
    {
        return $this->query('paline.ProssimaPartenza', $this->getToken(), $id_route, $this->getLang());
    }

    /**
     * @param $search_query_string
     * @return bool|mixed
     */
    public function palineSmartSearch($search_query_string)
    {
        return $this->query('paline.SmartSearch', $this->getToken(), $search_query_string);
    }

    /**
     * @param $id_vehicle
     * @param $id_route
     * @return bool|mixed
     */
    public function palineVehicle($id_vehicle, $id_route)
    {
        return $this->query('paline.Veicolo', $this->getToken(), $id_vehicle, $id_route, $this->getLang());
    }

    /**
     * @return bool|mixed
     */
    public function ztlList()
    {
        return $this->query('ztl.Lista', $this->getToken());
    }

    /**
     * @param $changes
     * @param $date
     * @return bool|mixed
     */
    public function ztlTimetables($changes, $date)
    {
        return $this->query('ztl.Orari', $this->getToken(), $changes, $date);
    }

}
