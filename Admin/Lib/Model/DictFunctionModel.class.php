<?php
class DictFunctionModel extends Model {

	public function getFunctionId($function_name)
	{
		$function_id = $this->where(" function_name = '{$function_name}' ")->getField('function_id');

		if(is_null($function_id))
		{
			$data = array();
			$data['function_name'] = $function_name;
			$function_id = $this->add($data);
		}

		return $function_id;
	}
	
	public function getFunctionName($function_id)
	{
		$function_name = $this->where(" function_id = '{$function_id}' ")->getField('function_name');
		return $function_name;
	}
}
?>