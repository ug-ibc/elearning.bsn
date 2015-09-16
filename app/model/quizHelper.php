<?php

class quizHelper extends Database {
	
	var $prefix = "";
	var $salt = "";
	function __construct()
	{
		$loadSession = new Session();
        $getUserData = $loadSession->get_session();
        $this->user = $getUserData[0];
		$this->salt = "ovancop1234";
		$this->token = str_shuffle('cmsaj23y4ywdni237yeisa');
		$this->date = date('Y-m-d H:i:s');

	}

    function getQuiz($idKursus, $idMateri=1, $start=0, $limit=5, $n_status=1,$debug=0)
    {

        if (!$idKursus) return false;
        // if (!$idMateri) return false;

        $getSoalUser = $this->getSoalUser($idKursus, $idMateri=1);
        
        if ($getSoalUser){
            /*
            $sql = array(
                    'table'=>"banksoal",
                    'field'=>"*",
                    'condition' => " idKursus = {$idKursus} AND idMateri = {$idMateri} AND n_status = {$n_status} ",
                    'limit' => "LIMIT {$start},{$limit}",
                    );
            */
            
            $soal = unserialize($getSoalUser[0]['soal']);
            // pr($soal);exit;
            $implodeID = implode(',', $soal);
            $sql = array(
                    'table'=>"banksoal",
                    'field'=>"*",
                    'condition' => " idGrup_kursus = {$idKursus} AND idSoal IN ({$implodeID}) AND n_status = {$n_status} ",
                    'limit' => "LIMIT {$start},{$limit}",
                    );
            $res = $this->lazyQuery($sql,$debug);
            if ($res) return $res;
        }
        
        return false;
    }

    function randomJawaban($soal=array(), $random=true)
    {

        if (!is_array($soal)) return false;

        $listNo = array('1234');
        $listArray = array();

        if ($random){

            do {
                $leter = substr(str_shuffle($listNo), 0, 1);
                if (!in_array($leter, $listArray)) $listArray[] = $leter;
                $countArray = count($listArray);
                
            } while ($countArray <= 3);

        }else{

            $listArray = array(1,2,3,4);
        }
        
        
        $dataArrSoal = array();

        if ($listArray){
            foreach ($listArray as $key => $value) {
                
                $soal['acakpilihan'][$value] = $soal['pilihan'.$value]; 
            }
        }
        
        return $soal;
    }

    function userAnswer($idKursus, $idMateri=0, $idSoal, $jawabanuser, $idsoalGen=0, $idGrup_kursus=0, $attempt=0, $debug=0)
    {
        
        if (!$idKursus or !$idSoal or !$jawabanuser) return false;

        $goodAnswer = $this->getGoodAnswer($idSoal);
        $jawaban = $goodAnswer[0]['jawaban'];
        $date = date('Y-m-d H:i:s');
        $idUser = $this->user['idUser'];
        $idsoalGenSerial = serialize(array('id_generate_soal'=>$idsoalGen));

        $sql = "INSERT INTO soal (idSoal, idKursus, idMateri, idUser, jawaban, jawabanuser, attempt_date, n_status, keterangan, attempt, idGrup_kursus, soal) 
                VALUES ({$idSoal}, {$idKursus}, {$idMateri}, {$idUser}, '{$jawaban}', '{$jawabanuser}', '{$date}', 1, '{$idsoalGenSerial}', {$attempt}, $idGrup_kursus, {$idsoalGen})
                ON DUPLICATE KEY UPDATE jawabanuser = {$jawabanuser}, keterangan = '{$idsoalGenSerial}'";
        /*
        $sql = array(
                'table'=>"soal ",
                'field'=>"idSoal, idKursus, idMateri, idUser, jawaban, jawabanuser, attempt_date, n_status",
                'value' => "{$idSoal}, {$idKursus}, {$idMateri}, {$idUser}, {$jawaban}, {$jawabanuser}, '{$date}', 1",
                );

        $res = $this->lazyQuery($sql,$debug,1);*/
        // pr($sql);
        $res = $this->query($sql);
        if ($res) return $res;
        return false;
    }

    function getGoodAnswer($idSoal, $n_status=1,$debug=0)
    {
        $sql = array(
                'table'=>"banksoal",
                'field'=>"*",
                'condition' => " idSoal = {$idSoal} AND n_status = {$n_status}",
                'limit' => "LIMIT 1",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function getUserAnswer($idKursus, $idMateri=1, $n_status=1, $attempt=0, $debug=0)
    {

        $idUser = $this->user['idUser'];
        $sql = array(
                'table'=>"soal",
                'field'=>"idSoal, jawabanuser",
                'condition' => " idUser = {$idUser} AND idGrup_kursus = {$idKursus} AND n_status = {$n_status} AND attempt = {$attempt}",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function getSoalUser($idKursus, $idMateri, $n_status=1,$debug=0)
    {
        $idUser = $this->user['idUser'];
        $sql = array(
                'table'=>"tbl_generate_soal",
                'field'=>"soal",
                'condition' => " idUser = {$idUser} AND idGrupKursus = {$idKursus} AND n_status = {$n_status} ORDER BY id DESC LIMIT 1",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function getGenerateSoal($n_status=1,$debug=0)
    {
        $idUser = $this->user['idUser'];
        $sql = array(
                'table'=>"tbl_generate_soal",
                'field'=>"*",
                'condition' => " idUser = {$idUser} AND n_status = {$n_status} ORDER BY id DESC LIMIT 1",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function generateSoal($idKursus, $idMateri=1, $n_status=1, $debug=0)
    {

        $isCourseReady = $this->isCourseReady();

        $idUser = $this->user['idUser'];

        /*
        $sql = array(
                'table'=>"banksoal",
                'field'=>"idSoal",
                'condition' => " idKursus = {$idKursus} AND idMateri = {$idMateri} AND n_status = {$n_status} ORDER BY RAND()",
                );
        */

        $quizLimit = intval($isCourseReady[$idKursus]['jumlahpembagian']);
        $whatCourse = $isCourseReady[$idKursus]['soalkursus'];
        $timeCourse = ($isCourseReady[$idKursus]['waktu'] * 60);

        $sumGroupCOurse = count($whatCourse);
        // pr($isCourseReady);
        if ($whatCourse){

            $i = 1;
            $tmpCount = array();
            foreach ($whatCourse as $key => $value) {
                
                if ($i == $sumGroupCOurse){
                    $jumlahindex = array_sum($tmpCount);
                    $quizLimit = intval($isCourseReady[$idKursus]['maxSoal']) - intval($jumlahindex);

                }
                $sql = array(
                        'table'=>"banksoal",
                        'field'=>"idSoal",
                        'condition' => " idGrup_kursus = {$value['idGrup_kursus']} AND idKursus = {$value['idKursus']} AND n_status = {$n_status} ORDER BY RAND() LIMIT {$quizLimit}",
                        );

                $res[] = $this->lazyQuery($sql,$debug);

                $tmpCount[] = $quizLimit;
                $i++;
            }

            // db($res);
            foreach ($res as $key => $value) {
                
                foreach ($value as $key => $val) {
                    
                    $newRes[] = $val;
                }
            }
        }
        

        // db($newRes);
        $userAttempQuiz = $this->userAttempQuiz();
        // pr($userAttempQuiz);
        $countAttemp = $userAttempQuiz[0]['total']+1;
        if ($newRes){

            foreach ($newRes as $key => $value) {
                $listSoal[] = $value['idSoal'];
            }
            // db($listSoal);

            $starttolerance = strtotime($this->date) + 3; // Add 1 hour
            $tolerancetime = date('Y-m-d H:i:s', $starttolerance); // Back to string

            $counttime = strtotime($tolerancetime) + $timeCourse; // Add 1 hour
            $endtime = date('Y-m-d H:i:s', $counttime); // Back to string
            
            $soal = serialize($listSoal);
            /*
            $sql = "INSERT IGNORE INTO tbl_generate_soal (idKursus, idMateri, idUser, soal, generate_date, start_date, end_date, n_status) 
                    VALUES ({$idKursus}, {$idMateri}, {$idUser}, '{$soal}', '{$this->date}','{$tolerancetime}','{$endtime}', 1)
                    ";
            */
            $sql = "INSERT IGNORE INTO tbl_generate_soal (idGrupKursus, idUser, soal, generate_date, start_date, end_date, attempt, n_status) 
                    VALUES ({$idKursus}, {$idUser}, '{$soal}', '{$this->date}','{$tolerancetime}','{$endtime}', {$countAttemp}, 1)
                    ";

            logFile($sql);        
            // pr($sql);
            // $sql = array(
            //         'table'=>"tbl_generate_soal",
            //         'field'=>"idKursus, idMateri, idUser, soal, generate_date, n_status",
            //         'value' => "{$idKursus}, {$idMateri}, {$idUser}, '{$soal}', '{$this->date}', 1",
            //         );

            $resins = $this->query($sql);
            if ($resins){
                /*
                $sql = array(
                        'table'=>"tbl_generate_soal",
                        'field'=>"id, start_date, end_date",
                        'condition' => " idKursus = {$idKursus} AND idMateri = {$idMateri} AND finish = 0 AND idUser = {$idUser} AND n_status = 1 ORDER BY id DESC LIMIT 1",
                        );
                */
                $sql = array(
                        'table'=>"tbl_generate_soal",
                        'field'=>"id, start_date, end_date, attempt",
                        'condition' => " idGrupKursus = {$idKursus} AND finish = 0 AND idUser = {$idUser} AND n_status = 1 ORDER BY id DESC LIMIT 1",
                        );
                $result = $this->lazyQuery($sql,$debug);
                // pr($result);
                return $result;
            } 
            
        }else{

        } 
        return false;
    }

    function userAttempQuiz()
    {
        $sql = array(
                'table'=>"tbl_generate_soal",
                'field'=>"COUNT(idUser) AS total",
                'condition'=>"idUser = '{$this->user['idUser']}' AND finish = 1",
                );

        $result = $this->lazyQuery($sql,$debug);
        if ($result) return $result;
        return false;
    }

    function updateCountDown($id,$debug=0)
    {
        if (!$id) return false;
        $sql = array(
                'table'=>"tbl_generate_soal",
                'field'=>"finish = 1",
                'condition'=>"id = {$id} AND idUser = '{$this->user['idUser']}' LIMIT 1",
                );

        $result = $this->lazyQuery($sql,$debug,2);
        if ($result) return true;
        return false;
    }

    function getBankSoal($id=false, $idKursus=false, $debug=false){

        $filter = "";
        if ($id) $filter .= " AND idSoal = $id ";
        if ($idKursus) $filter .= " AND idKursus = {$idKursus}";

        $sql = array(
                'table'=>"banksoal",
                'field'=>"*",
                'condition' => " n_status = 1 {$filter} ",
                );
        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
    }

    function getKursus($id=false, $idGroupKursus=false, $debug=0)
    {
        $filter = "";
        if ($id) $filter .= "AND idKursus = {$id}";
        if ($idGroupKursus) $filter .= "AND idGrup_kursus = {$idGroupKursus}";

        $sql = array(
                'table'=>"kursus",
                'field'=>"*",
                'condition'=>"n_status = 1 {$filter}",
                );

        $result = $this->lazyQuery($sql,$debug);
        if ($result) return $result;
        return false;
    }

    function getMateri($id=false, $idKursus=false, $debug=0)
    {
        $filter = "";
        if ($id) $filter .= "AND idMateri = {$id}";
        if ($idKursus) $filter .= "AND idKursus = {$idKursus}";
        
        $sql = array(
                'table'=>"materi",
                'field'=>"*",
                'condition'=>"n_status = 1 {$filter}",
                );

        $result = $this->lazyQuery($sql,$debug);
        if ($result) return $result;
        return false;
    }

    function isUserStartQuiz()
    {
        $idUser = $this->user['idUser'];
        if (!$idUser) return false;
        $sql = array(
                'table'=>"tbl_generate_soal",
                'field'=>"id",
                'condition'=>"finish = 0 AND n_status = 1 AND idUser = {$idUser}",
                );

        $result = $this->lazyQuery($sql,$debug);
        if ($result) return true;
        return false;
    }

    function getDatakursus($id=false, $tabel=0, $cond=false, $n_status= 1, $debug=0)
    {

        if (!$tabel) return false;

        $arrayTabel = array(0=>'grup_kursus', 1=>'kursus', 2=>'materi');
        $arrayFieldTabel = array(0=>'idGrup_kursus', 1=>'idKursus', 2=>'idMateri');

        $filter = "";
        if ($id) $filter .= " AND {$arrayFieldTabel[$tabel]} = $id ";
        if ($cond) $filter .= " AND {$cond}";

        $sql = array(
                'table'=>"{$arrayTabel[$tabel]}",
                'field'=>"*",
                'condition' => " n_status = {$n_status} {$filter} ",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
    }

    function finishQuiz($id=false,$debug=0)
    {

        if (!$id) return false;
        $sql = array(
                'table'=>"tbl_generate_soal",
                'field'=>"finish = 1",
                'condition'=>"id = {$id} AND idUser = '{$this->user['idUser']}' LIMIT 1",
                );

        $result = $this->lazyQuery($sql,$debug,2);
        if ($result) return true;
        return false;
    }

    function correctionAnswer($debug=false)
    {

        $idUser = $this->user['idUser'];
        if (!$idUser) return false;
        $getGenerateSoal = $this->getGenerateSoal();
        // pr($getGenerateSoal);
        $sql = array(
                'table'=>"soal",
                'field'=>"*",
                'condition' => "idUser = {$idUser} AND n_status = 1 AND soal = '{$getGenerateSoal[0]['id']}' ",
                );

        $res = $this->lazyQuery($sql,$debug);
        // pr($res);
        if ($res){

            $correct = array();
            $wrong = array();
            foreach ($res as $key => $value) {
                if ($value['jawaban']==$value['jawabanuser']) $correct[] = $value['idSoal_user'];
                else $wrong[] = $value['idSoal_user'];
            }

            $jumlahSoal = unserialize($getGenerateSoal[0]['soal']);
            // pr(count($res));
            if (count($res) != count($jumlahSoal)){
                $wrong = count($jumlahSoal) - count($correct);

            }else{
                $wrong = count($wrong);
            }
            $idKursus = $res[0]['idKursus'];
            $idGroupKursus = $res[0]['idGrup_kursus'];
            $getQuizSetting = $this->getQuizSetting($idGroupKursus);
            $nilaiminimal = $getQuizSetting[0]['kategoriCukup'];
            $nilai = array('benar'=>count($correct), 'idGroupKursus'=>$idGroupKursus, 'idKursus'=>$idKursus, 'salah'=>$wrong, 'nilaiminimal'=>$nilaiminimal);
            $saveToTable = $this->saveNilai($nilai);


            $data['correct'] = count($correct);
            $data['wrong'] = $wrong;
            $data['rawdata'] = array('correct'=>$correct, 'wrong'=>$wrong);

            return $data;
        }

        return false;
    }

    function getSertificateCode()
    {
        $sql = array(
                'table'=>"nilai",
                'field'=>"*",
                'condition' => " n_status = 1 ORDER BY idNilai DESC LIMIT 1",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function generateSertifikat()
    {

        $arrayTahun = array('2015'=>'XV', '2016'=>'XVI', '2017'=>'XVII', '2018'=>'XVIII');
        $tahun = date('Y');

        $urut = 1;
        $getLastCode = $this->getSertificateCode();
        if ($getLastCode){
            $explodeCode = explode('/', $getLastCode[0]['kodeSertifikat']);
            $newCode = $explodeCode[1]+1;
            $generateCodeSertifikat = "ELS/{$newCode}/{$arrayTahun[$tahun]}";
        }else{
            $generateCodeSertifikat = "ELS/{$urut}/{$arrayTahun[$tahun]}";
        }

        return $generateCodeSertifikat;
    }

    function saveNilai($data, $debug=0)
    {   
        $benar = $data['benar'];
        $salah = $data['salah'];
        $nilai = floor(($benar/($benar+$salah))*100);
        if ($nilai >= $data['nilaiminimal']){
            $statuskelulusan = 1;
            $statusulang = 0;
        }else{
            $statusulang = 1;
            $statuskelulusan = 0;
        }
        
        $create_time = date('Y-m-d H:i:s');
        $idUser = $this->user['idUser'];
        $idKursus = $data['idKursus'];
        $idGroupKursus = $data['idGroupKursus'];

        $generateCodeSertifikat = $this->generateSertifikat();

        $sql = "INSERT INTO nilai (nilai, benar, salah, statusulang, statuskelulusan, create_time, idUser, idKursus, idGroupKursus, kodeSertifikat, n_status) 
                VALUES ({$nilai}, {$benar}, {$salah}, {$statusulang}, {$statuskelulusan}, '{$create_time}', {$idUser}, {$idKursus}, {$idGroupKursus}, '{$generateCodeSertifikat}', 1)
                ON DUPLICATE KEY UPDATE nilai = {$nilai}, benar = '{$benar}', salah = '{$salah}'";
        
        /*
        $sql = array(
                'table'=>"nilai",
                'field'=>"nilai, benar, salah, statusulang, statuskelulusan, create_time, idUser, idKursus, n_status",
                'value' => "{$nilai}, {$benar}, {$salah}, {$statusulang}, {$statuskelulusan}, '{$create_time}', {$idUser}, {$idKursus}, 1",
                );
        */
        $res = $this->query($sql);
        if ($res) return true;
        return false;
    }

    function getQuizSetting($idGroupKursus=false)
    {

        $sql = array(
                'table'=>"tbl_quiz_setting",
                'field'=>"*",
                'condition' => " idGroupKursus = {$idGroupKursus} AND n_status = 1",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function getGrupKursus($idUser){

        $query = "SELECT * FROM grup_kursus WHERE n_status = '1'";
        $result = $this->fetch($query,1);
        foreach ($result as $key => $value) {
            $query = "SELECT COUNT(*) as total FROM kursus WHERE idGrup_kursus = '{$value['idGrup_kursus']}'";
            $res = $this->fetch($query);
            $result[$key]['total'] = $res['total'];
        }
        
        foreach ($result as $key => $value) {
            $query = "SELECT * FROM nilai WHERE idKursus = '{$value['idGrup_kursus']}' AND idUser = '{$idUser['idUser']}'";
            $res = $this->fetch($query);
            if($res){
            // pr($res['nilai']);

            $result[$key]['nilai'] = $res['nilai'];
            }
        }
        return $result;
    }

    function isCourseReady($idGroupKursus=false, $debug=0)
    {

        // SELECT count(*) as jumlah, `idGrup_kursus`, `idKursus` FROM `banksoal` group by idKursus order by idGrup_kursus 
        
        $sql = array(
                'table'=>"banksoal AS b, kursus AS k, grup_kursus AS gk",
                'field'=>"COUNT(b.idSoal) AS jumlahsoal, b.idGrup_kursus, b.idKursus, k.namakursus, k.keterangan, gk.namagrup, k.image",
                'condition' => " b.n_status = 1 GROUP BY b.idKursus ORDER BY b.idGrup_kursus ASC",
                'joinmethod' => 'LEFT JOIN',
                'join' => "b.idKursus = k.idKursus, b.idGrup_kursus = gk.idGrup_kursus"
                );

        $res = $this->lazyQuery($sql,$debug);
        // pr($res);

        if ($res){

            foreach ($res as $key => $value) {
                $getMateri = $this->getMateri(false, $value['idGrup_kursus']);
                $res[$key]['total'] = count($getMateri); 
                // pr($getMateri);
            }

            foreach ($res as $key => $value) {
                $data[$value['idGrup_kursus']][] = $value;
            }

            // pr($data);
            foreach ($data as $key => $value) {
                $tmp = $this->getQuizSetting($key);
                if ($tmp) $getQuizSetting[] = $tmp;
            }

            if ($getQuizSetting){
                foreach ($getQuizSetting as $key => $value) {
                    
                    $dataSetting[$value[0]['idGroupKursus']] = $value[0];
                }
            }
            
            // pr($dataSetting);
            if ($dataSetting){
                foreach ($dataSetting as $key => $value) {
                    $dataSetting[$key]['soalkursus'] = $data[$key];
                    $dataSetting[$key]['jumlahpembagian'] = floor($value['maxSoal'] / count($data[$key]));
                    
                    $notready = array();
                    foreach ($data[$key] as $keys => $val) {
                        if ($val['jumlahsoal'] < $value['maxSoal'] / count($data[$key])) $notready[] = 1;
                    }

                    if ( count($notready) > 0) $dataSetting[$key]['courseready'] = false;
                    else $dataSetting[$key]['courseready'] = true;
                }
            }


            // db($dataSetting);
            return $dataSetting;
        }
        return false;
    }


    function isCourseReady_old($idGroupKursus=false)
    {


        if ($idGroupKursus){

            $getKursus = $this->getKursus(false,$idGroupKursus);
            $countKursus = count($getKursus);
        
            $groupID = array($idGroupKursus);
        
        }else{

            $getGrupKursus = $this->getGrupKursus($this->user['id']);
            if ($getGrupKursus){
                foreach ($getGrupKursus as $key => $value) {
                    $idGrup_kursus[] = $value['idGrup_kursus'];
                    $getKursusTmp = $this->getKursus(false,$value['idGrup_kursus']);
                    if ($getKursusTmp) $getKursusArr[] = $getKursusTmp; 
                }

                if ($getKursusArr){
                    foreach ($getKursusArr as $key => $value) {

                        foreach ($value as $keys => $val) {
                            $getKursus[] = $val;
                        }
                        
                    }
                }
                
            }

            $countKursus = count($getKursus);
            $groupID = $idGrup_kursus;
        }
        
        // db($getKursus);
        foreach ($getKursus as $key => $value) {
            $getBankSoal = $this->getBankSoal(false, $value['idKursus']);
            $getKursus[$key]['jumlahsoal'] = count($getBankSoal);
        }
        
        foreach ($groupID as $key => $value) {
            $getQuizSetting = $this->getQuizSetting($value);
            // db($getQuizSetting);
            if ($getQuizSetting){

                foreach ($getQuizSetting as $key => $val) {
                    $maxSoal = $val['maxSoal'];
                    // pr($maxSoal);
                    // pr($countKursus);
                    $div = ($maxSoal / $countKursus);

                    foreach ($getKursus as $key => $value1) {
                        if ($value1['jumlahsoal'] <= $div){
                            $notAvailable[] = $value;
                        } 
                    }
                }
                
            }
        }
        $notAvailableCourse = array_unique($notAvailable);
        // pr($notAvailableCourse);
        if ($notAvailableCourse)return $notAvailableCourse;
        return false;
    }

    function saveTestimoni($data=array(), $debug=0)
    {

        $dataArr = array();

        $dataArr['testimoni'] = $data['testimoni'];
        $dataArr['status_testimoni'] = 0;

        $serialData = serialize($dataArr);
        $sql = array(
                'table'=>"nilai",
                'field'=>"data = '{$serialData}'",
                'condition' => " idUser = {$data['idUser']} AND idNilai = {$data['idNilai']} LIMIT 1",
                );

        $res = $this->lazyQuery($sql,$debug,2);
        if ($res) return $res;
        return false;
    }

    function getTestimoni($data=array(), $debug=0)
    {

        $sql = array(
                'table'=>"nilai AS n, user AS u",
                'field'=>"n.idNilai, n.data, u.name, u.email, u.jenispekerjaan",
                'condition' => " n.n_status = 1 ",
                'joinmethod' => 'LEFT JOIN',
                'join' => "n.idUser = u.idUser"
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res){
            $newData = array();
            $i = 0;
            foreach ($res as $key => $value) {
                if ($value['data']){
                    $unserial = unserialize($value['data']);
                    if ($unserial['status_testimoni']==1){
                        $newData[$i] = $value;
                        $newData[$i]['testimoni'] = $unserial['testimoni'];
                        $newData[$i]['status_testimoni'] = $unserial['status_testimoni'];
                        $i++;
                    }
                    
                }
            }
            return $newData;
        }
         
        return false;
    }

    function getNilai($id=false, $debug=false)
    {

        $userid = $this->user['idUser'];
        if (!$userid) return false;
        // pr($this->user);
        $sql = array(
                'table'=>"nilai AS n, tbl_quiz_setting AS s",
                'field'=>"n.*, s.kategorikurang",
                'condition' => " n.n_status = 1 AND n.idUser = {$userid} ORDER BY n.idNilai DESC LIMIT 1",
                'joinmethod' => 'LEFT JOIN',
                'join' => 'n.idGroupKursus = s.idGroupKursus'
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function getNilaiByProfile($idNilai=false)
    {
        $filter = "";

        $userid = $this->user['idUser'];

        if ($id) $filter .= " AND n.id = {$idNilai}";
        
        $sql = array(
                'table'=>"nilai AS n, user AS u, grup_kursus AS g",
                'field'=>"n.*, u.name, u.email, g.namagrup",
                'condition' => " n.n_status = 1 AND n.idUser = {$userid} AND statuskelulusan = 1 {$filter}  ORDER BY n.create_time DESC",
                'joinmethod' => 'LEFT JOIN',
                'join' => "n.idUser = u.idUser, n.idGroupKursus = g.idGrup_kursus"
                );

        $res = $this->lazyQuery($sql,$debug);
        // pr($res);
        if ($res) return $res;
        return false;
    }

    function updateStatusNilai($debug=0)
    {

        $getNilai = $this->getNilai();

        $userid = $this->user['idUser'];
        if (!$userid) return false;
        $sql = array(
                'table'=>"nilai",
                'field'=>"n_status = 1",
                'condition' => " idNilai = {$getNilai[0]['idNilai']} AND idUser = {$userid} LIMIT 1",
                );

        $res = $this->lazyQuery($sql,$debug, 2);
        if ($res) return $res;
        return false;
    }

    function isQuizRunning($idGroupKursus=false, $debug=0)
    {

        
        $userid = $this->user['idUser'];
        if (!$userid) return false;
        // pr($this->user);
        $sql = array(
                'table'=>"tbl_generate_soal",
                'field'=>"*",
                'condition' => " n_status = 1 AND idUser = {$userid} AND idGrupKursus = {$idGroupKursus} AND finish = 0 ORDER BY id DESC LIMIT 1",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function hasRead($kursusid=0, $groupid=0, $debug=false)
    {

        $userid = $this->user['idUser'];
        if (!$userid) return false;
        
        $date = date('Y-m-d H:i:s');
        $sql = array(
                'table'=>"tbl_user_activity",
                'field'=>"userid, kursusid, groupid, createdate, n_status",
                'value' => "{$userid}, {$kursusid}, {$groupid}, '{$date}', 1 ",
                );

        $res = $this->lazyQuery($sql,$debug, 1);
        if ($res) return true;
        return false;
    }

    function getHasRead($groupid=0, $kursusid=0, $debug=false)
    {

        $userid = $this->user['idUser'];
        if (!$userid) return false;
        
        $date = date('Y-m-d H:i:s');
        $sql = array(
                'table'=>"tbl_user_activity",
                'field'=>"userid, kursusid, groupid, createdate, n_status",
                'condition' => "userid = {$userid} AND  groupid = {$groupid} AND n_status = 1 ",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function getGroupById($id)
    {
        $sql = "SELECT * FROM grup_kursus WHERE idGrup_kursus = {$id}";
        $res = $this->fetch($sql,0);

        return $res;
    }

}
?>