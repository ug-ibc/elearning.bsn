<?php
class mpage extends Database {
	
	function page_inp($data)
	{
		
		$data['title'] = cleanText($data['title']);
		$data['brief'] = cleanText($data['brief']);
		$data['content'] = cleanText($data['content']);
		
		
		$date = date('Y-m-d H:i:s');
		$datetime = array();
		if(!empty($data['expiredate'])) $data['expiredate'] = date("Y-m-d",strtotime($data['expiredate'])); 

		if($data['action'] == 'insert'){
			$query = "INSERT INTO  
						cdc_news_content (title,brief,content,image,thumbnailimage,categoryid,articletype,
											tags,createdate,postdate,expiredate,fromwho,authorid,n_status)
					VALUES
						('".$data['title']."','".$data['brief']."','".$data['content']."','".$data['image']."','".$data['thumbnailimage']."','".

							$data['categoryid']."','".$data['articletype']."','".$data['tags']."','".$date."','".date("Y-m-d",strtotime($data['postdate']))."','".
							$data['expiredate']."','".$_SESSION['admin']['usertype']."','".$_SESSION['admin']['id']."',{$data['status']})";

		} else {
			$query = "UPDATE cdc_news_content
						SET 
							title = '{$data['title']}',
							brief = '{$data['brief']}',
							content = '{$data['content']}',
							image = '{$data['image']}',
							thumbnailimage = '{$data['thumbnailimage']}',
							categoryid = '{$data['categoryid']}',
							articletype = '{$data['articletype']}',
							tags = '{$data['tags']}',
							postdate = '".date("Y-m-d",strtotime($data['postdate']))."',
							expiredate = '".$data['expiredate']."',
							fromwho = '{$_SESSION['admin']['usertype']}',
							authorid = '{$_SESSION['admin']['id']}',
							n_status = {$data['status']}
						WHERE
							id = '{$data['id']}'";
		}
// pr($query);
		$result = $this->query($query);
		
		return $result;
	}
	
	function get_page_id($data)
	{
		$query = "SELECT * FROM cdc_news_content WHERE categoryid= {$data}";
		
		$result = $this->fetch($query,1);
		
		if(isset($result[0]['postdate'])){
			$result[0]['postdate'] = date('d-m-Y',strtotime($result[0]['postdate']));
		}
		if(isset($result[0]['expiredate'])){
			$result[0]['expiredate'] = date('d-m-Y',strtotime($result[0]['expiredate']));
		}

		return $result;
	}
	
	function get_ads_list($category=6){
		$query = "SELECT * FROM cdc_ads WHERE category = {$category}";
		
		$result = $this->fetch($query,1);
		
		return $result;
	
	}
	
	function get_ads_type($id=false){
		
		$filter = "";
		if ($id) $filter = " AND id = {$id}";
		else $filter = " AND id > 1";
		$query = "SELECT * FROM cdc_news_content_type WHERE n_status=1 {$filter}";
		// pr($query);
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function get_ads_type_all(){
		$query = "SELECT * FROM cdc_news_content_type WHERE id > 1";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function ads_inp($data)
	{
		$date = date('Y-m-d H:i:s');

		if($data['action'] == 'insert'){
			$query = "INSERT INTO  
						cdc_ads (title,source,image,category,type,expire_date,
											link,post_date,payment, n_status)
					VALUES ('{$data['title']}',
						'{$data['source']}',
						'{$data['image']}',
						6,
						'{$data['articletype']}',
						'".date("Y-m-d",strtotime($data['expiredate']))."',
						'{$data['tags']}',
						'".date("Y-m-d",strtotime($data['postdate']))."',
						'{$data['payment']}',
						'{$data['n_status']}')";

		} else {
			$payment = intval($data['payment']);
			if ($payment > 0){
				$updatePayment = ", payment = '{$payment}'";
			}
			
			$query = "UPDATE cdc_ads
						SET 
							title = '{$data['title']}',
							source = '{$data['source']}',
							expire_date = '".date("Y-m-d",strtotime($data['expiredate']))."',
							image = '{$data['image']}',
							type = '{$data['articletype']}',
							link = '{$data['tags']}',
							post_date = '".date("Y-m-d",strtotime($data['postdate']))."',
							n_status = {$data['n_status']}
							{$updatePayment}
						WHERE
							id = '{$data['id']}'";
		}
			
		$result = $this->query($query);
		
		return $result;
	}
	
	function upd_type($new,$old){
		//change old status
		$query = "UPDATE cdc_news_content_type SET n_status=1 WHERE type='{$old}'";
		
		$result = $this->query($query);
	
		//set new status
		$query = "UPDATE cdc_news_content_type SET n_status=0 WHERE type='{$new}'";
		
		$result = $this->query($query);
	}
	
	function del_ads($id){
		$query_del = "DELETE FROM cdc_ads WHERE id={$id}";
		$result = $this->query($query_del);
		
		return $result;
	}
	
	function get_ads_id($id){
		// $query_get = "SELECT cc.*, ct.value FROM cdc_news_content cc LEFT JOIN cdc_news_content_type ct ON cc.articletype = ct.type WHERE cc.id={$id}";
		$query_get = "SELECT * FROM cdc_ads WHERE id={$id}";
		// pr($query_get);
		$result = $this->fetch($query_get,1);
		return $result;
	}
}
?>