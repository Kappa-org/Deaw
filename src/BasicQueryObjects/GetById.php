<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\BasicQueryObjects;

use Kappa\Deaw\BasicSelectors\SelectAll;
use Kappa\Deaw\Queries\Queryable;
use Kappa\Deaw\Queries\QueryBuilder;

/**
 * Class GetById
 *
 * @package Kappa\Deaw\BasicQueryObjects
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class GetById implements Queryable
{
	/** @var mixed */
	private $id;

	/**
	 * @param mixed $id
	 */
	public function __construct($id)
	{
		$this->id = $id;
	}

	/**
	 * @param QueryBuilder $builder
	 * @return \DibiFluent
	 */
	public function getQuery(QueryBuilder $builder)
	{
		$query = $builder->select(new SelectAll())
			->where('id = ?', $this->id);

		return $query;
	}
}
