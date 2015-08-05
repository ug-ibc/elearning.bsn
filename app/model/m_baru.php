<?php
class m_baru extends Database {

	function select($where)
	{

	}

	function get_user($data)
	{
		$username = clean($data['username']);

		$sql = "SELECT * FROM user where username = '{$data['username']}' AND password = '{$data['password']}' LIMIT 1";

        $res = $this->fetch($sql);
        if($res)
        {
        	return $res;
        }
        else
        {
        	return FALSE;
        }
	}

	/**
     * @todo create session after success login
     * 
     * @param $data = userdata(id,name,email,twitter,website,phone)
     */
	function setSession($data=false)
	{

        $session = new Session;

        if($data==false) return false;
		// store session data
        $dataSession = array(
                'id' => $data['idUser'],
                'name' => $data['name'],
                'email' => $data['email'],
                'username' => $data['username']
            );

        // set session, parameternya (data sessi, nama sessinya)
        $session->set_session($dataSession, 'login');
	}

}
?>