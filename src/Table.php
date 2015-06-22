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

use Kappa\Deaw\Queries\Queryable;
use Kappa\Deaw\Queries\QueryBuilder;

/**
 * Class Table
 *
 * @package Kappa\Deaw
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class Table
{
	/** @var \DibiConnection */
	private $connection;

	/** @var string */
	private $tableName;

	/**
	 * @param \DibiConnection $connection
	 * @param string $tableName
	 */
	public function __construct(\DibiConnection $connection, $tableName)
	{
		$this->connection = $connection;
		$this->tableName = $tableName;
	}

	/**
	 * @param Queryable $query
	 * @return \DibiRow|FALSE
	 */
	public function fetchOne(Queryable $query)
	{
		return $this->processQuery($query)->fetch();
	}

	/**
	 * @param Queryable $query
	 * @param int|null $offset
	 * @param int|null $limit
	 * @return DibiRow[]
	 */
	public function fetch(Queryable $query, $offset = null, $limit = null)
	{
		return $this->processQuery($query)->fetchAll($offset, $limit);
	}

	/**
	 * @param Queryable $query
	 * @return mixed
	 */
	public function fetchSingle(Queryable $query)
	{
		return $this->processQuery($query)->fetchSingle();
	}

	/**
	 * @param Queryable $query
	 * @param null $return
	 * @return \DibiResult|int
	 */
	public function execute(Queryable $query, $return = null)
	{
		return $this->processQuery($query)->execute($return);
	}

	/**
	 * @return QueryBuilder
	 */
	public function createQueryBuilder()
	{
		return new QueryBuilder($this->connection, $this->tableName);
	}

	/**
	 * @return string
	 */
	public function getTableName()
	{
		return $this->tableName;
	}

	/**
	 * @param Queryable $query
	 * @return \DibiFluent
	 */
	private function processQuery(Queryable $query)
	{
		$builder = $this->createQueryBuilder();
		$query = $query->getQuery($builder);
		if (!$query instanceof \DibiFluent) {
			throw new MissingBuilderReturnException("Missing return builder from " . get_class($query));
		}

		return $query;
	}
}
