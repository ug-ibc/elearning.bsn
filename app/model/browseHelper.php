<?php

class browseHelper extends Database {
	
    /**
     * @todo retrieve all data from table Taxon
     * 
     * @param $condition = true/false
     * @param $field = field name
     * @param $value = value
     * @return id, rank, morphotype, fam, gen, sp, subtype, ssp, auth, notes
     */
    function dataTaxon($condition,$field,$value){
        if($condition==true){
            $sql = "SELECT * FROM `taxon` WHERE $field='$value'";
            $res = $this->fetch($sql,1);
            return $res;
        }
        elseif($condition==false){
            /*$sql = "SELECT * 
                    FROM `taxon` INNER JOIN `det` ON 
                    taxon.id=det.taxonID INNER JOIN
                    `indiv` ON det.indivID=indiv.id WHERE
                    det.n_status='0'";*/
            $sql="select * from taxon where id in (select det.taxonID from det inner join indiv on indiv.id = det.indivID where indiv.n_status = 0)";
            $res = $this->fetch($sql,1);
            
            //PAGINATION
            if (isset($_GET['pageno'])) {
               $pageno = $_GET['pageno'];
            } else {
               $pageno = 1;
            } // if
            $rows_per_page = 10;
            $lastpage      = ceil(count($res)/$rows_per_page);
            $pageno = (int)$pageno;
            if ($pageno > $lastpage) {
               $pageno = $lastpage;
            } // if
            if ($pageno < 1) {
               $pageno = 1;
            } // if
            $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
            $sqlLimit = $sql.' '.$limit;
           // pr($sqlLimit);exit;
            $resLimit = $this->fetch($sqlLimit,1);
            if($resLimit){
                $return['result'] = $resLimit;
                $return['pageno'] = $pageno;
                $return['lastpage'] = $lastpage;
                return $return;
            }
            else{return false;}
        }
    }
    
    /**
     * @todo retrieve all images from taxon data
     * @param $data = id taxon
     */
    function showImgTaxon($data){
        $sql = "SELECT * 
                FROM `det` INNER JOIN `img` ON 
                    det.taxonID='$data' AND det.indivID=img.indivID GROUP BY img.md5sum LIMIT 0,5";
        $res = $this->fetch($sql,1);
        return $res;
    }
    
    /**
     * @todo retrieve all data from table indiv from selected taxon
     * 
     * @param $action=action selected taxon/locn/person
     * @param $field=field name in db
     * @param $value=id taxon
     * @return 
     */
    function dataIndiv($action,$field,$value){
        if($action=='indivTaxon'){
            $sql = "SELECT * 
                    FROM `det` INNER JOIN `indiv` ON 
                        det.$field='$value' AND det.indivID=indiv.id AND indiv.n_status='0'
                    INNER JOIN `person` ON
                        indiv.personID=person.id
                    INNER JOIN `locn` ON
                        locn.id=indiv.locnID
                    GROUP BY det.indivID";
        }
        
        if($action=='indivLocn'){
            $sql = "SELECT indiv.id as indivID, indiv.locnID, indiv.plot, indiv.tag, indiv.personID, locn.*, person.*
                    FROM `indiv` INNER JOIN `locn` ON 
                        $value=indiv.locnID AND indiv.n_status='0'
                    INNER JOIN `person` ON
                        indiv.personID=person.id
                    GROUP BY indiv.id";
        }
        
        if($action=='indivPerson'){
            $sql = "SELECT indiv.id as indivID, indiv.locnID, indiv.plot, indiv.tag, indiv.personID, locn.*, person.*
                    FROM `indiv` INNER JOIN `locn` ON 
                        $value=indiv.personID AND indiv.n_status='0'
                    INNER JOIN `person` ON
                        $value=person.id
                    INNER JOIN `det` ON
                        indiv.id=det.indivID
                    GROUP BY indiv.id";                   
        }
        
        $res = $this->fetch($sql,1);
        
        //PAGINATION
            if (isset($_GET['pageno'])) {
               $pageno = $_GET['pageno'];
            } else {
               $pageno = 1;
            } // if
            $rows_per_page = 10;
            $lastpage      = ceil(count($res)/$rows_per_page);
            $pageno = (int)$pageno;
            if ($pageno > $lastpage) {
               $pageno = $lastpage;
            } // if
            if ($pageno < 1) {
               $pageno = 1;
            } // if
            $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
            $sqlLimit = $sql.' '.$limit;
            $resLimit = $this->fetch($sqlLimit,1);
            if($resLimit){
                $return['result'] = $resLimit;
                $return['pageno'] = $pageno;
                $return['lastpage'] = $lastpage;
                return $return;
            }
            else{return false;}
    }
    
    /**
     * @todo delete selected image
     */
    function deleteImg($data){
        foreach ($data['id'] as $id){
            $sql="DELETE FROM `img` WHERE `id`='$id' AND indivID='".$data['indivID']."'";
            $res = $this->query($sql,0);
        }
        return true;
    }
    
    /**
     * @todo delete all image in one individual
     */
    function deleteImgIndiv($data){
        $sql="DELETE FROM `img` WHERE indivID='$data'";
        $res = $this->query($sql,0);
        return true;
    }
    
    /**
     * @todo retrieve all data from table Location
     * 
     * @param $condition = true/false
     * @param $field = field name
     * @param $value = value
     * @return id, rank, morphotype, fam, gen, sp, subtype, ssp, auth, notes
     */
    function dataLocation($condition,$field,$value){
        if($condition==true){
            $sql = "SELECT * FROM `locn` WHERE $field='$value'";
            $res = $this->fetch($sql,1);
            return $res;
        }
        elseif($condition==false){
            //$sql = "SELECT * FROM `locn`";
            //$sql="select * from `locn` where id in (select indiv.locnID from indiv where indiv.n_status = 0)";
            $sql="select * from `locn` where id in (select indiv.locnID from indiv inner join det on indiv.id = det.indivID where indiv.n_status = 0)";
            $res = $this->fetch($sql,1);
            
            //PAGINATION
            if (isset($_GET['pageno'])) {
               $pageno = $_GET['pageno'];
            } else {
               $pageno = 1;
            } // if
            $rows_per_page = 10;
            $lastpage      = ceil(count($res)/$rows_per_page);
            $pageno = (int)$pageno;
            if ($pageno > $lastpage) {
               $pageno = $lastpage;
            } // if
            if ($pageno < 1) {
               $pageno = 1;
            } // if
            $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
            $sqlLimit = $sql.' '.$limit;
            $resLimit = $this->fetch($sqlLimit,1);
            if($resLimit){
                $return['result'] = $resLimit;
                $return['pageno'] = $pageno;
                $return['lastpage'] = $lastpage;
                return $return;
            }
            else{return false;}
        }
    }
    
    /**
     * @todo retrieve all data from table person
     * 
     * @param $condition = true/false
     * @param $field = field name
     * @param $value = value
     * @return id, rank, morphotype, fam, gen, sp, subtype, ssp, auth, notes
     */
    function dataPerson($condition,$field,$value){
        if($condition==true){
            $sql = "SELECT * FROM `person` WHERE $field='$value'";
            $res = $this->fetch($sql,1);
            return $res;
        }
        elseif($condition==false){
            $sql = "SELECT * FROM `person`";           
            $res = $this->fetch($sql,1);
            
            //PAGINATION
            if (isset($_GET['pageno'])) {
               $pageno = $_GET['pageno'];
            } else {
               $pageno = 1;
            } // if
            $rows_per_page = 10;
            $lastpage      = ceil(count($res)/$rows_per_page);
            $pageno = (int)$pageno;
            if ($pageno > $lastpage) {
               $pageno = $lastpage;
            } // if
            if ($pageno < 1) {
               $pageno = 1;
            } // if
            $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
            $sqlLimit = $sql.' '.$limit;
            $resLimit = $this->fetch($sqlLimit,1);
            if($resLimit){
                $return['result'] = $resLimit;
                $return['pageno'] = $pageno;
                $return['lastpage'] = $lastpage;
                return $return;
            }
            else{return false;}
        }
    }
    
    /**
     * @todo retrieve all images from indiv data
     * @param $data = id indiv
     */
    function showImgIndiv($data,$limit,$limitVal){
        if($limit==TRUE){
            $sql = "SELECT * FROM `img` WHERE indivID='$data' AND md5sum IS NOT NULL LIMIT $limitVal";
        }
        elseif($limit==FALSE){
            $sql = "SELECT * FROM `img` WHERE indivID='$data'";
        }
        $res = $this->fetch($sql,1);
        return $res;
    }
    
    /**
     * @todo retrieve all indiv detail
     * @param $data = id indiv
     */
    function detailIndiv($data){
        $sql = "SELECT * 
                FROM `indiv` INNER JOIN `locn` ON 
                    indiv.id='$data' AND locn.id=indiv.locnID AND indiv.n_status='0'
                INNER JOIN `person` ON
                    person.id=indiv.personID";
        $res = $this->fetch($sql,1);
        return $res;
    }
    
    /**
     * @todo retrieve all det from indiv selected
     * @param $data = id indiv
     */
    function dataDetIndiv($data){
        $sql = "SELECT det.id as detID, det.*, taxon.*,person.* 
                FROM `det` INNER JOIN `taxon` ON 
                    indivID='$data' AND taxon.id=det.taxonID AND det.n_status='0'
                INNER JOIN `person` ON
                    person.id=det.personID";
        $res = $this->fetch($sql,1);
        return $res;
    }
    
    /**
     * @todo retrieve all obs from indiv selected
     * @param $data = id indiv
     */
    function dataObsIndiv($data){
        $sql = "SELECT obs.id as obsID, obs.*, person.* 
                FROM `obs` INNER JOIN `person` ON 
                    indivID='$data' AND person.id=obs.personID AND obs.n_status='0'";
        $res = $this->fetch($sql,1);
        return $res;
    }
    
    /**
     * @todo update indiv data selected
     * @param $data = POST indiv
     * @param $id = id indiv
     */
    function updateIndiv($data,$id){
        $sql = "UPDATE `indiv` SET `locnID` = '".$data['locnID']."', `plot` = '".$data['plot']."', `tag` = '".$data['tag']."' WHERE `id` = $id;";
        $res = $this->query($sql,0);
        if($res){return true;}
    }
    
    /**
     * @todo update n_status indiv,obs,det,img,coll data selected into 1
     * @param $id = id indiv
     */
    function deleteIndiv($condition,$table,$field,$data){
        if($condition ==''){ 
            $sql = "UPDATE `$table` SET `n_status` = '1' WHERE `$field`='".$data['indivID']."';";
            $res = $this->query($sql,0);
        }
        elseif($condition == 'AND'){
            $sql = "UPDATE `$table` SET `n_status` = '1' WHERE `$field`='".$data['indivID']."' AND `id` = '".$data['id']."';";
            $res = $this->query($sql,0);
        }
        if($res){
            logFile('====Update table '.$table.' id='.$data['indivID'].'n_status = 1====');
            return true;    
        }
        else{
            logFile('====Failed table '.$table.' id='.$data['indivID'].'n_status = 1====');
            return false;}
    }
    
    /**
     * @todo searching from selected table
     * 
     * @param $table= table name
     * @param $data = data to search
     * 
     */
    function search($table,$data){
        if($table=='taxon'){
            $sql = "SELECT * 
                    FROM `$table` INNER JOIN `det` ON 
                    $table.id=det.taxonID AND det.n_status='0' WHERE
                    $table.fam LIKE '%$data%' OR $table.gen LIKE '%$data%' OR $table.sp LIKE '%$data%' OR $table.morphotype LIKE '%$data%'";
            //pr($sql);exit;
        }
        elseif($table=='locn'){
            $sql = "SELECT * FROM `$table` WHERE `longitude` LIKE '%$data%' OR `latitude` LIKE '%$data%' OR `elev` LIKE '%$data%' OR `geomorph` LIKE '%$data%' OR `locality` LIKE '%$data%' OR `county` LIKE '%$data%' OR `province` LIKE '%$data%' OR `island` LIKE '%$data%' OR `country` LIKE '%$data%'";
        }
        elseif($table=='person'){
            $sql = "SELECT * FROM `$table` WHERE `name` LIKE '%$data%' OR `email` LIKE '%$data%' OR `twitter` LIKE '%$data%' OR `website` LIKE '%$data%' OR `phone` LIKE '%$data%' OR `institutions` LIKE '%$data%' OR `project` LIKE '%$data%'";
        }
        $res = $this->fetch($sql,1);
        
        //PAGINATION
            if (isset($_GET['pageno'])) {
               $pageno = $_GET['pageno'];
            } else {
               $pageno = 1;
            } // if
            $rows_per_page = 10;
            $lastpage      = ceil(count($res)/$rows_per_page);
            $pageno = (int)$pageno;
            if ($pageno > $lastpage) {
               $pageno = $lastpage;
            } // if
            if ($pageno < 1) {
               $pageno = 1;
            } // if
            $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
            $sqlLimit = $sql.' '.$limit;
            $resLimit = $this->fetch($sqlLimit,1);
            if($resLimit){
                $return['result'] = $resLimit;
                $return['pageno'] = $pageno;
                $return['lastpage'] = $lastpage;
                $return['countdata'] = $res;
                return $return;
            }
            else{return false;}                
    }
	
}
?>