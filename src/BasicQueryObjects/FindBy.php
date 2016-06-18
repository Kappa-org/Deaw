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
use Kappa\Deaw\Query\QueryBuilder;
use Kappa\Deaw\Query\QueryObject;

/**
 * Class FindOneBy
 * @package Kappa\Deaw\BasicQueryObjects
 */
class FindBy extends QueryObject
{
    /** @var string */
    private $tableName;

    /** @var array */
    private $where;

    /** @var array|null */
    private $order;

    /**
     * FindBy constructor.
     * @param string $tableName
     * @param array $where
     * @param array|null $order
     */
    public function __construct($tableName, array $where, array $order = null)
    {
        $this->tableName = $tableName;
        $this->where = $where;
        $this->order = $order;
    }

    /**
     * @param QueryBuilder $builder
     * @return Fluent
     */
    public function doQuery(QueryBuilder $builder)
    {
        $query = $builder->createQuery()->select('*')
            ->from($this->tableName);

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