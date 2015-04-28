<?php
class marticle extends Database {
	
	var $prefix = "lelang";
	
	function article_inp($data)
	{
		
		$date = date('Y-m-d H:i:s');
		$datetime = array();

		$content = array(
					'description'=>addslashes($data['isi']),
					'additional'=>addslashes($data['additional']),
					'review'=>addslashes($data['review']),
					'size'=>$data['size'],
					'quantity'=>$data['quantity'],
					'category'=>$data['category'],
					'color'=>$data['color'],
					);

		$data['content'] = serialize($content);
		$data['title'] = addslashes($data['title']);
		$data['brief'] = addslashes($data['brief']);

		if(!empty($data['postdate'])) $data['postdate'] = date("Y-m-d",strtotime($data['postdate'])); 
		


		if($data['action'] == 'insert'){
			
			$query = "INSERT INTO  
						{$this->prefix}_news_content (title,brief,content,image,file,articletype,
												created_date,posted_date,authorid,n_status,topcontent,slider_image)
					VALUES
						('".$data['title']."','".$data['brief']."','".$data['content']."','".$data['image']."'

							,'".$data['image_url']."','".$data['articletype']."','".$date."','".$data['postdate']."'
							,'".$data['authorid']."','".$data['n_status']."','".$data['topcontent']."','".$data['slider_image']."')";

		} else {

			if ($data['image']){

				$query = "UPDATE {$this->prefix}_news_content
						SET 
							title = '{$data['title']}',
							brief = '{$data['brief']}',
							content = '{$data['content']}',
							image = '{$data['image']}',
							file = '{$data['image_url']}',
							posted_date = '".$date."',
							articleType = {$data['articletype']},
							topcontent = {$data['topcontent']},
							slider_image = {$data['slider_image']},
							authorid = '{$data['authorid']}',
							n_status = {$data['n_status']}
						WHERE
							id = '{$data['id']}'";
			}else{
				$query = "UPDATE {$this->prefix}_news_content
						SET 
							title = '{$data['title']}',
							brief = '{$data['brief']}',
							content = '{$data['content']}',
							posted_date = '".$date."',
							articleType = {$data['articletype']},
							topcontent = {$data['topcontent']},
							slider_image = {$data['slider_image']},
							authorid = '{$data['authorid']}',
							n_status = {$data['n_status']}
						WHERE
							id = '{$data['id']}'";
			}
			
		}
// pr($query);
		$result = $this->query($query);
		
		return $result;
	}
	
	function get_article($type=1)
	{
		$query = "SELECT * FROM {$this->prefix}_news_content WHERE articleType  IN (1,2,3) AND n_status = '1' OR n_status = '0'  ORDER BY created_date DESC";
		// pr($query);
		$result = $this->fetch($query,1);

		foreach ($result as $key => $value) {
			$query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";

			$username = $this->fetch($query,0);

			$result[$key]['username'] = $username['username'];
		}
		
		return $result;
	}
	
	function get_article_slide()
	{
		$query = "SELECT nc.*, cc.category, ct.type FROM cdc_news_content nc LEFT JOIN cdc_news_content_category cc 
					ON nc.categoryid = cc.id LEFT JOIN cdc_news_content_type ct ON nc.articletype = ct.id 
					WHERE nc.n_status < 2 AND nc.articletype > 0  ORDER BY nc.createdate DESC";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function get_article_trash()
	{
		$query = "SELECT * FROM {$this->prefix}_news_content WHERE n_status = '2' ORDER BY created_date DESC";
		
		$result = $this->fetch($query,1);

		foreach ($result as $key => $value) {
			$query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";

			$username = $this->fetch($query,0);

			$result[$key]['username'] = $username['username'];
		}
		
		return $result;
	}
	
	function article_del($id)
	{
		foreach ($id as $key => $value) {
			
			$query = "UPDATE {$this->prefix}_news_content SET n_status = '2' WHERE id = '{$value}'";
		
			$result = $this->query($query);
		
		}

		return true;
		
	}
	
	function article_delpermanent($id)
	{
		$query = "DELETE FROM cdc_news_content WHERE id = '{$id}'";
		
		$result = $this->query($query);
		
		return $result;
		
	}
	
	function article_restore($id)
	{
		foreach ($id as $key => $value) {
			
			$query = "UPDATE {$this->prefix}_news_content SET n_status = '0' WHERE id = '{$value}'";
		
			$result = $this->query($query);
		
		}

		return true;
		
	}
	
	function get_article_id($data)
	{
		$query = "SELECT * FROM {$this->prefix}_news_content WHERE id= {$data} LIMIT 1";
		
		$result = $this->fetch($query,0);

		if($result['posted_date'] != '') $result['posted_date'] = dateFormat($result['posted_date'],'dd-mm-yyyy');
		($result['n_status'] == 1) ? $result['n_status'] = 'checked' : $result['n_status'] = '';
		($result['topcontent'] == 1) ? $result['topcontent'] = 'checked' : $result['topcontent'] = '';
		($result['slider_image'] == 1) ? $result['slider_image'] = 'checked' : $result['slider_image'] = '';

		return $result;
	}
	
	function frame_inp($data){

		foreach ($data[0] as $key => $val) {
			$tmpfield[] = $key;
			$tmpvalue[] = "'$val'";
		}

		$field = implode(',', $tmpfield);
		$value = implode(',', $tmpvalue);

		$query = "INSERT INTO {$this->prefix}_news_content_repo ({$field}) VALUES ($value)";

		$result = $this->query($query);

		$queryid = "SELECT id FROM {$this->prefix}_news_content_repo ORDER BY created_date DESC LIMIT 1";

		$id = $this->fetch($queryid,0);

		$data[1]['otherid'] = $id['id'];

		foreach ($data[1] as $key => $val) {
			$tmpfield2[] = $key;
			$tmpvalue2[] = "'$val'";
		}

		$field2 = implode(',', $tmpfield2);
		$value2 = implode(',', $tmpvalue2);

		$query2= "INSERT INTO {$this->prefix}_news_content_repo ({$field2}) VALUES ($value2)";

		$result = $this->query($query2);
		return true;
	}

	function get_frameList(){

		global $CONFIG;

		$query = "SELECT * FROM {$this->prefix}_news_content_repo WHERE gallerytype = 1 AND n_status = 1 ORDER BY created_date DESC";

		$result = $this->fetch($query,1);

		foreach ($result as $key => $val) {
			$query = "SELECT * FROM {$this->prefix}_news_content_repo WHERE gallerytype = 2 AND n_status = 1 AND otherid = {$val['id']} LIMIT 1";
			$res = $this->fetch($query,0);
			$result[$key]['cover'] = $res['files'];
			$result[$key]['covername'] = $res['title'];

			//typealbum
			if($val['typealbum'] == 4){
				$result[$key]['typealbum'] = 'Facebook';
			} elseif ($val['typealbum'] == 5) {
				$result[$key]['typealbum'] = 'Twitter';
			}
			
			//dimension
			list($result[$key]['frWidth'], $result[$key]['frHeight'], $type, $attr) = @getimagesize($CONFIG['admin']['upload_path']."frame/".$result[$key]['files']);
			list($result[$key]['covWidth'], $result[$key]['covHeight'], $type, $attr) = @getimagesize($CONFIG['admin']['upload_path']."cover/".$res['files']);
		}

		return $result;
	}

	function updateStatusFrame($id=false,$n_status=0)
	{
		if (!$id) return false;


		$query2= "UPDATE {$this->prefix}_news_content_repo SET n_status = {$n_status} WHERE id = {$id} LIMIT 1";

		$result = $this->query($query2);
		if ($result) return true;
		return false;

	}

	function getContent($type=1)
	{
		$query = "SELECT * FROM {$this->prefix}_news_content WHERE articletype = {$type} ";
		
		$result = $this->fetch($query,1);
		if ($result) return $result;
		return false;
	}
}
?>