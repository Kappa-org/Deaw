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

use Dibi\Fluent;
use Kappa\Deaw\Query\QueryBuilder;
use Kappa\Deaw\Query\QueryObject;

/**
 * Class FetchQueryObject
 * @package KappaTests\Deaw\Tests
 */
class FetchQueryObject extends QueryObject
{
    /**
     * @param QueryBuilder $builder
     * @return Fluent
     */
    public function doQuery(QueryBuilder $builder)
    {
        return $builder->createQuery()->select('*')
            ->from('user')
            ->orderBy(['id' => 'ASC']);
    }
}