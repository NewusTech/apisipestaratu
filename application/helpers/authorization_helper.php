<?php

class AUTHORIZATION
{
    public static function validateToken($token)
    {
        $CI =& get_instance();
      $jwt = JWT::decode($token, $CI->config->item('jwt_key'));
      print_r($jwt);
      exit();
        return $jwt;
    }

    public static function generateToken($data)
    {
        $CI =& get_instance();
        return JWT::encode($data, $CI->config->item('jwt_key'));
    }

	public static function tokenIsExist($headers)
    {
		if((array_key_exists('authorization', $headers) && !empty($headers['authorization']))) {
			return true;
		}
		if((array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))) {
			return true;
		}
		return false;
    }

    public static function generate_id ($len = 10)
	{
		$chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
			'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
			'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
		);
		shuffle($chars);
		$num_chars = count($chars) - 1;
		$id = '';
		for ($i = 0; $i < $len; $i++)
		{
			$id .= $chars[mt_rand(0, $num_chars)];
		}
		return $id;
	}

}