<?php

class home extends Controller {
	
	var $models = FALSE;
	var $view;

	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
    }
	
	function loadmodule()
	{
        $this->contentHelper = $this->loadModel('contentHelper');
	}
	
	function index(){
		
		$getTopContent = $this->contentHelper->getArticle(false, array('topcontent'=>true));
		$getSlider = $this->contentHelper->getArticle(false, array('slider'=>true));
		$getOtherProduct = $this->contentHelper->getArticle(false, array('random'=>true));
		$getProduk = $this->contentHelper->getArticle();
		
		// pr($getSlider);

		$this->view->assign('topcontent', $getTopContent[0]);
		$this->view->assign('slider', $getSlider);
		$this->view->assign('produk', $getProduk);
		$this->view->assign('otherproduct', $getOtherProduct);

    	return $this->loadView('home');
    }

    function detail(){
		
		

    	return $this->loadView('paket/detail');
    }
    function categori(){
		
		
    	return $this->loadView('paket/categori-paket');
    }
}

?>
