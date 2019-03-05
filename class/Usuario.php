<?php 

class Usuario {
	//atributos que compoe a classe é a mesma da tabelas
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	//metodos Gets e Setters
	public function getIdusuario(){
		return $this->idusuario;
	}

	public function setIdusuario($value){
		$this->idusuario = $value;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}

	public function setDeslogin($value){
		$this->deslogin = $value;
	}

	public function getDessenha(){
		return $this->dessenha;
	}

	public function setDessenha($value){
		$this->dessenha = $value;
	}

	public function getDtcadastro(){
		return $this->dtcadastro;
	}

	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	}


	//Essa funcao traz todas as informacoes da usuario, mas apenas daquele ID que foi passado por parametro
	public function loadById($id){
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
			':ID'=> $id
		));

		//if(isset($results()) posso fazer desse jeito ou desse jeito (abaixo)
		if(count($results) > 0){
			$row = $results[0];

			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			$this->setDtcadastro(new DateTime($row['dtcadastro']));
		}
	}

	//Essa funcao traz uma lista de todos os usuarios da tabelas 
	public static function getList(){
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");

	}


	//Essa funcao faz a busca com base no login que é digitado
	public static function search($login){
		
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
			':SEARCH'=>"%".$login."%"
		));
	}


	public function login($login, $password){
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
			':LOGIN'=> $login,
			':PASSWORD'=>$password
		));

		//if(isset($results()) posso fazer desse jeito ou desse jeito (abaixo)
		if(count($results) > 0){
			$row = $results[0];

			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			$this->setDtcadastro(new DateTime($row['dtcadastro']));
		}else{

			throw new Exception("Login e/ou senha inválidos");
			

		}
	}


	//Funcao Magica, mostras as informacoes da tabelaa ususarios, quando a classe for instanciada
	public function __toString(){
		return json_encode(array(

			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/y H:i:s")

		));
	}

}

?>