<?php
class contentHelper extends Database {
	
	var $prefix = "";
	var $salt = "";
	function __construct()
	{
		// $this->db = new Database;
		$this->salt = "ovancop1234";
		$this->token = str_shuffle('cmsaj23y4ywdni237yeisa');
		$this->date = date('Y-m-d H:i:s');

	}

    function getArticle($id=false, $data=array(), $debug=false)
    {

        $filter = "";
        
        if ($id) $filter .= " AND id = {$id}";
        // pr($data);
        if ($data['topcontent']) $filter .= " AND topcontent = 1";
        // else $filter .= " AND topcontent = 0";

        if ($data['slider']) $filter .= " AND slider_image = 1";
        // else $filter .= " AND slider_image = 0";

        $orderby = "";
        if ($data['random']) $orderby .= " ORDER BY RAND()";
        else $orderby .= " ORDER BY posted_date DESC";

        $type = "";
        if ($data['type']) $type .= " AND articleType IN ({$data['type']})";
        else $type .= " AND articleType IN (1,2,3)";

        $n_status = "";
        if ($data['sold']) $n_status .= " n_status IN ({$data['sold']})";
        else $n_status .= " n_status IN (1)";

        $sql = array(
                'table'=>"{$this->prefix}_news_content ",
                'field'=>"*",
                'condition' => "{$n_status} {$type} {$filter} {$orderby}",
                'limit' => '100',
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function getKursus()
    {
        $query = "SELECT * FROM kursus ORDER BY create_time desc LIMIT 4";
        $result = $this->fetch($query,1);

        foreach ($result as $key => $value) {
            $query = "SELECT COUNT(*) as total FROM materi WHERE idKursus = '{$value['idKursus']}'";
            $res = $this->fetch($query);
            $result[$key]['total'] = $res['total'];
        }

        return $result;
    }

    function getCatatan($tipe=1)
    {
        $query = "SELECT * FROM catatan WHERE tipe = {$tipe} AND n_status = 1";

        $result = $this->fetch($query,1);

        return $result;
    }
	
	function get_certificate($id_usr,$id_grp){
		$query = "SELECT u.name,g.namagrup,n.nilai,n.create_time,n.idUser,n.kodeSertifikat FROM grup_kursus as g
				  join nilai as n on n.idGroupKursus = g.idGrup_kursus
				  join user as u on u.idUser = n.idUser
				  where n.idUser = {$id_usr} and n.idGroupKursus = {$id_grp}
				  order by n.nilai desc limit 1";
		$result = $this->fetch($query);

        return $result;
    
		
	}
	
	function get_criteria($id_grp){
		$query = "SELECT kategoriBaik,kategoriCukup,kategoriKurang FROM tbl_quiz_setting 
				  where idGroupKursus = {$id_grp}";
		$result = $this->fetch($query);

        return $result;
    
	}
	
	function get_certificate_by_search($id_crtfkt,$id_grp,$id_usr){
		$query = "SELECT u.name,g.namagrup,n.nilai,n.create_time,n.idUser,n.kodeSertifikat FROM grup_kursus as g
				  join nilai as n on n.idGroupKursus = g.idGrup_kursus
				  join user as u on u.idUser = n.idUser
				  where n.idUser = {$id_usr} and n.idGroupKursus = {$id_grp} and kodeSertifikat = '{$id_crtfkt}'
				  order by n.nilai desc limit 1";
		$result = $this->fetch($query);

        return $result;
    
		
	}
}
?>