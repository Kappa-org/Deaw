<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\Query;

use Dibi\Connection;

/**
 * Class QueryBuilder
 *
 * @package Kappa\Deaw\Queries
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class QueryBuilder
{
	/** @var Connection */
	private $connection;

	/** @var string */
	private $tableName;

	/**
	 * QueryBuilder constructor.
	 * @param Connection $connection
	 * @param $tableName
	 */
	public function __construct(Connection $connection, $tableName)
	{
		$this->connection = $connection;
		$this->tableName = $tableName;
	}

	/**
	 * @return Query
	 */
	public function createQuery()
	{
		return new Query($this->connection, $this->tableName);
	}
}
