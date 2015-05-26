<?php
class searchHelper extends Database {
	
	function searchData($data)
	{
		$dataSearch = clean($data);
		
		$param[] = "Collector_Name LIKE '%{$dataSearch}%' ";
		// $param[] = "Collector_Name LIKE '%{$dataSearch}%' OR ";
		
		$filter = implode(' ', $param);
		$sql = "SELECT * FROM specimen WHERE {$filter} LIMIT 5";
		$res = $this->fetch($sql,1);
		if ($res){
			return $res;
		}
		
		return false;
		
	}
	
	function searchByID($id=null)
	{
		if ($id==null) return false;
		
		$sql = "SELECT spc.ID_Specimen, spc.Collector_Name, det.Family_Code, det.Genus_Code, det.Species_Code
				FROM specimen AS spc 
				LEFT JOIN determination AS det 
				ON spc.ID_Specimen = det.ID_Specimen WHERE spc.ID_Specimen = {$id}";
		// pr($sql);
		$res['determination'] = $this->fetch($sql);
		if ($res){
			
			$res['family'] = $this->getFamily($res['determination']['Family_Code']);
			// pr($res);
			
			return $res;
		}
		
		return false;
	}
	
	
	function getFamily($id=0)
	{
		if ($id==0) $filter = "";
		else $filter = "WHERE fm.Family_ID = {$id}";
		
		$sql = "SELECT fam.Family FROM family AS fm  
				LEFT JOIN family_text AS fam
				ON fm.Family = fam.ID
				{$filter}";
		$res = $this->fetch($sql);
		if ($res) return $res;
		
		return false;
	}
	
	function getGenus($id=0)
	{
		if ($id==0) $filter = "";
		else $filter = "WHERE gn.Genus_ID = {$id}";
		
		$sql = "SELECT gen.Genus FROM genus AS gn  
				LEFT JOIN genus_text AS gen
				ON gn.Genus = gen.ID
				{$filter}";
		$res = $this->fetch($sql);
		if ($res) return $res;
		
		return false;
	}
	
	function getSpecies($id=0)
	{
		if ($id==0) $filter = "";
		else $filter = "WHERE sp.Species_ID = {$id}";
		
		$sql = "SELECT spec.Species FROM species AS sp  
				LEFT JOIN species_text AS spec
				ON sp.Species = spec.ID
				{$filter}";
		$res = $this->fetch($sql);
		if ($res) return $res;
		
		return false;
	}
	
	function getLocalName($id=0)
	{
		if ($id==0) return false;
		
		$sql = "SELECT * FROM  local_name WHERE ID_Specimen = {$id}";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		
		return false;
	}
	
	function getDetermination($id, $distinct=false, $start=0, $limit=20, $loop=true)
	{
		
		if ($distinct)$filterdistinct = "DISTINCT({$distinct})";
		else $filterdistinct = "*";
		
		if ($id){
			$filterid = "WHERE ID_Determination = {$id}";
			$loop = false;
		}else{
			$filterid = "";
		}
		
		
		$sql = "SELECT {$filterdistinct} FROM determination {$filterid} LIMIT {$start}, {$limit}";
		// pr($sql);
		$res = $this->fetch($sql,$loop);
		if ($res){
			return $res;
		}
		
		return false;
	}
	
	function getSpecimen($id, $distinct=false, $start=0, $limit=20, $loop=true)
	{
		if ($distinct)$filterdistinct = "DISTINCT({$distinct})";
		else $filterdistinct = "*";
		
		if ($id){
			$filterid = "WHERE ID_Specimen = {$id}";
			$loop = false;
		}else{
			$filterid = "";
		}
		
		
		$sql = "SELECT {$filterdistinct} FROM specimen {$filterid} LIMIT {$start}, {$limit}";
		// pr($sql);
		$res = $this->fetch($sql,$loop);
		if ($res){
			return $res;
		}
		
		return false;
	}
	
	function getSpeciesName($param=null)
	{
		if ($param==null) $filter = "";
		else $filter = "WHERE Species LIKE '%{$param}%'";
		
		$sql = "SELECT det.ID_Specimen, sp.Species from Determination AS det 
				LEFT JOIN species AS sp 
				ON det.Species_Code = sp.Species_ID LIMIT 100";
		$res = $this->fetch($sql,1);
		if ($res){
			
			foreach ($res as $key => $value){
				$res[$key]['Family'] = $this->getSpecies($value['Species']);
				$res[$key]['Genus'] = $this->getSpecies($value['Species']);
				$res[$key]['Species'] = $this->getSpecies($value['Species']);
			}
			
			pr($res);
			// return $res;
		}
		
		return false;
	}

		
}
?>