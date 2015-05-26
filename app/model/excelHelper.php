<?php

/*
Note : 
	- add new field short_namecode for some table for identified record
	- Dont forget to fill personID, taxonID, etc (Foreign Key) in excel sheet references
	- rename field using to det_using, date to det_date in det table, because the fieldname is sql keywords

Scenario :
	- Upload excel file
	- Parse all data in all sheet
	- Store to array variable
	- Clean data in array variable if record is null
	- Check config field specimen in cpec.lib.php before get the data
	- Store in new Array again
	- Split master table and reference table in different array variable
	- Parse references field if exist
	- Generate query 
	- Set priority table (insert priority) in all array variable
	- Open transaction
	- Excecute references insert query
	- Excecute Master insert query
	- Commit if success else rollback
*/


class excelHelper extends Database {

	
	var $configkey = "default";
	var $log;
	var $locale;

	function __construct()
	{
		global $LOCALE;
		$this->log = $GLOBALS['CODEKIR']['LOGS'];
		// $this->log->logActivity('upload','load excel success');
		$this->locale = $LOCALE;
	}

	function loadexcel($file=false)
	{
		error_reporting(E_ALL ^ E_NOTICE);
		
		global $CONFIG, $EXCEL;
		if (!$file) return false;
		
		if (!in_array($_FILES[$file]['type'], $EXCEL[0]['filetype'])) return false;
		
		if (array_key_exists('admin', $CONFIG)){
			$this->configkey = 'admin';
		}
		if (array_key_exists('dashboard', $CONFIG)){
			$this->configkey = 'dashboard';
		}
		
		$excel = "";
		$filename = ($_FILES[$file]['tmp_name']);
		$excelEngine = LIBS . 'excel/excel_reader' . $CONFIG[$this->configkey]['php_ext'];
		if (is_file($excelEngine)){
			
			require_once ($excelEngine);
			
			$excel = new Spreadsheet_Excel_Reader($filename);

			logFile('load excel success');
		}else{
			logFile('excel lib not found');
		}
		
		return $excel;
	}
	
	function fetchExcel($formName, $sheet=1,$startRow=1,$startCol=0)
	{
		global $EXCEL;
		
			$data = array();
			$newData = array();
			
			$numberOfSheet = $sheet;
			$startRowData = $startRow;
			$startColData = $startCol;
			
			// parameternya adalah name dari input type file
			$excel = $this->loadexcel($formName);
			
			if ($excel){
			
				for ($i=0; $i<$numberOfSheet; $i++){
					
					$data[$i]['sheet'] = $i;
					
					// get field name in current sheet
					$countColl = $excel->colcount($sheet_index=$i);
					$countRow = $excel->rowcount($sheet_index=$i);
					if ($countColl>0){
						for ($a=$startRowData; $a<=$countColl; $a++){
							$data[$i]['field_name'][] = $excel->val($startRowData, ($a), $i);
						}
					}
					
					$fieldName = "";
					if ($countRow>0){
						// looping baris
						for ($a=$startRowData; $a<=$countRow; $a++){
							
							// looping kolom
							
							for ($b=$startRowData; $b<=$countColl; $b++){
								
								$fieldName = $excel->val($startRowData, ($b), $i);
								
								$data[$i]['data'][$a][] = $excel->val($a+1, ($b), $i);
								// $data[$i]['data'][$a][0][$fieldName] = $excel->val($a+1, ($b), $i);
								
							}
							
						}
					}
					
				}
			}else{
				echo json_encode(array('status'=>false, 'msg'=>"Error ! File not allowed"));
				exit;
			}
			
			logFile('parse data excel success, data= '. serialize($data));
			// clean data, if empty pass
			if ($data){
				foreach ($data as $key=>$val){
					
					
					foreach ($val['data'] as $keys=>$values){
						
						$newData[$key]['sheet'] = $val['sheet'];
						$newData[$key]['field_name'] = $val['field_name'];
						
						if (!empty($values[0])){
							
							$newData[$key]['data'][$keys] = $values;
						}
					}
				
				}
				logFile('clean data');
			}else{

				echo json_encode(array('status'=>false, 'msg'=>"Error ! no data"));
				exit;
			
			}
			// pr($newData);
			return $newData;
			
		
	}
	
	function referenceData($newData=array())
	{
		global $C_SPEC;
		if (empty($newData)) return false;
		
		$sql = array();
		$arrTmp = array();
		$dataKey = array();
		
		$ignoreTable = array(2);
		$numberTable = array(1,2,3,4);
		$defineTable = array(1=>'taxon',2=>'img',3=>'person',4=>'locn');
		
		// Img table identified
		$fieldFetch[2] = array('id','indivID','personID','md5sum','filename','directory','plantpart','notes','mimetype'); 
		$fieldConvert[2] = array('tree_id'=>'indivID','plant_part'=>'plantpart','photographer'=>'personID'); 
		$fieldUnique[2] = array('unique_key'); 
		
		// Taxon table identified
		$fieldFetch[1] = array('tmp_unique_key','morphotype','fam','gen','sp','subtype','ssp','auth','notes'); 
		$fieldConvert[1] = array('ssp_auth'=>'auth', 'unique_key'=>'tmp_unique_key'); 
		$fieldUnique[1] = array('tmp_unique_key'); 
		
		// Person table identified
		$fieldFetch[3] = array('tmp_unique_key','name','email','twitter','website','phone','short_namecode'); 
		$fieldConvert[3] = array('db_id'=>'id','unique_key'=>'tmp_unique_key'); 
		$fieldUnique[3] = array('tmp_unique_key'); 
		
		// Locn table identified
		$fieldFetch[4] = array('tmp_unique_key','longitude','latitude', 'elev', 'geomorph','locality','county',
								'province','island','country','notes','short_namecode'); 
		$fieldConvert[4] = array('long'=>'longitude', 'lat'=>'latitude','geomorphology'=>'geomorph','kabupaten'=>'county','unique_key'=>'tmp_unique_key'); 
		$fieldUnique[4] = array('tmp_unique_key'); 
		
		$fieldIgnoreUpdateOnDuplicate = array('name','email'); //,'gen','sp','subtype','ssp','auth');
		$fieldNotNull = array('personID','indivID','taxonID','subtype','email'); //,'gen','sp','subtype','ssp','auth');
		$fieldIgnoreEnum = array('subtype');
		$convert = 1;
		foreach ($newData as $key => $values){
			
			
			$fieldKey = @array_keys($fieldConvert[$convert]);
			if (in_array($key,$numberTable)){
				foreach ($values['data'] as $k=> $val){
					
					$keyField = array();
					$tmpField = array();
					$tmpData = array();
					$t_field = array();
					$t_data = array();
					$t_dataraw = array();
					$uniqueKey = array();
					$tmpupdate = array();
					
					foreach ($val as $keys => $v){
						
						if (!empty($fieldKey)){
						
							if (in_array($keys, $fieldKey)){
							
								// check if field excel not same with table DB, run convert field
								$keyField = $fieldConvert[$convert][$keys];
								if (in_array($keyField, $fieldFetch[$convert])){
									$keyField = $keyField;
									
									// check collection libs before
									$keyData = $this->validateField($defineTable[$key], $keyField, $v);
								}else $keyField = false;
								
							}else{
								// if field exist in table, then insert to array
								if (in_array($keys, $fieldFetch[$convert])){
									$keyField = $keys;
									
									// check collection libs before
									$keyData = $this->validateField($defineTable[$key], $keyField, $v);
								}else $keyField = false;
							}
						}
						
						// if field empty don't store to array
						if ($keyField){
						// echo $keyField.'<br>';
							if (in_array($keyField, $fieldUnique[$convert])){
								if ($keyData) $uniqueKey = $keyData;
								
							}else{

								
								$t_field[] = $keyField;
								$t_data[] = "'$keyData'"; 
								$t_dataraw[$keyField] = $keyData; 
								
								
								// if unique data field is empty do nothing
								logFile('data field :'.$keyField.'='.$keyData);
								if (in_array($keyField, $fieldNotNull)){
									if ($keyData==""){
										echo json_encode(array('status'=>false, 'msg'=>"Error ! $keyField {$this->locale['default']['upload_xls_error']}"));
									exit;
									} 
								}

								

								// if unique key dont update
								if (!in_array($keyField, $fieldIgnoreUpdateOnDuplicate))$tmpupdate[] = "`$keyField` = '$keyData'";
							}
							
						}
						
					}
					
					if ($defineTable[$key]=='person'){
						$t_field[] = 'institutions';
						$t_field[] = 'project';
						$t_data[] = "'comunity kalbar'"; 
						$t_data[] = "'Peer Project USAID-Harvard-UG-Surya Flora kalbar'"; 

						$tmpupdate[] = "`institutions` = 'comunity kalbar'";
						$tmpupdate[] = "`project` = 'Peer Project USAID-Harvard-UG-Surya Flora kalbar'";
					}
						



					// generate query
					$tmpField = implode(',',$t_field); 
					$tmpData = implode(',',$t_data); 
					$update = implode(',', $tmpupdate);

					if (!in_array($key,$ignoreTable)){
						$sql[$defineTable[$key]][] = "INSERT INTO {$defineTable[$key]} ({$tmpField}) VALUES ({$tmpData}) ON DUPLICATE KEY UPDATE {$update} , id=LAST_INSERT_ID(id)";
						
						// $sql[$defineTable[$key]][] = "REPLACE INTO {$defineTable[$key]} ({$tmpField}) VALUES ({$tmpData}) ";
						
						
					}
					// pr($uniqueKey);
					if ($uniqueKey) $dataKey[$defineTable[$key]][] = $uniqueKey;
					// $arrTmp[$defineTable[$key]]['field'][] = $t_field;
					$arrTmp[$defineTable[$key]]['data'][] = $t_dataraw;
				}
				
			}
			
			$convert++;
			
		}
		// pr($arrTmp);
		
		$returnArr['query'] = $sql;
		$returnArr['uniqkey'] = $dataKey;
		$returnArr['rawdata'] = $arrTmp;
		
		// logFile(serialize($returnArr));
		logFile(serialize($sql));
		logFile('referenceData ready');
		
		return $returnArr;
	}
	
	
	function parseMasterData($newData=array(), $subtitute=false, $index=0, $table='indiv')
	{
		global $C_SPEC;
		
		if (empty($newData)) return false;
		
		$arrTmp = array();
		// pr($newData);exit;
		$sql = array();
		
		
		$numberTable = array(0);
		if ($subtitute){
			$defineTable = array($index=>$table);
			$startconvert = 0;
		}else{
			$defineTable = array(1=>'det', 2=>'obs',3=>'coll');
			$startconvert = 1;
		}
		
		$fieldFetch = array();
		$fieldUnique = array();
		
		// Indiv table identified
		$fieldFetch[0] = array('locnID','plot','tag','unique_key', 'personID'); 
		$fieldConvert[0] = array('tmp_location_key'=>'locnID', 'tmp_creator_key'=>'personID'); 
		$fieldUnique[0] = array('unique_key');
		
		// Det table identified
		$fieldFetch[1] = array('indivID','personID','det_date','taxonID','confid','notes','using'); 
		$fieldConvert[1] = array('tmp_indiv_key'=>'indivID','tmp_taxon_key'=>'taxonID','tmp_person_key'=>'personID',
								'det_notes'=>'notes'); 
		$fieldUnique[1] = array('unique_key');
		
		// Obs table identified
		$fieldFetch[2] = array('indivID','date','personID','microhab','habit','dbh',
								'height','bud','flower','fruit','localname','notes','char_lf_insert_alt','char_lf_insert_opp'); 
		$fieldConvert[2] = array('tmp_indiv_key'=>'indivID','tmp_person_key'=>'personID'); 
		$fieldUnique[2] = array('unique_key');
		
		// Coll table identified
		$fieldFetch[3] = array('dateColl','indivID','collReps','dnaColl','notes','deposit'); 
		$fieldConvert[3] = array('tmp_indiv_key'=>'indivID','indiv_notes'=>'notes'); 
		$fieldUnique[3] = array('indivID');
		
		// Image table identified
		$fieldFetch[4] = array('indivID','personID','filename','notes'); 
		$fieldConvert[4] = array('tmp_person_key'=>'personID','tmp_indiv_key'=>'indivID'); 
		$fieldUnique[4] = array('unique_key');
		
		// Collector table identified
		$fieldFetch[5] = array('collID','personID','order'); 
		$fieldConvert[5] = array('tmp_person_key'=>'personID','tmp_coll_key'=>'collID'); 
		$fieldUnique[5] = array('unique_key');
		
		$fieldNotNull = array('personID','indivID','taxonID','locnID'); //,'gen','sp','subtype','ssp','auth');
		
		$convert = $startconvert;
		$dataKey = array();
		$returnArr = array();
		
		foreach ($defineTable as $a => $b){
		
			foreach ($newData as $key => $values){
				
				if (in_array($key,$numberTable)){
					foreach ($values['data'] as $k=> $val){
						
						$keyField = array();
						$tmpField = array();
						$tmpData = array();
						$t_field = array();
						$t_data = array();
						$t_dataraw = array();
						$uniqueKey = array();
						$tmpupdate = array();

						$fieldKey = @array_keys($fieldConvert[$a]);
						foreach ($val as $keys => $v){
							
							if (in_array($keys, $fieldKey)){
								
								// check if field excel not same with table DB, run convert field
								$keyField = $fieldConvert[$a][$keys];
								if (in_array($keyField, $fieldFetch[$a])){
									
									$tmpkeyField = $keyField;
									// check collection libs before
									$keyData = $this->validateField($defineTable[$key], $keyField, $v);
									
									
								}else $tmpkeyField = false;
								
							}else{
								// if field exist in table, then insert to array
								if (in_array($keys, $fieldFetch[$a])){
									
									$tmpkeyField = $keys;
									
									// check collection libs before
									$keyData = $this->validateField($defineTable[$key], $keyField, $v);
									
								}else $tmpkeyField = false;
								
							}
							
							
							// if field empty don't store to array
							if ($tmpkeyField){
								
								
								
								
								
								if ($b=='indiv'){
									if (in_array($tmpkeyField, $fieldUnique[$convert])){
										if ($keyData) $uniqueKey = $keyData;
										
									}else{
										$t_field[] = $tmpkeyField;

										if (in_array($tmpkeyField, array('plot','tag'))){
											if ($tmpkeyField=='plot'){
												if ($keyData !='')$t_data[] = "'$keyData'"; 
												else $t_data[] = "0"; 
											}
											
											if ($tmpkeyField=='tag'){
												if ($keyData !='')$t_data[] = "'$keyData'"; 
												else $t_data[] = "0"; 
											}
										}else{
											$t_data[] = "'$keyData'"; 
										}


										
										$t_dataraw[$tmpkeyField] = $keyData; 
										$tmpupdate[] = "`{$tmpkeyField}` = '$keyData'";

										logFile('data field :'.$tmpkeyField.'='.$keyData);
										if (in_array($tmpkeyField, $fieldNotNull)){
											if ($keyData==""){
												echo json_encode(array('status'=>false, 'msg'=>"Error ! $b {$this->locale['default']['upload_xls_error']}"));
											exit;
											} 
										}

									}
								}else{
									if (in_array($tmpkeyField, $fieldUnique[$convert])){
										if ($keyData) $uniqueKey = $keyData;
										
									}
									
									$t_field[] = $tmpkeyField;
									
									if (in_array($tmpkeyField, array('dbh','height'))){
										if ($tmpkeyField=='dbh'){
											if ($keyData !='')$t_data[] = "'$keyData'"; 
											else $t_data[] = "0.0"; 
										}
										
										if ($tmpkeyField=='height'){
											if ($keyData !='')$t_data[] = "'$keyData'"; 
											else $t_data[] = "0.00"; 
										}
									}else{
										$t_data[] = "'$keyData'"; 
									}

									

									$t_dataraw[$tmpkeyField] = $keyData; 
									$tmpupdate[] = "`{$tmpkeyField}` = '$keyData'";

									// if unique data field is empty do nothing
									logFile('data field :'.$tmpkeyField.'='.$keyData);
									if (in_array($tmpkeyField, $fieldNotNull)){
										if ($keyData==""){
											echo json_encode(array('status'=>false, 'msg'=> "Error ! $tmpkeyField {$this->locale['default']['upload_xls_error']}"));
										exit;
										} 
									}

								}
								
									
								
							}
							
						}
						
						/* inject data to table */
						if ($b == 'coll'){
							
							$t_field[] = 'collCode';
							$tmpCode = str_shuffle('ABCDEFGHIJ1234567890');
							$t_data[] = "'$tmpCode'";
							// $dataKey[$b][] = $tmpCode;
							$tmpupdate[] = "`collCode` = '$tmpCode'";

							logFile('data field :'.$tmpkeyField.'='.$keyData);
							if (in_array($tmpkeyField, $fieldNotNull)){
								if ($keyData==""){
									echo json_encode(array('status'=>false, 'msg'=> "Error ! $b {$this->locale['default']['upload_xls_error']}"));
								exit;
								} 
							}
						}	

						// pr($tmpkeyField);
						// generate query
						$tmpField = implode(',',$t_field); 
						$tmpData = implode(',',$t_data); 
						$update = implode(',', $tmpupdate);
						$sql[$b][] = "INSERT INTO {$b} ({$tmpField}) VALUES ({$tmpData}) ON DUPLICATE KEY UPDATE {$update} , id=LAST_INSERT_ID(id)";
						// $sql[$b][] = "REPLACE INTO {$b} ({$tmpField}) VALUES ({$tmpData})";
						
						$arrTmp[$b]['data'][] = $t_dataraw;
						
						if ($uniqueKey) $dataKey[$b][] = $uniqueKey;
					}
					
				}
				
				$convert++;
				
			}
		}
		// pr($dataKey);
		// exit;
		$returnArr['query'] = $sql;
		$returnArr['uniqkey'] = $dataKey;
		$returnArr['rawdata'] = $arrTmp;
		// pr($returnArr);
		logFile(serialize($sql));
		logFile('parseMasterData success');
		
		return $returnArr;
	}
	
	// validate field input and clean data from coll_conf.php
	function validateField($defineTable=false, $keyField=false, $v=false)
	{
		global $C_SPEC;
		
		
		if (!$defineTable && !$keyField && !$v) return false;
		
		$libsDefine = $C_SPEC[$defineTable][$keyField];
		$cleanData = htmlentities($v, ENT_QUOTES);
		if ($libsDefine){
			list ($type, $length) = explode(',',$libsDefine);
			
			if ($type=='string'){
				if (is_string($cleanData) && strlen($cleanData)<=trim($length)) $cleanData = $cleanData;
				else $cleanData = "";
			}
			if ($type=='int'){
				if (is_int((int)$cleanData) && strlen($cleanData)<=$length) $cleanData = $cleanData;
				else $cleanData = "";
			}
		}
		
		return $cleanData;
	}
	
	function select2Database()
	{
		$sql = "select blablabla";
		$res = $this->fetch($sql,1,1); // parameter 1 terakhir itu index database, kalo defaultnya pake 0 gk usah di pake
		$res = $this->query($sql,1); // parameter 1 itu index database, kalo defaultnya pake 0 gk usah di tulis
		
	}
}

?>