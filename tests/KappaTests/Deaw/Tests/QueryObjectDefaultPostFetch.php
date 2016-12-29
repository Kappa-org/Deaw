<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace KappaTests\Deaw\Tests;

use Kappa\Deaw\Query\QueryBuilder;
use Kappa\Deaw\Query\QueryObject;

/**
 * Class QueryObjectDefaultPostFetch
 * @package KappaTests\Deaw\Tests
 */
class QueryObjectDefaultPostFetch extends QueryObject
{
	/**
	 * @param QueryBuilder $builder
	 * @return \Kappa\Deaw\Query\Query
	 */
	public function doQuery(QueryBuilder $builder)
	{
		return $builder->createQuery();
	}
}