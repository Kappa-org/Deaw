<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw;

use Kappa\Deaw\Query\Queryable;
use Kappa\Deaw\Utils\DibiWrapper;

/**
 * Class Table
 *
 * @package Kappa\Deaw
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class Table
{
    /** @var DibiWrapper */
    private $dibiWrapper;

    /**
     * Table constructor.
     * @param DibiWrapper $dibiWrapper
     */
    public function __construct(DibiWrapper $dibiWrapper)
    {
        $this->dibiWrapper = $dibiWrapper;
    }

    /**
     * @param Queryable $query
     * @return \Dibi\Row|FALSE
     */
    public function fetchOne(Queryable $query)
    {
        $data = $this->dibiWrapper->processQuery($query)->fetch();

        return $query->postFetch($data);
    }

    /**
     * @param Queryable $query
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function fetch(Queryable $query, $limit = null, $offset = null)
    {
        $data = $this->dibiWrapper->processQuery($query)->fetchAll($offset, $limit);

        return $query->postFetch($data);
    }

    /**
     * @param Queryable $query
     * @return mixed
     */
    public function fetchSingle(Queryable $query)
    {
        $data = $this->dibiWrapper->processQuery($query)->fetchSingle();

        return $query->postFetch($data);
    }

    /**
     * @param Queryable $query
     * @param null $return
     * @return \Dibi\Result|int
     */
    public function execute(Queryable $query, $return = null)
    {
        return $this->dibiWrapper->processQuery($query)->execute($return);
    }

    /**
     * @param Queryable $query
     * @return bool
     */
    public function test(Queryable $query)
    {
        return $this->dibiWrapper->processQuery($query)->test();
    }
}
