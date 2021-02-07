<?php 
	
	class Usuario{

		private $idusuario;
		private $deslogin;
		private $dessenha;
		private $dtcadastro;
		private $instancia;

		public function __construct($login="",$password=""){

			$this->instancia = new Sql();

			$this->setDeslogin($login);
			$this->setDessenha($password);

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

			foreach ($setvalue as $key => $value){
				$this->$key($value);
			}

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

			return $query = $this->instancia->select("SELECT *FROM tb_usuarios WHERE deslogin 
			LIKE :search ORDER BY deslogin;",array(":search"=>"%".$login."%"));
		}

		public function login($login,$password){

			$query = $this->instancia->select("SELECT *FROM tb_usuarios WHERE deslogin = :login and 
			dessenha = :password;",array(":login"=>$login,":password"=>$password));
			
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

		public function insert(){

			$query = $this->instancia->select("CALL sp_usuarios_insert(:login,:password);",array(
				":login"=>$this->getDeslogin(),
				":password"=>$this->getDessenha()
			));

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

		public function update($id,$login,$password){

			$this->loadsets(array(
				"setIdusuario"=>$id,
				"setDeslogin"=>$login,
				"setDessenha"=>$password
			));

			$query = $this->instancia->select("CALL sp_usuarios_update(:id,:login,:password);",array(
				":id"=>$this->getIdusuario(),
				":login"=>$this->getDeslogin(),
				":password"=>$this->getDessenha()
			));

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

		public function delete(){

			$query = $this->instancia->query("DELETE FROM tb_usuarios WHERE idusuario = :idusuario;",
			array(":idusuario"=>$this->getIdusuario()));

			$this->setIdusuario(0);
			$this->setDeslogin("");
			$this->setDessenha("");
			$this->setDtcadastro(new Datetime());

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