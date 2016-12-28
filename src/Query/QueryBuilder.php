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

/**
 * Class QueryBuilder
 * @package Kappa\Deaw\Query
 */
class QueryBuilder
{
	/** @var \DibiConnection */
	private $connection;

    /**
     * QueryBuilder constructor.
     * @param \DibiConnection $connection
     */
	public function __construct(\DibiConnection $connection)
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
