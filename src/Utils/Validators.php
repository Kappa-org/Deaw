<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\Utils;

/**
 * Class Validators
 *
 * @package Kappa\Deaw\Utils
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class Validators
{
	/**
	 * @param array|string $select
	 * @return bool
	 */
	public static function isSelectValid($select)
	{
		if (is_string($select)) {
			return true;
		} else if (is_array($select)) {
			$key = array_keys($select)[0];
			if (count($select) != 1 || !is_string($key) || !is_string($select[$key])) {
				return false;
			}
			return true;
		} else {
			return false;
		}
	}
}
