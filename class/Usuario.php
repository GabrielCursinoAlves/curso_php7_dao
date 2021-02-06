<?php 
	
	class Usuario{

		private $idusuario;
		private $deslogin;
		private $dessenha;
		private $dtcadastro;
		private $instancia;

		public function __construct(){

			$this->instancia = new Sql();

		}

		public function getIdusuario(){

			return $this->idusuario;

		}

		public function setIdusuario($idusuario){

			$this->idusuario = $idusuario;

		}

		public function getDeslogin(){

			return $this->deslogin;

		}

		public function setDeslogin($deslogin){

			$this->deslogin = $deslogin;

		}

		public function getDessenha(){

			return $this->dessenha;

		}

		public function setDessenha($dessenha){

			$this->dessenha = $dessenha;
		}

		public function getDtcadastro(){

			return $this->dtcadastro;

		}

		public function setDtcadastro($dtcadastro){

			$this->dtcadastro = $dtcadastro;

		}

		public function loadsets($setvalue=array()){

			foreach ($setvalue as $key => $value) {
				$this->$key($value);
			}

		}

		public function generatefields($params=array()){

			$i = 0;
			var_dump($params);
			exit;
			$campos = implode(' ', array_map(
			    function ($key) use (&$i){
			    	return $i == 0 ? $key." = ?, " : $key." ?,";
			    	$i+=1;
			    }, 
		    array_keys($params)
			));

			return substr($campos,0,-2);
		
		}

		public function loadById($id){

			$query = $this->instancia->select("SELECT *FROM tb_usuarios WHERE idusuario = 
			:idusuario",array(":idusuario"=>$id));
			
			if(count($query) > 0){

				$row = $query[0];

				$this->loadsets(array(
					"setIdusuario"=>$row['idusuario'],
					"setDeslogin"=>$row['deslogin'],
					"setDessenha"=>$row['dessenha'],
					"setDtcadastro"=>new Datetime($row['dtcadastro'])
				));

			}

		}

		public function getlist(){

			return $query = $this->instancia->select("SELECT *FROM tb_usuarios ORDER BY deslogin;");
		}

		public function search($login){

			return $query = $this->instancia->select("SELECT *FROM tb_usuarios WHERE deslogin LIKE :search
			ORDER BY deslogin;",array(":search"=>"%".$login."%"));
		}

		public function login($login,$password){

			$query = $this->instancia->select("SELECT *FROM tb_usuarios WHERE deslogin = :login and 
			dessenha = :password;",
			array(":login"=>$login,
				  ":password"=>$password)
			);
			
			if(count($query) > 0){

				$row = $query[0];

				$this->loadsets(array(
					"setIdusuario"=>$row['idusuario'],
					"setDeslogin"=>$row['deslogin'],
					"setDessenha"=>$row['dessenha'],
					"setDtcadastro"=>new Datetime($row['dtcadastro'])
				));

			}else{

				throw new Exception("Login ou Senha invalidos.",1);
				
			}

		}

		public function customize_search($params=array()){

			$search = $this->generatefields($params);	

		}

		public function __toString(){

			return json_encode(array(
				"idusuario"=>$this->getIdusuario(),
				"deslogin"=>$this->getDeslogin(),
				"dessenha"=>$this->getDessenha(),
				"dtcadastro"=>$this->getDtcadastro()->format("d-m-Y")
			));
		}
	}

?>