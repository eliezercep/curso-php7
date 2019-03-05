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
			
			$this->setData($results[0]);
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

	//Funcao que realiza o login, passando por parametros Login e Senha
	public function login($login, $password){
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
			':LOGIN'=> $login,
			':PASSWORD'=>$password
		));

		//if(isset($results()) posso fazer desse jeito ou desse jeito (abaixo)
		if(count($results) > 0){

			$this->setData($results[0]);

		}else{

			throw new Exception("Login e/ou senha inválidos");
		
		}
	}

	public function setData($data){
		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));	
	}

	//funcao que realiza a insercao de dados na tabeas tb_usuarios usando funcao do mysql
	public function insert(){
		
		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :SENHA)", array(

			':LOGIN'=>$this->getDeslogin(),
			':SENHA'=>$this->getDessenha()	
		));

		if(count($results) > 0){
			$this->setData($results[0]);
		}

	}

	//funcao que realiza a atualizacao das informacoes
	public function update($login, $password){
		
		$this->setDeslogin($login);
		$this->setDessenha($password);

		$sql = new Sql();

		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha(),
			':ID'=>$this->getIdusuario()
		));
	}

	//funcao que realiza o DELETE da informacao na tabela
	public function delete(){
		$sql = new Sql();

		$sql->query("DELETE FROm tb_usuarios WHERE idusuario = :ID", array(

			':ID'=>$this->getIdusuario()

		));

		$this->setIdusuario(0);
		$this->setDeslogin("");
		$this->setDessenha("");
		$this->setDtcadastro(new DateTime());


	}


	//funcao, metodo Construtor, que passa por parametro o login e senha do usuario (tabela tb_usuario)
	public function __construct($login = "", $password =""){
		$this->setDeslogin($login);
		$this->setDessenha($password);
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