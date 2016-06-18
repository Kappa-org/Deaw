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
 * Class SelectQueryObject
 * @package KappaTests\Deaw\Tests
 */
class SelectQueryObject extends QueryObject
{
	/**
	 * @param QueryBuilder $builder
	 * @return \Dibi\Fluent
	 */
	public function doQuery(QueryBuilder $builder)
	{
		$query = $builder->createQuery()->select('name')->from('user');

		return $query;
	}
}
