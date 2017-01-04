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
use Kappa\Deaw\InvalidArgumentException;

/**
 * Class SelectFactory
 * @package Kappa\Deaw\Utils
 */
class SelectFactory
{
	/**
	 * Prepare SQL select string
	 * @param string|array $select
	 * @param string|null $table
	 * @param string|null $prefix
	 * @return string
	 */
	public static function format($select, $table = null, $prefix = null)
	{
		if (!is_array($select) && !is_string($select)) {
			throw new InvalidArgumentException('Invalid select. Select must be only string or array');
		}

		$result = [];

		if (is_string($select)) {
			$select = explode(',', $select);
		}
		foreach ($select as $key => $column) {
			if (!is_string($column)) {
				throw new InvalidArgumentException('Invalid column \'' . $key . '\'. Column name must be only string');
			}
			$column = trim($column);
			$preparedResult = '';
			if ($table !== null) {
				$preparedResult .= $table . '.' . $column;
			} else {
				$preparedResult .= $column;
			}
			if ($prefix !== null && !preg_match('~\s+as\s+~', $column)) {
				$preparedResult .= ' as ' . $prefix . '_' . $column;
			}
			$result[] = $preparedResult;
		}

		return implode(', ', $result);
	}
}