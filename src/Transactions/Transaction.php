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

use Dibi\Connection;

/**
 * Class Transaction
 * @package Kappa\Deaw
 */
class Transaction
{
    /** @var Connection */
    private $connection;

    /**
     * Transaction constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->begin();
    }

    /**
     * Commit transaction
     */
    public function commit()
    {
        $this->connection->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback()
    {
        $this->connection->rollback();
    }

    /**
     * Create a new savepoint
     * @return Savepoint
     */
    public function savepoint()
    {
        return new Savepoint($this->connection);
    }
}