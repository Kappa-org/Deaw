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
use Nette\Utils\Random;

/**
 * Class Savepoint
 * @package Kappa\Deaw
 */
class Savepoint
{
    /** @var string */
    private $name;

    /** @var \DibiConnection */
    private $connection;

    /**
     * Savepoint constructor.
     * @param \DibiConnection $connection
     */
    public function __construct(\DibiConnection $connection)
    {
        $this->name = Random::generate() . time();
        $this->connection = $connection;
        $this->connection->begin($this->name);
    }

    /**
     * Rollback savepoint
     */
    public function rollback()
    {
        $this->connection->rollback($this->name);
    }

    /**
     * Release savepoint
     */
    public function release()
    {
        $this->connection->commit($this->name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}