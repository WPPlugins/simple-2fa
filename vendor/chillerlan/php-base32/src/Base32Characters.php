<?php
/**
 * Class CharacterSets
 *
 * @filesource   Base32Characters.php
 * @created      29.02.2016
 * @package      chillerlan\Base32
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\Base32;

/**
 *
 */
class Base32Characters{

	/**
	 * RFC3548
	 *
	 * The character set as defined by RFC3548
	 *
	 * @link http://www.ietf.org/rfc/rfc3548.txt
	 */
	const RFC3548 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

	/**
	 * csSafe
	 *
	 * This character set is designed to be more human friendly
	 * For example: i, I, L, l and 1 all map to 1
	 * Also: there is no U - to help prevent offencive output
	 *
	 * @link http://www.crockford.com/wrmg/base32.html
	 *
	 */
	const CROCKFORD = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';

	/**
	 * cs09AV
	 *
	 * This character set follows the example of the hex
	 * character set and is included to make this class
	 * compatible with MIME::Base32
	 *
	 * @link http://search.cpan.org/~danpeder/MIME-Base32-1.01/Base32.pm
	 *
	 */
	const MIME_09AV = '0123456789ABCDEFGHIJKLMNOPQRSTUV';

}
