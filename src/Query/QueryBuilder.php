<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\Query;

use Kappa\Deaw\Dibi\DibiWrapper;

/**
 * Class QueryBuilder
 * @package Kappa\Deaw\Query
 */
class QueryBuilder
{
    /** @var DibiWrapper */
    private $wrapper;

    /**
     * QueryBuilder constructor.
     * @param DibiWrapper $dibiWrapper
     */
    public function __construct(DibiWrapper $dibiWrapper)
    {
        $this->wrapper = $dibiWrapper;
    }

    /**
     * @return Query
     */
    public function createQuery()
    {
        return new Query($this->wrapper);
    }
}
