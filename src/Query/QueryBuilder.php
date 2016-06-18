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

	/**
	 * QueryBuilder constructor.
	 * @param Connection $connection
	 */
	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * @return Query
	 */
	public function createQuery()
	{
		return new Query($this->connection);
	}
}
