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

use Dibi\Fluent;
use Kappa\Deaw\MissingBuilderReturnException;

/**
 * Class QueryProcessor
 * @package Kappa\Deaw\Utils
 */
class QueryProcessor
{
	/** @var QueryBuilder */
	private $queryBuilder;

	/**
	 * DibiWrapper constructor.
	 * @param QueryBuilder $queryBuilder
	 */
	public function __construct(QueryBuilder $queryBuilder)
	{
		$this->queryBuilder = $queryBuilder;
	}

	/**
	 * @param Queryable $query
	 * @return Fluent|\DibiFluent
	 */
	public function process(Queryable $query)
	{
		$query = $query->doQuery($this->queryBuilder);
		if (!$query instanceof Fluent) {
			throw new MissingBuilderReturnException("Missing return builder from " . get_class($query));
		}

		return $query;
	}
}