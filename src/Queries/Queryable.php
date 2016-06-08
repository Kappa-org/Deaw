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

use Dibi\Fluent;

/**
 * Interface Queryable
 * @package Kappa\Deaw\Queries
 */
interface Queryable
{
	/**
	 * @param QueryBuilder $builder
	 * @return Fluent
	 */
	public function getQuery(QueryBuilder $builder);

	/**
	 * @param mixed $data
	 * @return mixed
	 */
	public function postFetch($data);
}
