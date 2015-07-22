<?php
class KeywordModel extends Model {

	public function getKeywordId($keyword)
	{
		$id = $this->where(" keyword = '{$keyword}' ")->getField('id');

		if(is_null($id))
		{
			$data = array();
			$data['keyword'] = $keyword;
			$data['hot'] = 1;
			$id = $this->add($data);
		}else{
			$this->where(" keyword = '{$keyword}' ")->setInc('hot');
		}

		return $id;
	}
	
}
?>