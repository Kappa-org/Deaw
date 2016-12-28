<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\Transactions;

use Kappa\Deaw\Dibi\DibiWrapper;

/**
 * Class Transaction
 * @package Kappa\Deaw
 */
class Transaction
{
    /** @var DibiWrapper */
    private $wrapper;

    /**
     * Transaction constructor.
     * @param DibiWrapper $dibiWrapper
     */
    public function __construct(DibiWrapper $dibiWrapper)
    {
        $this->wrapper = $dibiWrapper;
        $this->wrapper->getConnection()->begin();
    }

    /**
     * Commit transaction
     */
    public function commit()
    {
        $this->wrapper->getConnection()->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback()
    {
        $this->wrapper->getConnection()->rollback();
    }

    /**
     * Create a new savepoint
     * @return Savepoint
     */
    public function savepoint()
    {
        return new Savepoint($this->wrapper);
    }
}