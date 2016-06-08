<?php
/**
 * This file is part of the Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\Queries;

/**
 * Class QueryObject
 * @package Kappa\Deaw\Queries
 */
abstract class QueryObject implements Queryable
{
    /**
     * @param mixed $data
     * @return mixed
     */
    public function postFetch($data)
    {
        return $data;
    }
}