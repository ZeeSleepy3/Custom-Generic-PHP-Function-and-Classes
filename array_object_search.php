<?php 
require_once('is_assoc.php');


/**
 * [array_objects_search]
 * Case sensitive by default
 * @param  $property_needles
 *         associative array
 *         associative array of key => value to be search for
 * @param  $haystack 
 *         non-associative array of objects
 *         non-associative array of objects to be searched through
 * @param  $options
 *         array of integers
 *         CASE_INSENSITIVE: Case insensitive comparison
 * @return boolean or non-associative array of matching objects
 */
define('CASE_INSENSITIVE', 1);
function array_object_search($property_needles, $haystack, $options=array()) {
	

	/* VALIDATION FOR FIRST ARGUMENT */
	if(!is_assoc($property_needles)) {
		throw new InvalidArgumentException('array_object_search funtion only accepts an associative array for first argument.');
	}

	/* VALIDATION FOR SECOND ARGUMENT */
	if(!is_array($haystack) || is_assoc($haystack)) {
		throw new InvalidArgumentException('array_object_search funtion only accepts a non-associative array of objects for second argument.');
	}
	foreach($haystack as $item) {
		if(gettype($item) != 'object') {
			throw new InvalidArgumentException('array_object_search funtion only accepts a non-associative array of objects for second argument.');
		}
	}

	/* VALIDATION FOR THIRD ARGUMENT */
	if(is_array($options) && !is_assoc($options)) {
		foreach($options as $item) {
			if(gettype($item) != 'integer') {
				throw new InvalidArgumentException('array_object_search funtion only accepts an integer or a non-associative array of integers for third argument.');
			}
		}
	}
	else if(is_int($options)) {
		$options = array($options);
	}
	else {
		throw new InvalidArgumentException('array_object_search funtion only accepts an integer or a non-associative array of integers for third argument.');
	}

	/* VALID OPTIONS */
	$accepted_options = array(CASE_INSENSITIVE);
	$valid_options = array();
	if(!empty($options)) {
		$valid_options = array_intersect($accepted_options, $options);
	}




	$matching_objects = array();

	foreach($haystack as $obj) {
		$reflector = new ReflectionClass(get_class($obj));
		$skip_object = false;

		foreach($property_needles as $key => $value) {
			/* CHECK IF METHOD HAS PROPERTY */
			if(!property_exists($obj, $key)) {
				$skip_object = true;
				break;
			}

			/* CHECK IF PROPERTY IS PUBLIC */
			/* IF NOT, TRY TO FIND THE GETTER METHOD */
			$obj_property_value = '';
			if($reflector->getProperty($key)->isPublic() || is_callable(array($obj, '__get'))) {
				/*method_exists($obj,'__get')*/
				$obj_property_value = $obj->$key;
			}
			else {
				$get_method_name = 'get'.ucfirst($key);
				if(!method_exists($obj, $get_method_name)) {
					$skip_object = true;
					break;
				}
				$obj_property_value = call_user_func(array($obj, $get_method_name));
			}
			
			/* COMPARISON OPTIONS */
			if(in_array(CASE_INSENSITIVE, $valid_options)) {
				$obj_property_value = strtolower($obj_property_value);
				$value = strtolower($value);
			}

			/* CHECK IF PROPERTY EQUALS REQUIREMENT VALUE */
			if($obj_property_value != $value) {
				$skip_object = true;
				break;
			}
			
		}
		if(!$skip_object) {
			$matching_objects[] = $obj;
		}
	}


	if($matching_objects) {
		return $matching_objects;
	}

	return false;
}



?>