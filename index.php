<?php 
	
	require_once "config.php";

	// Retorna somente 1 usário
	/*$Usuario = new Usuario();
	$Usuario->loadById(4);
	echo $Usuario;*/

	// Carrega uma lista usuários
	/*$Lista = new Usuario();
	$list = $Lista->getlist();

	echo json_encode($list);*/

	// Carrega uma lista de usuários buscando pelo login
	//$Buscar = new Usuario();
	//$search = $Buscar->search("roo");
	//echo json_encode($search);

	// Carrega um usuário com login e senha altentivado
	//$Usuario = new Usuario();
	//$Usuario->login("root2","!#res2");
	//echo $Usuario;

	// Criando um novo usuário
	//$aluno = new Usuario("gabriel_cursino","12#7889");
	//$aluno->insert();
	//echo $aluno;

	// Alterar usuário
	/*$Usuario = new Usuario();
	$Usuario->update(4,'pelezinho22','omelhordomundo22');
	echo $Usuario;*/

	// Deletar usuário
	$Usuario = new Usuario();
	$Usuario->loadById(10);
	$Usuario->delete();
	echo $Usuario;


?>