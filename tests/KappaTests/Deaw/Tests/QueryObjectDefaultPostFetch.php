<?php
/**
 * This file is part of the Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace KappaTests\Deaw\Tests;


use Kappa\Deaw\Queries\QueryBuilder;
use Kappa\Deaw\Queries\QueryObject;

/**
 * Class QueryObjectDefaultPostFetch
 * @package KappaTests\Deaw\Tests
 */
class QueryObjectDefaultPostFetch extends QueryObject
{
    /**
     * @param QueryBuilder $builder
     * @return \Kappa\Deaw\Queries\Query
     */
    public function getQuery(QueryBuilder $builder)
    {
        return $builder->createQuery();
    }
}