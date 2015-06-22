<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw;

/**
 * Class TableManager
 *
 * @package Kappa\Deaw
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class TableManager
{
	/** @var Table[] */
	private $tables;

	/**
	 * @param Table[] $tables
	 */
	public function __construct(array $tables)
	{
		$this->tables = $tables;
	}

	/**
	 * Returns Table class for concrete table name
	 * @param string $name
	 * @return Table|null
	 */
	public function getTable($name)
	{
		foreach ($this->tables as $table) {
			if ($table->getTableName() == $name) {
				return $table;
			}
		}

		return null;
	}

	/**
	 * Method alias for getTable() and kdyby/autowire package
	 * @param string $tableName
	 * @return Table
	 */
	public function create($tableName)
	{
		return $this->getTable($tableName);
	}
}
