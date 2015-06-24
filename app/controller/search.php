<?php

class search extends Controller {
	
	var $models = FALSE;
	var $view;

	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$getUserLogin = $this->isUserOnline();
		$this->user = $getUserLogin[0];
		$this->view->assign('basedomain',$basedomain);
    }
	
	function loadmodule()
	{
        $this->models = $this->loadModel('mkursus');
        $this->quizHelper = $this->loadModel('quizHelper');
	}
	
	
     function index(){
		
		if(isset($_POST['cari'])){
			$certificate = $_POST['cari'];
			$group_course = $this->models->get_group_by_certificate($certificate);
			$id_group = $group_course['idGrup_kursus'];
			// pr($group_course);
			if($id_group != ''){
				$list_course = $this->models->get_list_course_by_certificate($id_group);
				// pr($list_course);
				$nilai = $this->models->get_value_by_certificate($id_group);
				// pr($nilai);
				$this->view->assign('group_course',$group_course);
				$this->view->assign('list_course',$list_course);
				$this->view->assign('nilai',$nilai);
				$this->view->assign('keyword',$certificate);
				return $this->loadView('kursus/page_search');
			}else{
				return $this->loadView('kursus/page_search');
			}
			
		}else{
			// echo "no post";
			return $this->loadView('kursus/page_search');
		
		}
		

    }

}

?>
