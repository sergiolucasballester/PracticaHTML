<?php

require_once __DIR__ . '/../interfaces/IToJson.php'; 

class User implements IToJson{
    private $name;
    private $surname;
    private $password;
    private $phone;
    private $email;
    private $sex;
    
    public function __construct($name, $surname, $password, $phone, $email, $sex)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
        $this->phone = $phone;
        $this->email = $email;
        $this->sex = $sex;
    }

    public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getSurname(){
		return $this->surname;
	}

	public function setSurname($surname){
		$this->surname = $surname;
	}

	public function getPassword(){
		return $this->password;
	}

	public function setPassword($password){
		$this->password = $password;
	}

	public function getPhone(){
		return $this->phone;
	}

	public function setPhone($phone){
		$this->phone = $phone;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getSex(){
		return $this->sex;
	}

	public function setSex($sex){
		$this->sex = $sex;
	}

    public function toJSON() {
        return json_encode([
            'name' => $this->getName(),
            'surname' => $this->getSurname(),
            'password' => $this->getPassword(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'sex' => $this->getSex(),
        ]);
    }
}

?>