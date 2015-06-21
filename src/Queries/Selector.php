<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\Queries;

use Kappa\Deaw\Utils\Validators;
use Kappa\Deaw\InvalidSelectDefinitionException;

/**
 * Class Selector
 *
 * @package Kappa\Deaw\Queries
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class Selector
{
	/** @var array */
	private $selects;

	/** @var null|string */
	private $tableName;

	/** @var null|string */
	private $prefix;

	/**
	 * @param string|null $tableName
	 * @param string|null $prefix
	 */
	public function __construct($tableName = null, $prefix = null)
	{
		$this->tableName = $tableName;
		$this->prefix = $prefix;
	}

	/**
	 * @return void
	 */
	public function configure() {}

	/**
	 * @param array $selectors
	 * @return $this
	 */
	public function setSelects(array $selectors)
	{
		foreach ($selectors as $select) {
			$this->addSelect($select);
		}

		return $this;
	}

	/**
	 * @param string|array $select
	 * @return $this
	 */
	public function addSelect($select)
	{
		if (!Validators::isSelectValid($select)) {
			throw new InvalidSelectDefinitionException(__METHOD__ . ': Invalid selector');
		}
		if (is_string($select)) {
			$this->selects[$select] = "";
		}
		if (is_array($select)) {
			$key = array_keys($select)[0];
			$this->selects[$key] = $select[$key];
		}

		return $this;
	}

	/**
	 * @return array
	 */
	public function getSelects()
	{
		return $this->selects;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		$selects = $this->getSelects();
		$string = "";
		$i = 1;
		foreach ($selects as $original => $as) {
			if ($this->tableName != null) {
				$string .= "{$this->tableName}.";
			}
			if (empty($as)) {
				$string .= $original;
				if ($this->prefix != null) {
					$string .= " as {$this->prefix}_{$original}";
				}
			} else {
				$string .= "{$original} as ";
				if ($this->prefix !== null) {
					$string .= "{$this->prefix}_";
				}
				$string .= $as;
			}
			if (count($selects) != $i) {
				$string .= ',';
			}
			$i++;
		}

		return $string;
	}
}
