<?php 


require_once("config.php");
/*
//Realiza uma busca na tabela
$sql = new Sql();
$usuarios = $sql->select("SELECT * FROM tb_usuarios");
echo json_encode($usuarios) ;
*/


/*
//carrega um usuário
$root = new Usuario();
$root->loadById(3);
echo $root;
*/

/*
//carrega uma lista de usuário
$lista = Usuario::getList();
echo json_encode($lista);
*/


/*
//carrega uma lista de ussuários buscando pelo login
$search = Usuario::search("jo");
echo json_encode($search);
*/

/*
//carrega um usuário usando o login e a senha
$usuario = new Usuario();
$usuario->login("root","!@#$");
echo $usuario;
*/

/*
//Criando um novo usuario
$aluno = new Usuario("aluno", "@alun0");
$aluno->setDeslogin("aluno");
$aluno->setDessenha("@lun0");
$aluno->insert();
echo $aluno;
*/


$usuario = new Usuario();
$usuario->loadById(8);
$usuario->update("professor", "!@#$%*");
echo $usuario;



?>