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

/**
 * Class TransactionFactory
 * @package Kappa\Deaw
 */
class TransactionFactory
{
    /** @var \DibiConnection */
    private $connection;

    /**
     * TransactionFactory constructor.
     * @param \DibiConnection $connection
     */
    public function __construct(\DibiConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Create a new Transaction
     * @return Transaction
     */
    public function create()
    {
        return new Transaction($this->connection);
    }
}