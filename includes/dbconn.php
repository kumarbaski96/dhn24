<?php


include 'db_constant.php';
class DBConn
{
	public $conn;
	function __construct($type)
	{
		if($type == "web")
		$this->conn = new mysqli(DBHOST,USERNAME,PASSWORD,DBNAME);
		if ($this->conn->connect_error) {
		    die("Connection failed: " . $this->conn->connect_error);
		} 
	}
	function __destruct()
	{
		if($this->conn)
		$this->conn->close();
	}
	function insertSet($table, $string)
	{
		$sql = "INSERT INTO ".$table." SET ".$string;
		
		if ($this->conn->query($sql) === TRUE)
		return $this->conn->insert_id;
		else
		return false;
	}
	function updateTable($table, $string, $cond="")
	{
		$sql = "UPDATE ".$table." SET ".$string;
		if($cond <> "")
		$sql .= " WHERE ".$cond;
		
		if ($this->conn->query($sql) === TRUE)
		return true;
		else
		return false;
	}
	function countRows($table, $cond="")
	{
		$sql = "SELECT * FROM ".$table;
		if($cond <> "")
		$sql .= " WHERE ".$cond;
		
		$res = $this->conn->query($sql);
		
		return $res->num_rows;
	}
	function fetch($table, $cond="", $order="", $ord_type="ASC", $limit="")
	{
		$sql = "SELECT * FROM ".$table;
		if($cond <> "")
		$sql .= " WHERE ".$cond;
		if($order <> "")
		$sql .= " ORDER BY ".$order." ".$ord_type;
		if($limit <> "")
		$sql .= " LIMIT ".$limit;
		
		$res = $this->conn->query($sql);
		
		if($res->num_rows > 0)
		{
			unset($resarr);
			while($arr = $res->fetch_assoc())
			$resarr[] = $arr;
			
			return $resarr;
		}
		else
		return false;
	}
	function fetchColumns($table, $columns="*", $cond="", $order="", $ord_type="ASC", $limit="")
	{
		$sql = "SELECT ".$columns." FROM ".$table;
		if($cond <> "")
		$sql .= " WHERE ".$cond;
		if($order <> "")
		$sql .= " ORDER BY ".$order." ".$ord_type;
		if($limit <> "")
		$sql .= " LIMIT ".$limit;
		$res = $this->conn->query($sql);
		
		if($res->num_rows > 0)
		{
			unset($resarr);
			while($arr = $res->fetch_assoc())
			$resarr[] = $arr;
			
			return $resarr;
		}
		else
		return false;
	}
	function fetchSingle($table, $cond="", $order="", $ord_type="ASC")
	{
		$sql = "SELECT * FROM ".$table;
		if($cond <> "")
		$sql .= " WHERE ".$cond;
		if($order <> "")
		$sql .= " ORDER BY ".$order." ".$ord_type;
		
		$sql .= " LIMIT 0,1";
		
		$res = $this->conn->query($sql);
		
		if($res->num_rows > 0)
		return $res->fetch_assoc();
		
		else
		return false;
	}
	function deleteRecord($table, $cond="")
	{
		$sql = "DELETE FROM ".$table;
		if($cond <> "")
		$sql .= " WHERE ".$cond;
		
		if ($this->conn->query($sql) === TRUE)
		return true;
		else
		return false;
	}
	function executeQuery($sql)
	{
		return $this->conn->query($sql);
	}
	function getElement($table, $col, $cond="")
	{
		$sql = "SELECT ".$col." FROM ".$table;
		if($cond != "")
		$sql .= " WHERE ".$cond;
		$val = $this->conn->query($sql)->fetch_assoc();
		return $val[$col];
	}
}
