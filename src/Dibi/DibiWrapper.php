<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\Dibi;

use Dibi\Connection;

/**
 * Class DibiWrapper
 * @package Kappa\Dibi
 */
class DibiWrapper
{
    /** @var Connection */
    private $connection;

    /**
     * DibiWrapper constructor.
     * @param Connection $dibiConnection
     */
    public function __construct(Connection $dibiConnection)
    {
        $this->connection = $dibiConnection;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }
}