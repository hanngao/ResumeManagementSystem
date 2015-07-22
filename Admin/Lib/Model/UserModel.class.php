<?php
class UserModel extends Model {

	public function hasUserByMd5($resumemd5)
	{
		$uid = $this->where(" resumemd5 = '{$resumemd5}' ")->getField('uid');
		
		return is_null($uid) ? true : false; 
	}
}
?>