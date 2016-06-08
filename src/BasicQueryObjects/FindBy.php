<?php
/**
 * This file is part of the Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\BasicQueryObjects;

use Dibi\Fluent;
use Kappa\Deaw\Queries\Queryable;
use Kappa\Deaw\Queries\QueryBuilder;

/**
 * Class FindOneBy
 * @package Kappa\Deaw\BasicQueryObjects
 */
class FindBy implements Queryable
{
    /** @var array */
    private $where;

    /** @var array|null */
    private $order;

    /**
     * FindOneBy constructor.
     * @param array $where
     * @param array|null $order
     */
    public function __construct(array $where, array $order = null)
    {
        $this->where = $where;
        $this->order = $order;
    }

    /**
     * @param QueryBuilder $builder
     * @return Fluent
     */
    public function getQuery(QueryBuilder $builder)
    {
        $query = $builder->createQuery()->select('*');

        // Apply where conditions
        foreach ($this->where as $column => $rule) {
            $query->where($column . ' = ?', $rule);
        }

        // Set order for query when is set
        if ($this->order !== null) {
            $query->orderBy($this->order);
        }

        return $query;
    }
}