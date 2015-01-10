<?php
class Parametres{
	public function __construct()
	{	
		$param=[$paramQuest, $paramRep];
		$paramQuest=['font-family' => '', 'font-size' => '', 'color' => ''];
		$paramRep=['font-family' => '', 'font-size' => '', 'color1' => '', 'color2' => ''];
	}
	
	public function setParamQuestion($v1,$v2,$v3){
		$param[$paramQuest]['font-family']=$v1;
		$param[$paramQuest]['font-size']=$v2;
		$param[$paramQuest]['color']=$v3;		
	}
	
	public function setParamReponse($v1,$v2,$v3,$v4){
		$param[$paramRep]['font-family']=$v1;
		$param[$paramRep]['font-size']=$v2;
		$param[$paramRep]['color1']=$v3;		
		$param[$paramRep]['color2']=$v4;		
	}
	
	public function getParamQuestion($attribut){
		//test		
		$param[$paramQuest]['font-family']='Times';
		$param[$paramQuest]['font-size']=44;
		$param[$paramQuest]['color']='blue';
		return $param[$paramQuest];
	}
	
	public function getParamReponse($attribut){
		//test
		$param[$paramRep]['font-family']='Raleway';
		$param[$paramRep]['font-size']=22;
		$param[$paramRep]['color1']='green';		
		$param[$paramRep]['color2']='red';
        return $param[$paramRep];
    }
}
?>