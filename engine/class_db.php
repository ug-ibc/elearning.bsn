<?php 

/* Class Name = Database
 * Variabel Input : query, result, connect, numRec
 * Variabel Input Type : Protected
 * Created By : Ovan Cop
 * Class Desc : Kumpulan fungsi database (db helper)
 */

class Database
{
	protected $var_query = null;
	protected $var_result = null;
	protected $var_connect = null;
	protected $var_numRec = null;
	protected $config = array();
	protected $dbConfig = array();
	protected $keyconfig = null;
	var $link = false;
	
	public function __construct() {
		
		/* nothing here */
	}
	
	function setAppKey()
	{
		global $CONFIG;
		if (array_key_exists('default',$CONFIG)) $keyconfig = 'default';
		if (array_key_exists('admin',$CONFIG)) $keyconfig = 'admin';
		if (array_key_exists('dashboard',$CONFIG)) $keyconfig = 'dashboard';
		if (array_key_exists('services',$CONFIG))$keyconfig = 'services';
		
		return $keyconfig;
	}
	
	function setDbConfig()
	{
		global $dbConfig;
		
	}
	
	public function open_connection($dbuse) {
		
		global $dbConfig, $CONFIG;
		
		$this->keyconfig = $this->setAppKey();
		
		if ((is_array($dbConfig)) and ($dbConfig !=''))
		{
			
			if ($dbConfig[$dbuse]['server'] !=''){
				$db_status = 1;
			}else{
				$this->db_error('Server not defined');
				exit;
			}
			
			switch ($dbConfig[$dbuse]['server'])
			{
				case 'mysql':
				{
					
					if ($CONFIG[$this->keyconfig]['app_status'] == 'Production'){
						$connect = @mysql_connect(trim($dbConfig[$dbuse]['host']), $dbConfig[$dbuse]['user'], $dbConfig[$dbuse]['pass']) or die ($this->db_error('Connection error'));
					
					}else{
						$connect = @mysql_connect(trim($dbConfig[$dbuse]['host']), $dbConfig[$dbuse]['user'], $dbConfig[$dbuse]['pass']) or die ($this->db_error('Connection error'));
						
					}
					
					
					if ($connect){
					
						if ($CONFIG[$this->keyconfig]['app_status'] == 'Production'){
							@mysql_select_db(trim($dbConfig[$dbuse]['name']), $connect) or die ($this->db_error('No Database Selected'));	
						
						}else{
							mysql_select_db(trim($dbConfig[$dbuse]['name']),$connect) or die ($this->db_error('No Database Selected'));
							
							// mysql_select_db('florakalbar', $connect) or die ($this->db_error('No Database Selected'));
							
						}
						
						$this->link = $connect;
						return $connect;
					
					}else{
					
						return false;
					}
				}
				break;
				
				default :
				{
					$this->db_error('Database not configure, please check database server configure');
				}
				break;
			}
		}
	}
	
        
	/*
		fungsi query digunakan untuk menjalankan query seperti insert, 
		update atau query yang tidak diperlukan nilai kembalian dalam bentuk data
	 */
	public function query($data, $dbuse=0)
	{
		global $dbConfig, $CONFIG;
		$this->keyconfig = $this->setAppKey();
		
		$this->open_connection($dbuse);
                // cek server database yang dipakai
		switch ($dbConfig[$dbuse]['server'])
		{
			case 'mysql':
				if ($CONFIG[$this->keyconfig]['app_status'] == 'Production'){
						// if ($this->dbConfig[''])
						$this->var_query = @mysql_query($data);

				}else{
						$this->var_query = mysql_query($data) or die ($this->error($data,$dbuse));
				}
				break;
			
		}
		// $this->close_connection();
		
		return $this->var_query;
	}
	

	
	public function fetch($data=false, $loop=false, $dbuse=0)
	{
		/* $dbuse [0] = config default database */
		// pr($dbuse);
		global $dbConfig, $CONFIG;
		
		if (!$data) return false;
		
		$dataArray = array();
		$this->keyconfig = $this->setAppKey();
		
		switch ($dbConfig[$dbuse]['server'])
		{
			case 'mysql':
				$this->open_connection($dbuse);
				$this->var_result = $this->query($data,$dbuse) or die ($this->error($data,$dbuse));
				if ($loop){
					if ($this->num_rows($data,$dbuse)){

						while ($data = mysql_fetch_assoc($this->var_result)){
								$dataArray[] = $data;
						}
						
						return $dataArray;
					}else{
						return false;
					}
				}else{
					
					$dataArray = mysql_fetch_assoc($this->var_result);
					
					return $dataArray;
				}
				$this->close_connection();
			break;
                    
		}
		
		
		
	}
        
        /* fungsi yang digunakan untuk execute query pada oracle secara otomatis akan di commit
         * jika fungsi ini dijalankan maka data yang di input tidak akan bisa di rollback kembali
         * ini sudah ketentuan dari API oracle-nya 
         */
	
	
	public function fetch_field($data)
	{
		$this->var_result = $data;
		
		return mysql_fetch_field($this->var_result);
	}
	
	public function num_rows($data=false,$dbuse)
	{
		if (!$data) return false;
		$result = $this->query($data,$dbuse) or die ($this->error($data));
		$numRec = mysql_num_rows($result);
		return $result;
	}
	
	public function insert_id()
	{
		$res['lastID'] = 0;
		$sql = "SELECT LAST_INSERT_ID() AS lastID";
		$res = $this->fetch($sql);
		
		if ($res['lastID']>0)return $res['lastID'];
		return false;
	}
	
	public function close_connection()
	{
		
		global $dbConfig;
		$this->keyconfig = $this->setAppKey();
		
		switch ($dbConfig[0]['server'])
		{
			case 'mysql':
				return mysql_close($this->link);
				break;
		   
		}
		
	}
	
	public function free_result($result)
	{
		return mysql_free_result($result);
	}
	
	public function real_escape_string($data)
	{
		return mysql_real_escape_string($data);
	}
	
	public function error($data,$dbuse)
	{
		
		global $dbConfig, $CONFIG;
		$this->keyconfig = $this->setAppKey();
		
		if ($CONFIG[$this->keyconfig]['app_status'] == 'Production'){
			$message = 'Your query error, please check again';
			return $message;
		}else{
			
			switch ($dbConfig[$dbuse]['server'])
			{
				case 'mysql':
					return mysql_error($this->link);
					break;
				
			}
			
		}
		
	}
	
	function db_error($mesg)
	{
		
		if ($mesg !='') {
			$mesg = $mesg;
			
		}else{
			$mesg = "Message error not defined";
		}
		
		print ($mesg);
		return false;
		
	}
	
	function autocommit($val=0,$dbuse=0)
	{
		$command = "SET autocommit={$val};";
		$result = $this->query($command) or die ($this->error('autocommit failed'));
		// if (!$this->link){
			// $this->link = $this->open_connection(0);
		// }
		
		// return mysql_autocommit($this->link, false);
		
	}
	
	function commit($dbuse=0)
	{
		$command = "COMMIT;";
		$result = $this->query($command) or die ($this->error('commit failed'));
		// mysql_commit();
	}
	
	function rollback($dbuse=0)
	{
		$command = "ROLLBACK;";
		$result = $this->query($command) or die ($this->error('rollback failed'));
		// if (!$this->link){
			// $this->link = $this->open_connection(0);
		// }
		
		// pr($this->link);
		// mysql_rollback($this->link);
		
	}
	
	function begin($dbuse=0)
	{
		
		$this->autocommit();
		$command = "START TRANSACTION;";
		$result = $this->query($command) or die ($this->error('commit failed'));
		// if (!$this->link){
			// $this->link = $this->open_connection(0);
			
		// }
		// mysql_
		// $res = mysql_begin_transaction($this->link);
		if ($result) return true;
		return false;
	}

	function lazyQuery($data=array(), $debug=false, $method=0)
	{


		/*
		How to use lazyQuery !!!

		$sql1 = array(
                'table'=>'satker AS s, aset AS a, log_aset l',
                'field'=>'s.Satker_ID, s.KodeSektor, a.Aset_ID, l.last_aset_id',
                'condition'=>'s.Satker_ID IN(1,2)',
                'limit' => 5,
                'joinmethod' => 'LEFT JOIN',
                'join' => 's.Satker_ID = a.Aset_ID, a.Aset_ID = l.Aset_ID' 
                );
		*/

		$table = $data['table'];
		$field = $data['field'];

		switch ($method) {
			case '0':
				
				$condition = $data['condition'];
				$limit = intval(@$data['limit']);
				if ($limit>0) $limit = " LIMIT {$limit}";
				else $limit = "";
				$where = "";
				if ($condition) $whereCondition = " {$condition} ";
				else $whereCondition = " 1 ";

				if (isset($data['join'])){

					$jointmp = $data['join'];
					$join = explode(',', $jointmp);

					if (isset($data['joinmethod'])) $joinmethod = $data['joinmethod'];
					if ($joinmethod){
						$tmpTable = explode(',', $table);
						$length = count($tmpTable);

						$joinIndex = 0;
						for ($i=1; $i<$length; $i++){
							$tatement[] = $joinmethod . $tmpTable[$i] . ' ON ' . $join[$joinIndex];
							$joinIndex++;
						}

						$tmpStatement = implode(' ',$tatement);

						$primaryTable = $tmpTable[0];

						$sql = "SELECT {$field} FROM {$primaryTable} {$tmpStatement} WHERE {$whereCondition} {$limit}";
					}

				}else{
					$sql = "SELECT {$field} FROM {$table} WHERE {$whereCondition} {$limit}";
				} 
				
				

				
				if ($debug){
					if ($debug>1){
						pr($sql);
					}else{
						pr($sql);
						exit;	
					} 
					
				}
				if (!$debug) $res = $this->fetch($sql,1);
				if ($res) return $res;

			break;
			
			case '1':
				/*
				$sql = array(
                'table'=>'aset',
                'field'=>'Aset_ID, KodeSetkor',
                'value'=>'111,1010',
                );
				*/
				$value = $data['value'];

				$sql = "INSERT INTO {$table} ({$field}) VALUES ({$value})";
				if ($debug){
					if ($debug>1){
						pr($sql);
					}else{
						pr($sql);
						exit;	
					} 
					
				}
				if (!$debug) $res = $this->query($sql);
				if ($res) return true;

			break;

			case '2':
				/*		

				$sql = array(
                'table'=>'aset',
                'field'=>'Aset_ID = 1, KodeSatker = 1010',
                'condition'=>'Status_Validasi_Barang = 1',
                );
				*/
				$condition = $data['condition'];

				if (isset($data['limit'])) $limit = intval($data['limit']);
				else $limit = " ";
				
				if ($limit>0) $limit = " LIMIT {$limit}";
				else $limit = "";

				$sql = "UPDATE {$table} SET {$field} WHERE {$condition} {$limit}";
				if ($debug){
					if ($debug>1){
						pr($sql);
					}else{
						pr($sql);
						exit;	
					} 
					
				}
				if (!$debug)$res = $this->query($sql);
				if ($res) return true;

			break;


			default:
				pr('Method no defined');
				exit;
				break;
		}

		
		return false;
	}
}


?>