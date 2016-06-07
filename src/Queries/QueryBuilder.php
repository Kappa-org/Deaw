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

use Dibi\Connection;
use Kappa\Deaw\InvalidArgumentException;

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
	 * @param string $selects
	 * @return \Dibi\Fluent
	 */
	public function select($selects)
	{
		if (is_string($selects)) {
			$dibiFluent = $this->connection->select($selects);
		} else {
			throw new InvalidArgumentException("Invalid argument for 'select()' method in query object");
		}
		$dibiFluent->from($this->tableName);

		return $dibiFluent;
	}

	/**
	 * @param array $data
	 * @return \Dibi\Fluent
	 */
	public function update(array $data)
	{
		return $this->connection->update($this->tableName, $data);
	}

	/**
	 * @param array $data
	 * @return \Dibi\Fluent
	 */
	public function insert(array $data)
	{
		return $this->connection->insert($this->tableName, $data);
	}

	/**
	 * @return \Dibi\Fluent
	 */
	public function delete()
	{
		return $this->connection->delete($this->tableName);
	}
}
