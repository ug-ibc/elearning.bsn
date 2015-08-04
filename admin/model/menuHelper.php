<?php
class menuHelper extends Database {
	
	
	function getMenu($id=false)
	{
		
		// pr($_SESSION);
		$type = $_SESSION['admin']['usertype'];
		
		$rule = "SELECT *
				FROM cdc_group_rule
				WHERE groupID = {$type} LIMIT 1";
		// pr($rule);
		$resRule = $this->fetch($rule);
		if ($resRule){
			$modul = $resRule['module']; 
			$queryParent = "SELECT *
						FROM `cdc_menu`
						WHERE n_status = 1 AND parent = 0 AND id IN ({$modul}) ORDER BY orderby";
			
			$resultParent = $this->fetch($queryParent,1);
			// pr($resultParent);
			if($resultParent){
				foreach ($resultParent as $key=> $val){
					$querySub = "SELECT *
								FROM `cdc_menu`
								WHERE n_status = 1 AND parent = {$val['id']} ORDER BY orderby";
					
					$resultParent[$key]['sub'] = $this->fetch($querySub,1);
				}
			}
		}
		
		
		return $resultParent;
	}
	
}
?>