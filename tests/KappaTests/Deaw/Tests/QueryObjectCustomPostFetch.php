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


use Kappa\Deaw\Query\QueryBuilder;
use Kappa\Deaw\Query\QueryObject;

/**
 * Class QueryObjectCustomPostFetch
 * @package KappaTests\Deaw\Tests
 */
class QueryObjectCustomPostFetch extends QueryObject
{
    const POST_FETCH_RETURN = 'bar';
    
    /**
     * @param QueryBuilder $builder
     * @return \Kappa\Deaw\Query\Query
     */
    public function getQuery(QueryBuilder $builder)
    {
        return $builder->createQuery();
    }

    /**
     * @param mixed $data
     * @return string
     */
    public function postFetch($data)
    {
        return self::POST_FETCH_RETURN;
    }
}