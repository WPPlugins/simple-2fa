<?php
/**
 * @filesource   Base32Test.php
 * @created      29.02.2016
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\Base32Test;

use chillerlan\Base32\Base32;
use chillerlan\Base32\Base32Characters;

class Base32Test extends \PHPUnit_Framework_TestCase{

	protected function setUp(){
		Base32::setCharset();
	}

	public function testSetCharset(){
		Base32::setCharset(Base32Characters::CROCKFORD);
		$this->assertEquals(Base32Characters::CROCKFORD, Base32::$charset);
	}

	public function testToStringCrockfordCoverage(){
		Base32::setCharset(Base32Characters::CROCKFORD);
		$this->assertEquals('0123456789ABCDEFGHJKMNPQRSTVWXYZ', Base32::toString('6ORK4CSM6MV3EEIS85L46H258S3MGJJB9N750MAJADA5CNTRB5D0'));
	}

	public function base32DataProvider(){
		return [
			['a',                                                       '01100001', 'ME'          ],
			['ab',                                              '0110000101100010', 'MFRA'        ],
			['abc',                                     '011000010110001001100011', 'MFRGG'       ],
			['abcd',                            '01100001011000100110001101100100', 'MFRGGZA'     ],
			['abcde',                   '0110000101100010011000110110010001100101', 'MFRGGZDF'    ],
			['abcdef',          '011000010110001001100011011001000110010101100110', 'MFRGGZDFMY'  ],
			['abcdefg', '01100001011000100110001101100100011001010110011001100111', 'MFRGGZDFMZTQ'],
		];
	}

	/**
	 * @dataProvider base32DataProvider
	 */
	public function testStr2Bin($str, $bin){
		$this->assertEquals($bin, Base32::str2bin($str));
	}

	/**
	 * @dataProvider base32DataProvider
	 */
	public function testBin2Str($str, $bin){
		$this->assertEquals($str, Base32::bin2str($bin));
	}

	/**
	 * @dataProvider base32DataProvider
	 */
	public function testFromBin($str, $bin, $base32){
		$this->assertEquals($base32, Base32::fromBin($bin));
	}

	/**
	 * @dataProvider base32DataProvider
	 */
	public function testToBin($str, $bin, $base32){
		$this->assertEquals($bin, Base32::toBin($base32));
	}

	/**
	 * @dataProvider base32DataProvider
	 */
	public function testFromString($str, $bin, $base32){
		$this->assertEquals($base32, Base32::fromString($str));
	}

	/**
	 * @dataProvider base32DataProvider
	 */
	public function testToString($str, $bin, $base32){
		$this->assertEquals($str, Base32::toString($base32));
	}

	/**
	 * @expectedException \chillerlan\Base32\Base32Exception
	 * @expectedExceptionMessage Length must be exactly 32
	 */
	public function testSetCharsetException(){
		Base32::setCharset('florps');
	}

	/**
	 * @expectedException \chillerlan\Base32\Base32Exception
	 * @expectedExceptionMessage Length must be divisible by 8
	 */
	public function testCheckBinLengthException(){
		Base32::fromBin('0100110');
	}

	/**
	 * @expectedException \chillerlan\Base32\Base32Exception
	 * @expectedExceptionMessage Only 0 and 1 are permitted
	 */
	public function testCheckBinException(){
		Base32::fromBin('01001102');
	}

	/**
	 * @expectedException \chillerlan\Base32\Base32Exception
	 * @expectedExceptionMessage Must match character set
	 */
	public function testToBinCharsetException(){
		Base32::toBin('MFRGGZDFMZTÖ');
	}

}
