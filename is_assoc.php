<?php 

/**
 * [is_assoc]
 * @param  $array 
 *         array
 *         array to be tested
 * @return boolean
 */
function is_assoc($array) {
 	return (bool)count(array_filter(array_keys($array), 'is_string'));
}

?>