<?php 
/*	THIS CLASS CREATING A RANDOM PERSON DETAILS*/


class RandomPerson{

	public $random_name;
	public $random_surname;
	public $random_email;
	public $random_city;
	public $random_street;

//GET RANDOM CITY FROM THE LIST
function setCity() {
    $random_city = array(
        'New York',
        'Boston',
        'London',
        'Los Angeles',
        'Berlin',
        'San Francisco',
        'Paris',
        'Warsaw',
        'Gdansk',
    );

	$this->city = $random_city[rand ( 0 , count($random_city) -1)];
	return $this->city;
}
	
//GET RANDOM NAME FROM THE LIST
function setName() {
    $random_name = array(
        'Johnathon',
        'Anthony',
        'Erasmo',
        'Raleigh',
        'Nancie',
        'Tama',
        'Camellia',
        'Augustine',
        'Christeen',
        'Luz',
        'Diego',
        'Lyndia',
        'Thomas',
        'Georgianna',
        'Leigha',
        'Alejandro',
        'Marquis',
        'Joan',
        'Stephania',
        'Elroy',
        'Zonia',
        'Buffy',
        'Sharie',
        'Blythe',
        'Gaylene',
        'Elida',
        'Randy',
        'Margarete',
        'Margarett',
        'Dion',
        'Tomi',
        'Arden',
        'Clora',
        'Laine',
        'Becki',
        'Margherita',
        'Bong',
        'Jeanice',
        'Qiana',
        'Lawanda',
        'Rebecka',
        'Maribel',
        'Tami',
        'Yuri',
        'Michele',
        'Rubi',
        'Larisa',
        'Lloyd',
        'Tyisha',
        'Samatha',
    );


    $this->name = $random_name[rand ( 0 , count($random_name) -1)];
	return $this->name;
}

//GET RANDOM SURNAME FROM THE LIST	
function setSurname() {
    $random_surname = array(
        'Mischke',
        'Serna',
        'Pingree',
        'Mcnaught',
        'Pepper',
        'Schildgen',
        'Mongold',
        'Wrona',
        'Geddes',
        'Lanz',
        'Fetzer',
        'Schroeder',
        'Block',
        'Mayoral',
        'Fleishman',
        'Roberie',
        'Latson',
        'Lupo',
        'Motsinger',
        'Drews',
        'Coby',
        'Redner',
        'Culton',
        'Howe',
        'Stoval',
        'Michaud',
        'Mote',
        'Menjivar',
        'Wiers',
        'Paris',
        'Grisby',
        'Noren',
        'Damron',
        'Kazmierczak',
        'Haslett',
        'Guillemette',
        'Buresh',
        'Center',
        'Kucera',
        'Catt',
        'Badon',
        'Grumbles',
        'Antes',
        'Byron',
        'Volkman',
        'Klemp',
        'Pekar',
        'Pecora',
        'Schewe',
        'Ramage',
    );   
    $this->surname = $random_surname[rand ( 0 , count($random_surname) -1)];
	return $this->surname;
}
	
//GET RANDOM STREET FROM THE LIST
function setStreet() {
    $random_street = array(
        'Dluga',
        'Poznanska',
        'Arthur Street',
        'Airport Avenue',
        'Adelaide Avenue',
        'Andreas Avenue',
        'California Street',
        'Camp Street',
    );

    $this->street = $random_street[rand ( 0 , count($random_street) -1)];
	return $this->street;
}

function setEmail(){
	
	$this->email = $this->name."@gmail.com";
	return $this->email;
	
}


//END OF CLASS
}


?>
 