<?php

class OapApi
{
	protected $format = 'json';
	protected $appName = null;
	protected $key = null;
	protected $cache = array();
	public $debug = false;
	protected $reqType = 'fetch';
	public $response = '';


	protected $base_url = "http://api.moon-ray.com/cdata.php";//not https is not secure.

	/**
	 * constructor
	 * Builds a new instance of this class, stores an authenticator api key
	 * @param string $apiKey get an api key from your wistia account
	 * @return boolean read or not
	 */
	public function __construct($appName = null, $key = null)
	{
		if($appName){
			$this->cache = array();
			$this->appName = $appName;
			$this->key = $key;
		}
	}

	public function findByEmail($email = null) {

$data = <<<STRING
<search><equation>
	<field>E-Mail</field>
	<op>e</op>
	<value>{$email}</value>
	</equation>
</search>
STRING;

		$data = '&data='.urlencode(urlencode($data));

		$request = array('return_id' => 1, 'reqType' => 'search');

		return $this->sendRequest($request, $data); //$this->cache['contact'];


	}

	protected function sendRequest($params=null, $data=null)
	{

		//Set our aparams if we have them
		if($params){
			$url ='&'.http_build_query($params);
		}

		$main_url = "appid=".$this->appName."&key=".$this->key.$url.$data;

		if($this->debug){
			echo 'Sending Request: '.$main_url;
		}

		$result = $this->__send($main_url, $params);

		if($this->debug){
			echo '<br />Received: <pre>';
			print_r($result);
			echo '</pre>';
		}

		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($result);

		$error = new err();
		if (!$xml && $result != '<result></result>') {

			//foreach(libxml_get_errors() as $error) {
				$error->error = 'There is an error in API keys or in the autopilot APIs.'; //$error->message;
			//}
			libxml_clear_errors();
		}

		if(!$xml && $result != '<result></result>')
			return $error;
		else
			return $xml;

	}

	protected function __send($url)
	{

		$session = curl_init($this->base_url);
		curl_setopt ($session, CURLOPT_POST, true);
		curl_setopt ($session, CURLOPT_POSTFIELDS, $url);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($session);
		curl_close($session);

		$this->response = $response;
		return $response;
	}
	public function enableDebugging()
	{
		$this->debug = true;
	}
}
class OapException extends Exception{

}

class err {

	public $error = '';

}