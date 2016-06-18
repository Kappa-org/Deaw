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
 * Class InvalidQueryObject
 * @package KappaTests\Deaw\Tests
 */
class InvalidQueryObject extends QueryObject
{
	/**
	 * @param QueryBuilder $builder
	 * @return \Dibi\Fluent|void
	 */
	public function getQuery(QueryBuilder $builder)
	{
		$builder->createQuery()->insert(['name' => 'bar']);
	}
}
