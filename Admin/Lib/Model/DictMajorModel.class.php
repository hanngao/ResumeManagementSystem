<?php
class DictMajorModel extends Model {

	public function getMajorId($major_name)
	{
		$major_id = $this->where(" major_name = '{$major_name}' ")->getField('major_id');

		if(is_null($major_id))
		{
			$data = array();
			$data['major_name'] = $major_name;
			$data['hot'] = 1;
			$major_id = $this->add($data);
		}

		return $major_id;
	}
	
	public function getMajorName($major_id)
	{
		$major_name = $this->where(" major_id = '{$major_id}' ")->getField('major_name');
		return $major_name;
	}

}
?>