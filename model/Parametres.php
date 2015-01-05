<?php

class Parametres{

	public function setQuestion($attribut,$value){
		$_SESSION['question'][$attribut]=value;
	}

	public function setGoodAnswer($attribut,$value){
                $_SESSION['goodAnswer'][$attribut]=value;
        }

	public function getParametresQuestion($attribut){
		return $_SESSION['question'][$attribut];
	}

	public function getParametresGoodAnswer($attribut){
                return $_SESSION['goodAnswer'][$attribut];
        }

	public function getParametresWrongAnswer{
                return $_SESSION['wrongAnswer'][$attribut];
        }

}


?>
