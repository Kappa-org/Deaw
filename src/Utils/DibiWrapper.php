<?php
/**
 * This file is part of the Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\Utils;

use Dibi\Fluent;
use Kappa\Deaw\MissingBuilderReturnException;
use Kappa\Deaw\Query\Queryable;
use Kappa\Deaw\Query\QueryBuilder;

/**
 * Class DibiWrapper
 * @package Kappa\Deaw\Utils
 */
class DibiWrapper
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
     * @return Fluent
     */
    public function processQuery(Queryable $query)
    {
        $query = $query->doQuery($this->queryBuilder);
        if (!$query instanceof Fluent) {
            throw new MissingBuilderReturnException("Missing return builder from " . get_class($query));
        }

        return $query;
    }
}