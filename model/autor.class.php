<?php
$base = __DIR__ . '/..';
require_once("$base/lib/resposta.class.php");
require_once("$base/lib/database.class.php");

class Autor
{
    private $conn;       //connexió a la base de dades (PDO)
    private $resposta;   // resposta
    
    public function __CONSTRUCT()
    {
        $this->conn = Database::getInstance()->getConnection();      
        $this->resposta = new Resposta();
    }
    
    public function getAll($orderby="id_aut")
    {
		try
		{
			$result = array();                        
			$stm = $this->conn->prepare("SELECT id_aut,nom_aut,fk_nacionalitat FROM AUTORS ORDER BY $orderby");
			$stm->execute();
            $tuples=$stm->fetchAll();
            $this->resposta->setDades($tuples);    // array de tuples
			$this->resposta->setCorrecta(true);       // La resposta es correcta        
            return $this->resposta;
		}
        catch(Exception $e)
		{   // hi ha un error posam la resposta a fals i tornam missatge d'error
			$this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
		}
    }
    
    public function get($id)
    {
        try
        {
            $sql= "SELECT * from AUTORS where id_aut = $id";
            $stm=$this->conn->prepare($sql);
            $stm->execute();
            $tuple=$stm->fetch();
            $this->resposta->setDades($tuple);
            $this->resposta->setCorrecta(true);
            return $this->resposta;
        }
        catch(Exception $e)
        {
            $this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
        }
    }

    
    public function insert($data)
    {
		try 
		{
                $sql = "SELECT max(id_aut) as N from AUTORS";
                $stm=$this->conn->prepare($sql);
                $stm->execute();
                $row=$stm->fetch();
                $id_aut=$row["N"]+1;
                $nom_aut=$data['NOM_AUT'];
                $fk_nacionalitat=$data['FK_NACIONALITAT'];

                $sql = "INSERT INTO AUTORS
                            (id_aut,nom_aut,fk_nacionalitat)
                            VALUES (:id_aut,:nom_aut,:fk_nacionalitat)";
                
                $stm=$this->conn->prepare($sql);
                $stm->bindValue(':id_aut',$id_aut);
                $stm->bindValue(':nom_aut',$nom_aut);
                $stm->bindValue(':fk_nacionalitat',!empty($fk_nacionalitat)?$fk_nacionalitat:NULL,PDO::PARAM_STR);
                $stm->execute();
            
       	        $this->resposta->setCorrecta(true);
                return $this->resposta;
        }
        catch (Exception $e) 
		{
                $this->resposta->setCorrecta(false, "Error insertant: ".$e->getMessage());
                return $this->resposta;
		}
    }   
    
    public function update($data)
    {
        // TODO $query="UPDATE AUTORS SET NOM_AUT = '$nom', FK_NACIONALITAT = '$nacionalitat' where ID_AUT=$id";
        try {
            $nom_aut=$data['NOM_AUT'];
            $fk_nacionalitat=$data['FK_NACIONALITAT'];
            $id_aut=$data["ID_AUT"];
        
        
        $sql = "UPDATE AUTORS SET NOM_AUT = :nom_aut , FK_NACIONALITAT = :fk_nacionalitat where ID_AUT = :id_aut";
        $stm=$this->conn->prepare($sql);
        $stm->bindValue(':id_aut',$id_aut);
        $stm->bindValue(':nom_aut',$nom_aut);
        $stm->bindValue(':fk_nacionalitat',!empty($fk_nacionalitat)?$fk_nacionalitat:NULL,PDO::PARAM_STR);
        $stm->execute();
          $this->resposta->setCorrecta(true);
                return $this->resposta;
        }
        catch (Exeption $e)
        {
             $this->resposta->setCorrecta(false, "Error insertant: ".$e->getMessage());
                return $this->resposta;
        }
       

    }

    
    
    public function delete($id)
    {
        try {
            $sql="DELETE from AUTORS where ID_AUT=:id";
            $stm=$this->conn->prepare($sql);
            $stm->bindValue(':id',$id);
            $stm->execute();
              $this->resposta->setCorrecta(true);
                return $this->resposta;

        } catch (Exeption $e){
             $this->resposta->setCorrecta(false, "Error insertant: ".$e->getMessage());
                return $this->resposta;
        }
    }

    public function filtra($where,$orderby,$offset,$count)
    {
        try {
             $result = array();
         $sql="SELECT * WHERE nom_aut like :w orderby :orderby :offset limit :count":                        
            $stm = $this->conn->prepare($sql);
             $stm->bindValue(':w','%'$where'%');
              $stm->bindValue(':orderby',$orderby);
               $stm->bindValue(':offset',$offset);
                $stm->bindValue(':count',$count);
            $stm->execute();
            $tuples=$stm->fetchAll();
            $this->resposta->setDades($tuples); 
            $this->resposta->setCorrecta(true);           
            return $this->resposta;
        } catch (Exeption $e){
            $this->resposta->setCorrecta(false, "Error insertant: ".$e->getMessage());
                return $this->resposta;
        }
       

    }
    
          
}
