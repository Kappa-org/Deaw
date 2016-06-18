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

use Dibi\Connection;
use Dibi\Fluent;
use Kappa\Deaw\BasicQueryObjects\FindBy;
use Kappa\Deaw\Query\Queryable;
use Kappa\Deaw\Query\QueryBuilder;

/**
 * Class Table
 *
 * @package Kappa\Deaw
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class Table
{
	/** @var Connection */
	private $connection;

	/**
	 * Table constructor.
	 * @param Connection $connection
	 */
	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * @param string $tableName
	 * @param array $where
	 * @return \Dibi\Row|FALSE
	 */
	public function findOneBy($tableName, array $where)
	{
		return $this->fetchOne(new FindBy($tableName, $where));
	}

	/**
	 * @param string $tableName
	 * @param array $where
	 * @param array|null $order
	 * @param null $limit
	 * @param null $offset
	 * @return array
	 */
	public function findBy($tableName, array $where, array $order = null, $limit = null, $offset = null)
	{
		return $this->fetch(new FindBy($tableName, $where, $order), $limit, $offset);
	}

	/**
	 * @param string $tableName
	 * @param array|null $order
	 * @param null $limit
	 * @param null $offset
	 * @return array
	 */
	public function findAll($tableName, array $order = null, $limit = null, $offset = null)
	{
		return $this->fetch(new FindBy($tableName, [], $order), $limit, $offset);
	}

	/**
	 * @param Queryable $query
	 * @return \Dibi\Row|FALSE
	 */
	public function fetchOne(Queryable $query)
	{
		$data = $this->processQuery($query)->fetch();

		return $query->postFetch($data);
	}

	/**
	 * @param Queryable $query
	 * @param int|null $limit
	 * @param int|null $offset
	 * @return array
	 */
	public function fetch(Queryable $query, $limit = null, $offset = null)
	{
		$data = $this->processQuery($query)->fetchAll($offset, $limit);

		return $query->postFetch($data);
	}

	/**
	 * @param Queryable $query
	 * @return mixed
	 */
	public function fetchSingle(Queryable $query)
	{
		$data = $this->processQuery($query)->fetchSingle();

		return $query->postFetch($data);
	}

	/**
	 * @param Queryable $query
	 * @param null $return
	 * @return \Dibi\Result|int
	 */
	public function execute(Queryable $query, $return = null)
	{
		return $this->processQuery($query)->execute($return);
	}

	/**
	 * @param Queryable $query
	 * @return bool
	 */
	public function test(Queryable $query)
	{
		return $this->processQuery($query)->test();
	}

	/**
	 * @return QueryBuilder
	 */
	public function createQueryBuilder()
	{
		return new QueryBuilder($this->connection);
	}

	/**
	 * @param Queryable $query
	 * @return Fluent
	 */
	private function processQuery(Queryable $query)
	{
		$builder = $this->createQueryBuilder();
		$query = $query->doQuery($builder);
		if (!$query instanceof Fluent) {
			throw new MissingBuilderReturnException("Missing return builder from " . get_class($query));
		}

		return $query;
	}
}
