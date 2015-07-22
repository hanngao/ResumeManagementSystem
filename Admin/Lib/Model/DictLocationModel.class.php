<?php
class DictLocationModel extends Model {

	public function getLocationId($location_name)
	{
		if(strpos($location_name, '-'))
		{
			$location_name = explode('-', $location_name);
			
			$location_pid = $this->where(" location_name = '{$location_name[0]}' ")->getField('location_id');
	
			if(is_null($location_pid))
			{
				$data = array();
				$data['location_pid'] = 0;
				$data['location_name'] = $location_name[0];
				$location_pid = $this->add($data);
			}
			
			$location_id = $this->where(" location_name = '{$location_name[1]}' AND location_pid = '{$location_pid}' ")->getField('location_id');

			if(is_null($location_id))
			{
				$data = array();
				$data['location_pid'] = $location_pid;
				$data['location_name'] = $location_name[1];
				$location_id = $this->add($data);
			}
				
		}else{
			$location_id = $this->where(" location_name = '{$location_name}' ")->getField('location_id');
	
			if(is_null($location_id))
			{
				$data = array();
				$data['location_pid'] = 0;
				$data['location_name'] = $location_name;
				$location_id = $this->add($data);
			}
		}
		
		return $location_id;
	}
	
	public function getLocationName($location_id)
	{
		$locationData = $this->where(" location_id = '{$location_id}' ")->find();

		if($locationData['location_pid'] == 0)
		{
			$location_name = $locationData['location_name'];
		}else{
			
			$pName = $this->where(" location_id = '{$locationData['location_pid']}' ")->getField('location_name');
			
			$location_name = $pName.'-'.$locationData['location_name'];
		}

		return $location_name;
	}
}
?>