<?php

/**
* Validator class      
* 
* @author Bartlomiej Witkowski
* 
*
*/

class Validator{

  /** 
    *   
    * types of regex
    *
    * @var array   
    */
    private $regex = array(
		'school_year' => "/^[2]{1}[0]{1}[0-9]{2}\/[2]{1}[0]{1}[0-9]{2}$/",
		'lesson_time' => "/^[0-1]{1}[0-9]{1}\.[0-6]{2}-[0-1]{1}[0-9]{1}\.[0-6]{2}$/",
		'marks_cat' => "/^[a-z- ]+$/",
		'role_status' => "/^[a-z- ]+$/"
    
    );


  /** 
    *   
    * This function removes whitespaces, dangerous chars etc..
    * @param input 
    */
    private function inputTrim($input){
        
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
        return $input;
    }   
    
  /** 
    *   
    * Check if input is ok
    *
    * @public function
    * @param input - input which be validated
    * @param - type of regex
    * @return true if validation ok    
    */

    public function isValid($input, $type) {

        $regex = $this->regex[$type];

        if ($this->validate ($input, $regex) !== false )
            return true;

    }


    private function validate ($input, $regex) {
        
        $input = $this->inputTrim ($input);

        if (!preg_match ($regex, $input) )
            
            return false;
       
    }


	
/**
*    
* Checks name validation
*
* @private function
* @param $name - ..
* 
*/
private function checkName($name){
		$name = $this->inputTrim($name);
		
		if (!preg_match("/^[a-zA-Z]+$/", $name)) 		
			$this->errors[] = "Name contains wrong characters<br>";
		else
			$this->name = $name;
	}
/**
*    
* Checks surname validation
*
* @private function
* @param $surname - ..
* 
*/	
private function checkSurname($surname){
		$surname = $this->inputTrim($surname);		
			
			if (!preg_match("/^[a-zA-Z-']+$/", $surname)) 	
				$this->errors[] = "Surname contains wrong characters<br>";
			else
				$this->surname = $surname;
			
	}
/**
*    
* Checks ID validation
*
* @private function
* @param $id - ..
* 
*/	
private function checkId($id){
		$id = $this->inputTrim($id);
		
		if (!preg_match("/^[0-9]{6}$/", $id)) 		
			$this->errors[] = "ID is not valid<br>";
		else
			$this->id = $id;
	
	}
/**
*    
* Checks ID supervisor validation
*
* @private function
* @param $id_supervisor - ..
* 
*/	
private function checkIdSpr($id_supervisor){
		$id_supervisor = $this->inputTrim($id_supervisor);
		
		if (!preg_match("/^[0-9]{6}$/", $id_supervisor)) 		
			$this->errors[] = "ID is not valid<br>";
		else
			$this->id_supervisor = $id_supervisor;
	
	}
/**
*    
* Checks telephone validation
*
* @private function
* @param $tel - ..
* 
*/	
private function checkTel($tel){
		$tel = $this->inputTrim($tel);
		
		if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{2}$/", $tel)) 		
			$this->errors[] = "Telephone number is not valid<br>";
		else
			$this->tel = $tel;
	}
/**
*    
* Checks email validation
*
* @private function
* @param $email - ..
* 
*/	
private function checkEmail($email){
		$email = $this->inputTrim($email);
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			$this->errors[] = "E-mail address is not valid<br>";	
		else
			$this->email = $email;
	}
/**
*    
* Checks city validation
*
* @private function
* @param $city - ..
* 
*/	
private function checkCity($city){
		$city = $this->inputTrim($city);
		
		if (!preg_match("/^[a-zA-Z-' ]+$/", $city)) 	
			$this->errors[] = "City contains wrong characters<br>";
		else
			$this->city = $city;
	}
/**
*    
* Checks post code validation
*
* @private function
* @param $code - ..
* 
*/	
private function checkCode($code){
		$code = $this->inputTrim($code);
		
		if (!preg_match("/^[0-9]{4}$/", $code)) 		
			$this->errors[] = "Wrong city code<br>";
		else
			$this->code = $code;
	}
/**
*    
* Checks street validation
*
* @private function
* @param $street - ..
* 
*/	
private function checkStreet($street){
		$street = $this->inputTrim($street);
		
		if (!preg_match("/^[a-zA-Z-' ]+$/", $street)) 	
			$this->errors[] = "Street contains wrong characters<br>";
		else
			$this->street = $street;
	}
/**
*    
* Checks house nr validation
*
* @private function
* @param $hosuenr - ..
* 
*/	
private function checkHouseNr($housenr){
		$housenr = $this->inputTrim($housenr);
		
		
		if (($housenr==0) || (strlen($housenr)>3) || (!preg_match("/^[0-9]/", $housenr) ))			
				$this->errors[] = "Wrong house nr<br>";
			else
				$this->housenr = $housenr;
    }
  
    
}
?>