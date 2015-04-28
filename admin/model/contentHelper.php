<?php
class contentHelper extends Database {
	
	var $prefix = "lelang";

	function getData()
	{
		$sql = "SELECT * FROM code_activity";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	
	function getMessage()
	{
		$sql = "SELECT m.*, um.name,um.email FROM my_message m LEFT JOIN user_member um ON m.receive = um.id ";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	
	function saveMessage($data)
	{
		foreach ($data as $key => $val){
			$tmpfield[] = $key;
			$tmpdata[] = "'$val'";
		}
		// from,to,subject,content,createdate,n_status
		$tmpfield[] = 'fromwho';
		$tmpfield[] = 'createdate';
		$tmpfield[] = 'n_status';
		
		$date = date('Y-m-d H:i:s');
		$tmpdata[] = 0;
		$tmpdata[] = "'{$date}'";
		$tmpdata[] = 1;
		
		$field = implode(',',$tmpfield);
		$data = implode(',',$tmpdata);
		
		$sql = "INSERT INTO my_message ({$field}) 
				VALUES ({$data})";
		// pr($sql);
		// exit;
		$res = $this->query($sql);
		if ($res) return true;
		return false;
	}
	
	function get_user($data)
	{
		$query = "SELECT * FROM user_member WHERE email = '{$data}'";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function importData($name=null)
	{
		$query = "INSERT INTO import (name,n_status) VALUES ('{$name}', 1)";
		// pr($query);
		$result = $this->query($query);
		
		return $result;
	}

	function getWilayah($name=null)
	{
		$query = "SELECT * FROM tbl_wilayah WHERE parent = 0 ORDER BY nama_wilayah";
		// pr($query);
		$result = $this->fetch($query,1);
		
		return $result;
	}

	function getBalai($name=null)
	{
		$query = "SELECT * FROM tbl_balai WHERE parent = 0 ORDER BY namaBalai";
		// pr($query);
		$result = $this->fetch($query,1);
		
		return $result;
	}

	function getLaporanKemasan($data, $debug=false)
	{
		$id = $data['id'];
		$n_status = $data['n_status'];

		$filter = "";
		
		if ($id) $filter = " AND k.id = {$id}";

		$sql = array(
                'table'=>"{$this->prefix}_pelaporan_kemasan AS k, {$this->prefix}_industri AS i , {$this->prefix}_product AS p, {$this->prefix}_industri_pabrik AS ip",
                'field'=>"k.*, i.namaIndustri, i.noTelepon, i.noFax, i.namaPimpinan, p.merek, ip.noNPPBKC, ip.namaJalan",
                'condition' => "k.pabrikID != 0 AND k.n_status IN ({$n_status}) {$filter}",
                'limit' => '100',
                'joinmethod' => 'LEFT JOIN',
                'join' => 'k.industriID = i.id, k.merek = p.id, k.pabrikID = ip.id'
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
		return false;

	}

	function getLaporanKemasanList($data, $debug=false)
	{
		$id = $data['id'];
		$n_status = $data['n_status'];

		$filter = "";
		
		if ($id) $filter = " AND k.id = {$id}";

		$sql = array(
                'table'=>"{$this->prefix}_pelaporan_kemasan AS k, {$this->prefix}_industri AS i ",
                'field'=>"k.industriID, i.namaIndustri, i.noTelepon, i.noFax, i.namaPimpinan",
                'condition' => "k.pabrikID != 0 AND k.n_status IN ({$n_status}) {$filter} GROUP BY k.industriID",
                'joinmethod' => 'LEFT JOIN',
                'join' => 'k.industriID = i.id'
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res){
        	foreach ($res as $key => $value) {
        		
        		$sql = array(
		                'table'=>"{$this->prefix}_pelaporan_kemasan AS k, {$this->prefix}_industri AS i , {$this->prefix}_product AS p, {$this->prefix}_industri_pabrik AS ip",
		                'field'=>"k.*, i.namaIndustri, i.noTelepon, i.noFax, i.namaPimpinan, p.merek, ip.noNPPBKC, ip.namaJalan",
		                'condition' => "k.pabrikID != 0 AND k.n_status IN ({$n_status}) AND k.industriID = {$value['industriID']} {$filter}",
		                'joinmethod' => 'LEFT JOIN',
		                'join' => 'k.industriID = i.id, k.merek = p.id, k.pabrikID = ip.id'
		                );

		        $res[$key]['merek'] = $this->lazyQuery($sql,$debug);

        	}
        }
       
        if ($res) return $res;
		return false;

	}

	function evaluasiKemasan($data, $debug=false)
	{

		$arrfield = array('tulisanPeringatan','jenisGambar','jenis','isi','namaDan_alamat','bentuKemasan','luasDepan','luasBelakang','kodeProduksi','tglProduksi','kadarNikotin','kadarTar',
						'pernyataanDilarang_menjual','pernyataanTidak_aman','pernyataanZat_kimia','kesimpulan','n_status','catatanDitolak');
		
		foreach ($data as $key => $value) {
			if (in_array($key, $arrfield)){
				if ($value)$field[] = "$key = '".$value."'";
			}
		}

		$impField = implode(',', $field);

		$sql = array(
                'table'=>"{$this->prefix}_pelaporan_kemasan",
                'field'=>"{$impField}",
                'condition' => "id = {$data['idPelaporan']}",
                );

        $res = $this->lazyQuery($sql,$debug,2);
        if ($res) return $res;
		return false;
	}

	function evaluasiNikotin($data, $debug=false)
	{

		$arrfield = array('jenis','kodeSample','isiKemasan','catatanDitolak',
							'noSertifikat','tanggalUji','kadarNikotin','kadarTar','kadarKretek','n_status');
		
		foreach ($data as $key => $value) {
			if (in_array($key, $arrfield)){
				if ($value)$field[] = "$key = '".$value."'";
			}
		}

		$impField = implode(',', $field);

		$sql = array(
                'table'=>"{$this->prefix}_pelaporan_nikotin",
                'field'=>"{$impField}",
                'condition' => "id = {$data['idPelaporan']}",
                );

        $res = $this->lazyQuery($sql,$debug,2);
        if ($res) return $res;
		return false;
	}

	function getLaporanNikotin($data, $debug=false)
	{
		$id = $data['id'];
		$n_status = $data['n_status'];

		$filter = "";
		
		if ($id) $filter = " AND n.id = {$id}";

		$sql = array(
                'table'=>"	{$this->prefix}_pelaporan_nikotin AS n, 
                			{$this->prefix}_industri AS i , 
                			{$this->prefix}_product AS p, 
                			{$this->prefix}_industri_pabrik AS ip,
                			{$this->prefix}_lab AS l", 
                'field'=>"n.*, i.namaIndustri, p.merek, ip.noNPPBKC, ip.provinsi, ip.kecamatan, ip.namaJalan,
                		l.nama AS namaLab, l.penanggungjawab",
                'condition' => "n.pabrikID != 0 AND n.n_status IN ({$n_status}) {$filter}",
                'limit' => '100',
                'joinmethod' => 'LEFT JOIN',
                'join' => 'n.industriID = i.id, n.merek = p.id, n.pabrikID = ip.id, n.labID = l.id'
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
		return false;
	}

	function getLaporanNikotinList($data, $debug=false)
	{
		$id = $data['id'];
		$n_status = $data['n_status'];

		$filter = "";
		
		if ($id) $filter = " AND n.id = {$id}";

		$sql = array(
                'table'=>"	{$this->prefix}_pelaporan_nikotin AS n, 
                			{$this->prefix}_industri AS i", 
                'field'=>"n.*, i.namaIndustri",
                'condition' => "n.pabrikID != 0 AND n.n_status IN ({$n_status}) {$filter} GROUP BY n.industriID",
                'joinmethod' => 'LEFT JOIN',
                'join' => 'n.industriID = i.id'
		                
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res){
        	foreach ($res as $key => $value) {
        		$sql = array(
		                'table'=>"	{$this->prefix}_pelaporan_nikotin AS n, 
		                			{$this->prefix}_industri AS i , 
		                			{$this->prefix}_product AS p, 
		                			{$this->prefix}_industri_pabrik AS ip,
		                			{$this->prefix}_lab AS l", 
		                'field'=>"n.*, i.namaIndustri, p.merek, ip.noNPPBKC, ip.provinsi, ip.kecamatan, ip.namaJalan,
		                		l.nama AS namaLab, l.penanggungjawab",
		                'condition' => "n.pabrikID != 0 AND n.n_status IN ({$n_status}) AND n.industriID = {$value['industriID']} {$filter}",
		                'joinmethod' => 'LEFT JOIN',
		                'join' => 'n.industriID = i.id, n.merek = p.id, n.pabrikID = ip.id, n.labID = l.id'
		                );

		        $res[$key]['nikotin'] = $this->lazyQuery($sql,$debug);
        	}
        }

        // pr($res);
        if ($res) return $res;
		return false;
	}

	function getDataEvaluasi($id=false, $n_status=1)
	{

		$filter = "";
		// $n_status = $data['n_status'];

		if ($id) $filter = " AND e.id = {$id}";

		// $sql = array(
  //               'table'=>"{$this->prefix}_evaluasi AS e, {$this->prefix}_product AS p , {$this->prefix}_product_image_type AS i, tbl_balai AS b",
  //               'field'=>'e.*, p.merek, p.produsen, p.alamat, p.jenis, i.typeGambar,
		// 					i.tulisanGambar, b.namaBalai',
  //               'condition' => "e.n_status = {$n_status} {$filter}",
  //               'limit' => '100',
  //               'joinmethod' => 'LEFT JOIN',
  //               'join' => 'e.produkID = p.id, e.jenisGambar = i.id, e.balaiID = b.kodeBalai'
  //               );

        // $res = $this->lazyQuery($sql,$debug);

		$query = "SELECT e.*, p.merek, p.produsen, p.alamat, p.jenis, i.typeGambar,
					i.tulisanGambar, b.namaBalai
					FROM {$this->prefix}_evaluasi e LEFT JOIN {$this->prefix}_product p 
					ON e.produkID = p.id LEFT JOIN  {$this->prefix}_product_image_type i
					ON e.jenisGambar = i.id LEFT JOIN  tbl_balai b
					ON e.balaiID = b.kodeBalai 
					WHERE e.n_status = {$n_status} {$filter}";
		// pr($query);
		$result = $this->fetch($query,1);
		if ($result) return $result;
		return false;
	}

	function updateStatusKemasan($data, $debug=false)
	{

		$id = $data['id'];
		$n_status = $data['n_status'];
		$sql = array(
                'table'=>"{$this->prefix}_pelaporan_kemasan ",
                'field'=>"n_status = {$n_status}",
                'condition' => "id = {$id}",
                );

        $res = $this->lazyQuery($sql,$debug,2);
        if ($res) return true;
		return false;
	}

	function updateStatusNikotin($data, $debug=false)
	{
		$id = $data['id'];
		$n_status = $data['n_status'];
		$sql = array(
                'table'=>"{$this->prefix}_pelaporan_nikotin ",
                'field'=>"n_status = {$n_status}",
                'condition' => "id = {$id}",
                );

        $res = $this->lazyQuery($sql,$debug,2);
        if ($res) return true;
		return false;
	}

	function updateDataEvaluasi($data=array())
	{

		if (empty($data)) return false;

		$ignoreList = array('id','alamat','tulisanGambar');
		foreach ($data as $key => $value) {
			
			if (!in_array($key, $ignoreList)){
				$tmpField[] = "`$key` = ". "'".$value."'";
				
			}
		}

		
		$impData = implode(',', $tmpField);

		$sql = "UPDATE {$this->prefix}_evaluasi SET {$impData} WHERE id = {$data['id']} LIMIT 1";
		// pr($sql);
		$res = $this->query($sql);
		if ($res) return true;
		return false;
	}

	function validateData($id=false, $n_status=2)
	{

		if (!$id) return false;
		$sql = "UPDATE {$this->prefix}_pelaporan_kemasan SET n_status = {$n_status} WHERE id IN ({$id})";
		// pr($sql);exit;
		$res = $this->query($sql);
		if ($res) return true;
		return false;
	}

	function validateDataNikotin($id=false, $n_status=2)
	{

		if (!$id) return false;
		$sql = "UPDATE {$this->prefix}_pelaporan_nikotin SET n_status = {$n_status} WHERE id IN ({$id})";
		// pr($sql);exit;
		$res = $this->query($sql);
		if ($res) return true;
		return false;
	}

	function getPabrik($id=false, $indusrtiID=false, $debug=false)
	{

		$filter = "";

		if ($id) $filter .= "AND id = '{$id}'";
		if ($indusrtiID) $filter .= "AND indusrtiID = '{$indusrtiID}'";

		$sql = array(
                    'table' =>"{$this->prefix}_industri_pabrik",
                    'field' => "*",
                    'condition' => "1 {$filter}",
                );
        $result = $this->lazyQuery($sql,$debug);
        if ($result) return $result;
        return false;
	}

	function getKab($id=false, $parent=false, $debug=false)
	{

		$filter = "";

		if ($id) $filter .= "AND kode_wilayah = '{$id}'";
		if ($parent) $filter .= "AND parent = '{$parent}'";

		$sql = array(
                    'table' =>"tbl_wilayah",
                    'field' => "*",
                    'condition' => " 1 {$filter} ORDER BY nama_wilayah"
                );
        $result = $this->lazyQuery($sql, $debug);
        if ($result) return $result;
        return false;
	}
	
	function getIndustri($id=false, $debug=false)
	{

		$filter = "";
		$limit = "";
		if ($id){
			$filter = " AND id = {$id}";
			$limit = 1;
		} 
		$sql = array(
                    'table' =>"{$this->prefix}_industri",
                    'field' => "*",
                    'condition' => "1 AND namaIndustri != '' {$filter}",
                    'limit' => $limit
                );
        $result = $this->lazyQuery($sql, $debug);
        if ($result) return $result;
        return false;
	}

	function getMerekProduk($id=false)
	{
		$sql = array(
                    'table' =>"{$this->prefix}_product",
                    'field' => "*",
                    'condition' => "n_status = 1",
                    
                );
        $result = $this->lazyQuery($sql);
        if ($result) return $result;
        return false;
	}

	function getProdusen($id=false)
	{
		$sql = array(
                    'table' =>"{$this->prefix}_product",
                    'field' => "*",
                    'condition' => "n_status = 1 AND id = {$id}",
                    
                );
        $result = $this->lazyQuery($sql);
        if ($result) return $result;
        return false;
	}

	function getLokasi($id=false,$debug=false)
	{

		$filter = "";

		if ($id) $filter .= "AND kode_wilayah = '{$id}'";
		$sql = array(
                    'table' =>"tbl_wilayah",
                    'field' => "*",
                    'condition' => "1 {$filter} ORDER BY nama_wilayah"
                );
        $result = $this->lazyQuery($sql, $debug);
        if ($result) return $result;
        return false;
	}

	function getTulisanPeringatan($id=false,$debug=false)
	{
		$filter = "";

		if ($id) $filter .= "AND kode_wilayah = '{$id}'";
		$sql = array(
                    'table' =>"{$this->prefix}_peringatan_kesehatan",
                    'field' => "*",
                    'condition' => "1 {$filter}"
                );
        $result = $this->lazyQuery($sql, $debug);
        if ($result) return $result;
        return false;
	}

	function getProduk($id=false, $debug=false)
	{

		$filter = "";

		if ($id) $filter .= "AND id = '{$id}'";
		
		$sql = array(
                    'table' =>"{$this->prefix}_product",
                    'field' => "*",
                    'condition' => "1 {$filter}",
                );
        $result = $this->lazyQuery($sql,$debug);
        if ($result) return $result;
        return false;
	}

	function saveDataKemasan($data, $debug=false)
	{
		foreach ($data as $key => $value) {
			$$key = $value;
		}

		$createDate = date('Y-m-d H:i;s');
		$n_status = 7;

		
		$sql = array(
                    'table' =>"{$this->prefix}_pelaporan_kemasan",
                    'field' => "industriID, pabrikID, merek ,jenis, isi, bentuKemasan,
                    			jenisGambar,tulisanPeringatan,createDate,n_status,kodeProduksi,tglProduksi,
                    			lokasiBeli,tglBeli,tahunCukai,hargaBungkus,hargaBatang",
                    'value' => "'{$industriID}','{$pabrikID}', '{$merek}', '{$jenis}','{$isi}','{$bentuKemasan}','{$jenisGambar}',
                    			'{$tulisanPeringatan}', '{$createDate}',$n_status, '{$kodeProduksi}', '{$tglProduksi}',
                    			'{$lokasiBeli}','{$tglBeli}','{$tahunCukai}','{$hargaBungkus}', '{$hargaBatang}' ",
                );
        $result = $this->lazyQuery($sql,$debug,1);
		
		
        if ($result) return $result;
        return false;
	}

	function updateDataKemasan($data, $debug=false)
	{
		$files = $data['full_name'];
		$id = $data['id'];
		if ($id) $id = $id;
		else $id = $this->insert_id();

		$fotoDepan = $data['fotoDepan']['full_name'];
		if ($fotoDepan) $field[] = "fotoDepan = '{$fotoDepan}'";
		$fotoBelakang = $data['fotoBelakang']['full_name'];
		if ($fotoBelakang) $field[] = "fotoBelakang = '{$fotoBelakang}'";
		$fotoKanan = $data['fotoKanan']['full_name'];
		if ($fotoKanan) $field[] = "fotoKanan = '{$fotoKanan}'";
		$fotoKiri = $data['fotoKiri']['full_name'];
		if ($fotoKiri) $field[] = "fotoKiri = '{$fotoKiri}'";
		$fotoAtas = $data['fotoAtas']['full_name'];
		if ($fotoAtas) $field[] = "fotoAtas = '{$fotoAtas}'";
		$fotoBawah = $data['fotoBawah']['full_name'];
		if ($fotoBawah) $field[] = "fotoBawah = '{$fotoBawah}'";
		$suratPengantar = $data['suratPengantar']['full_name'];
		if ($suratPengantar) $field[] = "suratPengantar = '{$suratPengantar}'";

		if ($field){
			$impF = implode(',', $field);
			$sql = array(
		                'table' =>"{$this->prefix}_pelaporan_kemasan",
		                'field' => "{$impF}",
		                'condition' => "id = {$id}",
		            );
		    $result = $this->lazyQuery($sql,$debug,2);
		    if ($result) return true;
		}
		
        return false;
	}

}
?>