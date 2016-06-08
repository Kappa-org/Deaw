<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace KappaTests\Deaw;

use Kappa\Deaw\Queries\QueryBuilder;
use Kappa\Deaw\Queries\QueryObject;

/**
 * Class SelectQueryObject
 *
 * @package KappaTests\Deaw
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class SelectQueryObject extends QueryObject
{
	/**
	 * @param QueryBuilder $builder
	 * @return \Dibi\Fluent
	 */
	public function getQuery(QueryBuilder $builder)
	{
		$query = $builder->createQuery()->select('name');

		return $query;
	}
}
