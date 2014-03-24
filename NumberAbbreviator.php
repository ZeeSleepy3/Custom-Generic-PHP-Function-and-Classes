<?php 

class NumberAbbreviator {

	protected $number;
	protected $abbreviations = array('K', 'M', 'B', 'T');

	public function __construct() {
		
	}

	public function setNumber($number) {
		$number = is_string($number) ? str_replace(',', '', $number) : strval($number);

		if(!is_numeric($number)) {
			throw new Exception(get_class($this).' requires a number.');
		}
		$this->number = $number;
	}

	public function getNumber() {
		return $this->number;
	}
	

	public function abbreviateNumber($decPlaces = 0) {
		$len = strlen($this->number);
		$array_pos = intval(($len - 1) / 3) - 1;
		$preDec_pos = $len % 3;
		$preDec_pos = ($preDec_pos == 0) ? 3 : $preDec_pos;

		$abbv_char = $this->abbreviations[$array_pos];
		$abbv_number = substr($this->number, 0, $preDec_pos + $decPlaces);
		if($decPlaces) {
			$abbv_number = substr_replace($abbv_number, '.', $preDec_pos, 0);
		}

		return $abbv_number . $abbv_char;
	}

}

?>