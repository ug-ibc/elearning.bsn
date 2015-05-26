<?php

class paket extends Controller {
	
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
        $this->biddingHelper = $this->loadModel('biddingHelper');
	}
	
	function index(){
		
		
		$testBidd = $this->biddingHelper->isMemberAllowToBidding(false);


    	return $this->loadView('paket/detail');
    }

    function detail(){
		
		$id = _g('id');
    	$getProduk = $this->contentHelper->getArticle($id);
    	if ($getProduk){
    		$content = unserialize($getProduk[0]['content']);
    		$category = explode(',', $content['category']);
    		$color = explode(',', $content['color']);
    		$content['category'] = $category;
    		$content['color'] = $color;
    		$data = $getProduk[0];
    		$data['data'] = $content;
    	}


		// pr($data);

		$this->view->assign('paket', $data);
    	return $this->loadView('paket/detail');
    }
    function register(){
		
		

    	return $this->loadView('register');
    }

    function batik(){
		
		
    	$getSlider = $this->contentHelper->getArticle(false, array('type'=>1));
    	// pr($getSlider);
    	if ($getSlider){

    		$no = 1;
    		foreach ($getSlider as $key => $value) {

    			if ($no ==1){
	    			$content = unserialize($value['content']);
		    		$category = explode(',', $content['category']);
		    		$color = explode(',', $content['color']);
		    		$content['category'] = $category;
		    		$content['color'] = $color;
		    		$topcontent = $value;
		    		$topcontent['data'] = $content;

	    		}else{
	    			$content = unserialize($value['content']);
		    		$category = explode(',', $content['category']);
		    		$color = explode(',', $content['color']);
		    		$content['category'] = $category;
		    		$content['color'] = $color;
		    		$data = $value;
		    		$data['data'] = $content;
		    		$paket[] = $data;
	    		}

	    		$no++;
    		}


    	}

    	$getProductSold = $this->contentHelper->getArticle(false, array('sold'=>2, 'type'=>1));

    	// pr($getProductSold);
    	// pr($paket);
    	$this->view->assign('topcontent', $topcontent);
    	$this->view->assign('sold', $getProductSold);
    	$this->view->assign('paket', $getSlider);

    	return $this->loadView('paket/batik');
    }

    function busana(){
		
		
    	$getSlider = $this->contentHelper->getArticle(false, array('type'=>2));
    	// pr($getSlider);
    	if ($getSlider){

    		$no = 1;
    		foreach ($getSlider as $key => $value) {

    			if ($no ==1){
	    			$content = unserialize($value['content']);
		    		$category = explode(',', $content['category']);
		    		$color = explode(',', $content['color']);
		    		$content['category'] = $category;
		    		$content['color'] = $color;
		    		$topcontent = $value;
		    		$topcontent['data'] = $content;

	    		}else{
	    			$content = unserialize($value['content']);
		    		$category = explode(',', $content['category']);
		    		$color = explode(',', $content['color']);
		    		$content['category'] = $category;
		    		$content['color'] = $color;
		    		$data = $value;
		    		$data['data'] = $content;
		    		$paket[] = $data;
	    		}

	    		$no++;
    		}


    	}

    	$getProductSold = $this->contentHelper->getArticle(false, array('sold'=>2, 'type'=>2));

    	// pr($getProductSold);
    	// pr($paket);
    	$this->view->assign('topcontent', $topcontent);
    	$this->view->assign('sold', $getProductSold);
    	$this->view->assign('paket', $getSlider);

    	return $this->loadView('paket/batik');
    }

    function gamis(){
		
		$getSlider = $this->contentHelper->getArticle(false, array('type'=>3));
    	// pr($getSlider);
    	if ($getSlider){

    		$no = 1;
    		foreach ($getSlider as $key => $value) {

    			if ($no ==1){
	    			$content = unserialize($value['content']);
		    		$category = explode(',', $content['category']);
		    		$color = explode(',', $content['color']);
		    		$content['category'] = $category;
		    		$content['color'] = $color;
		    		$topcontent = $value;
		    		$topcontent['data'] = $content;

	    		}else{
	    			$content = unserialize($value['content']);
		    		$category = explode(',', $content['category']);
		    		$color = explode(',', $content['color']);
		    		$content['category'] = $category;
		    		$content['color'] = $color;
		    		$data = $value;
		    		$data['data'] = $content;
		    		$paket[] = $data;
	    		}

	    		$no++;
    		}


    	}

    	$getProductSold = $this->contentHelper->getArticle(false, array('sold'=>2, 'type'=>3));

    	// pr($getProductSold);
    	// pr($paket);
    	$this->view->assign('topcontent', $topcontent);
    	$this->view->assign('sold', $getProductSold);
    	$this->view->assign('paket', $getSlider);

    	return $this->loadView('paket/batik');
    }
}

?>
