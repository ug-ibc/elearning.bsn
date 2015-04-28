<?php
class contentHelper extends Database {
	
	var $prefix = "lelang";
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
}
?>