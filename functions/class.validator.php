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
    * contain errors wchich came while processing
    *
    * @var array
    */    
	private $errors = array();

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
		'role_status' => "/^[a-z- ]+$/",
		'char_space' => "/^[a-zA-Z-' ]+$/",
		'id' => "/^[0-9]{11}$/",
		'tel'=> "/^[\+][1-9]{1}[1-9]{1} [0-9]{3}-[0-9]{3}-[0-9]{2}$/",
		'code' => "/^[0-9]{4}$/",
		'house_nr' => "/^[0-9][a-z]*/",
    'birth_date' => "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",
    'class' => "/^[1-9]{1}[a-z]$/",
    'description' => "/^[A-Za-z0-9-\.\, ]+$/"

    
    );

	/** 
	* return errors
	*/
	public function getErrors() {

    return $this->errors;

	}

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

}
?>