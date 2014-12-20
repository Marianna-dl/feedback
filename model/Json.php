<?php

class Json
{
	private $_data;

	public function __construct($data=null)
	{
		if(gettype($data)=='array')
			$this->_data = $data;
		else if($data!=null)
			$this->_data = json_decode($data, true);
		else
			$this->_data = array();
		// verifier si type correct
		//$this->http_response(404);
	}

	///	##############
	///	Getter
	/// ##############
	public function get($key)
	{	
		if($this->keyExist($key)==true)
			return $this->_data[$key];
		die('erreur');
		//TODO LEVER ERREUR HTTP
	}

	///	##############
	///	Add et Updates
	/// ##############
	public function add($key, $value)
	{	if($this->keyExist($key)==false)	$this->_data[$key] = $value;
		else	echo '<h1>ERREUR : Json->add($key, $value)</h1>';
	}
	public function update($key, $value)
	{	if($this->keyExist($key)==true)	$this->_data[$key] = $value;
		else	echo '<h1>ERREUR : Json->update($key, $value)</h1>';
	}
	public function addOrUpdate($key, $value)
	{	if( gettype($value)!='object' )
			$this->_data[$key] = $value;	
		else if (get_class($value)=='Json')
			$this->_data[$key] = $value->asArray();
	}

	//TODO REMOVE

	///	##############
	///	Utilitaire
	/// ##############
	public function asArray()
	{	return $this->_data;	}

	public function Stringify()
	{	return json_encode($this->_data);	}

	public function http_response()
	{	echo json_encode($this->_data);	}

	public function keyExist($key)
	{	foreach ($this->_data as $k => $v) 
			if($key==$k) return true;
		return false;
	}
}
?>