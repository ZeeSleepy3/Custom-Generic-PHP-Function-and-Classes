<?php 
require_once('../NumberAbbreviator.php');

class NumberAbbreviatorTest extends PHPUnit_Framework_TestCase {
	public $numberAbbreviator;

	public function setUp() {
	    $this->numberAbbreviator = new NumberAbbreviator();
	}

	public function tearDown() {
	    unset($this->numberAbbreviator);
	}

	public function testSetNumber() {
		$this->numberAbbreviator->setNumber(2000);
		$expected = '2000';
		$this->assertTrue($this->numberAbbreviator->getNumber() == $expected);
	}

	public function testSetNumberString() {
		$this->numberAbbreviator->setNumber('2000');
		$expected = '2000';
		$this->assertTrue($this->numberAbbreviator->getNumber() == $expected);
	}

	public function testSetNumberWithComma() {
		$this->numberAbbreviator->setNumber('2,000');
		$expected = '2000';
		$this->assertTrue($this->numberAbbreviator->getNumber() == $expected);
	}

	public function testAbbreviateNumberOne() {
		$this->numberAbbreviator->setNumber('2000');
		$expected = '2K';
		$this->assertTrue($this->numberAbbreviator->abbreviateNumber() == $expected);
	}

	public function testAbbreviateNumberTwo() {
		$this->numberAbbreviator->setNumber('20,000');
		$expected = '20K';
		$this->assertTrue($this->numberAbbreviator->abbreviateNumber() == $expected);
	}

	public function testAbbreviateNumberThree() {
		$this->numberAbbreviator->setNumber('200,000,000');
		$expected = '200M';
		$this->assertTrue($this->numberAbbreviator->abbreviateNumber() == $expected);
	}

	public function testAbbreviateNumberThreeDecmialPlaces() {
		$this->numberAbbreviator->setNumber('200,123,000');
		$expected = '200.123M';
		$this->assertTrue($this->numberAbbreviator->abbreviateNumber(3) == $expected);
	}

	public function testAbbreviateNumberTwoDecmialPlaces() {
		$this->numberAbbreviator->setNumber('2,123');
		$expected = '2.12K';
		$this->assertTrue($this->numberAbbreviator->abbreviateNumber(2) == $expected);
	}

	public function testAbbreviateNumberDecmialBreak() {
		$this->numberAbbreviator->setNumber('2,123');
		$expected = '2.123K';

		echo "\n";
		echo 'abbreviateNumber: '.$this->numberAbbreviator->abbreviateNumber(6);
		echo "\n";

		$this->assertTrue($this->numberAbbreviator->abbreviateNumber(6) == $expected);
	}
}
?>