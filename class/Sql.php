<?php 
	
	class Sql extends PDO{

		private $coon;

		public function __construct(){

			$this->coon = new PDO("mysql:host=localhost;dbname=dbphp7","root","");
		}

		private function setParams($statment,$parameters=array()){

			foreach ($parameters as $key => $value){

				$this->setParam($statment,$key,$value);

			}

		}

		public function setParam($statment,$key,$value){

			$statment->bindParam($key,$value);

		}

		public function query($rowQuery,$params=array()){

			$stmt = $this->coon->prepare($rowQuery);
			$this->setParams($stmt,$params);

			$stmt->execute();

			return $stmt;

		}

		public function select($rowQuery,$params=array()):array{

			$stmt = $this->query($rowQuery,$params);

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
			
		}
	}

?>