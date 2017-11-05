<?php
 
require __DIR__ . '/db_connection.php';
 
class CRUD_json
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }
 
    /*
     * Add new Record
     *
     * @param $first_name
     * @param $last_name
     * @param $email
     * @return $mixed
     * */
    public function Create($code, $text)
    {
       
		$query = $this->db->prepare("INSERT INTO json( code, text) VALUES (:code,:text)");
      //  $query->bindParam("first_name", $first_name, PDO::PARAM_STR);
        $query->bindParam("code", $code, PDO::PARAM_STR);
        $query->bindParam("text", $text, PDO::PARAM_STR);
        $query->execute();
	
        return $this->db->lastInsertId();
    }
	
	
	   public function InsertAnswer($session, $token, $code, $text)
    {
       
		$query = $this->db->prepare("INSERT INTO answers(session, token, code, text) VALUES (:session, :token, :code,:text)");
      //  $query->bindParam("first_name", $first_name, PDO::PARAM_STR);
        $query->bindParam("code", $code, PDO::PARAM_STR);
        $query->bindParam("text", $text, PDO::PARAM_STR);
		$query->bindParam("session", $session, PDO::PARAM_STR);
		$query->bindParam("token", $token, PDO::PARAM_STR);
        $query->execute();
	
        return $this->db->lastInsertId();
    }
	
	
	    public function UploadFile($name, $size, $type, $content )
    {
       
		$query = $this->db->prepare("INSERT INTO upload( name, size, type, content) VALUES (:name, :size, :type, :content)");
      //  $query->bindParam("first_name", $first_name, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("size", $size, PDO::PARAM_STR);
		$query->bindParam("type", $type, PDO::PARAM_STR);
        $query->bindParam("content", $content, PDO::PARAM_STR);
        $query->execute();
	
        return $this->db->lastInsertId();
    }
	
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
    public function Read()
    {
        $query = $this->db->prepare("SELECT * FROM users");
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	    public function getText($code)
    {
        $query = $this->db->prepare("SELECT 'json' AS ORIGIN, text FROM json WHERE code= :code1 UNION (SELECT 'meta' AS ORIGIN, text FROM json WHERE code in (SELECT json_code FROM meta_json WHERE metacode =:code2))");
        $query->bindParam("code1", $code, PDO::PARAM_STR);
		$query->bindParam("code2", $code, PDO::PARAM_STR);
		$query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	
		    public function getRedirect()
    {
        $query = $this->db->prepare("SELECT  text FROM redirect");
       // $query->bindParam("code1", $code, PDO::PARAM_STR);
		//$query->bindParam("code2", $code, PDO::PARAM_STR);
		$query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
		    public function getAnswers($code)
    {
        $query = $this->db->prepare("SELECT id, session, token, text, timestamp FROM answers WHERE upper (code)= upper(:code) order by id desc");
		
		//$query = $this->db->prepare("SELECT 'json' AS ORIGIN, text FROM json WHERE code= :code1 UNION (SELECT 'meta' AS ORIGIN, text FROM json WHERE code in (SELECT json_code FROM meta_json WHERE metacode =:code2))");
		
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
			    public function getAnswersByToken($code, $token)
    {
        $query = $this->db->prepare("SELECT id, session, token, text, timestamp FROM answers WHERE upper(code)= upper(:code) AND upper(token)=upper(:token) order by id desc");
		
		//$query = $this->db->prepare("SELECT 'json' AS ORIGIN, text FROM json WHERE code= :code1 UNION (SELECT 'meta' AS ORIGIN, text FROM json WHERE code in (SELECT json_code FROM meta_json WHERE metacode =:code2))");
		$query->bindParam("token", $token, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	
		    public function getJSONbyClass($class)
    {
        

		$query = $this->db->prepare("SELECT ID as id, CODE as code, TITLE as title, AUTHOR as author FROM v_klasse_json WHERE klasse = :class");
		//echo 'SELECT * FROM v_klasse_json WHERE klasse=' .$klasse ;
		
        $query->bindParam("class", $class, PDO::PARAM_STR);
		$query->execute();
        $data = array();
		
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
 
    /*
     * Delete Record
     *
     * @param $user_id
     * */
    public function Delete($user_id)
    {
        $query = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Update Record
     *
     * @param $first_name
     * @param $last_name
     * @param $email
     * @return $mixed
     * */
	 
	 public function Check($code)
    {
        $query = $this->db->prepare("SELECT * FROM json WHERE lower(code) = lower(:code)");
        $query->bindParam("code", $code, PDO::PARAM_STR);
       // $query->bindParam("text", $text, PDO::PARAM_STR);
		//$query->bindParam("id", $code, PDO::PARAM_STR);
        $query->execute();
		return $query->rowCount();
    }
	 
	 
    public function Update($code, $title, $text)
    {
        $query = $this->db->prepare("UPDATE json SET text = :text, title = :title, last_update= CURRENT_TIMESTAMP()  WHERE code = :code");
        $query->bindParam("code", $code, PDO::PARAM_STR);
        $query->bindParam("text", $text, PDO::PARAM_STR);
		$query->bindParam("title", $title, PDO::PARAM_STR);
		//$query->bindParam("id", $code, PDO::PARAM_STR);
        if ($query->execute()) {
			return $code;
		}
		else 
		{return 'error';}
		
    }
 
    /*
     * Get Details
     *
     * @param $user_id
     * */
    public function Details($id)
    {
        $query = $this->db->prepare("SELECT * FROM k1 WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
}
 
?>