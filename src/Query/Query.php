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

use Kappa\Deaw\InvalidArgumentException;

/**
 * Class Query
 * @package Kappa\Deaw\Queries
 */
class Query
{
    /** @var \DibiConnection */
    private $connection;

    /**
     * Query constructor.
     * @param \DibiConnection $connection
     */
    public function __construct(\DibiConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string|array $selects
     * @return \DibiFluent
     */
    public function select($selects)
    {
        if (is_array($selects)) {
            foreach ($selects as $select) {
                if (!is_string($select)) {
                    throw new InvalidArgumentException("Invalid argument for 'select()' method in query object. Select requires only strings or array of strings");
                }
            }
            $dibiFluent = $this->connection->select(implode(', ', $selects));
        } else if (is_string($selects)) {
            $dibiFluent = $this->connection->select($selects);
        } else {
            throw new InvalidArgumentException("Invalid argument for 'select()' method in query object. Select requires only strings or array of strings");
        }

        return $dibiFluent;
    }

    /**
     * @param string $tableName
     * @param array $data
     * @return \DibiFluent
     */
    public function update($tableName, array $data)
    {
        return $this->connection->update($tableName, $data);
    }

    /**
     * @param string $tableName
     * @param array $data
     * @return \DibiFluent
     */
    public function insert($tableName, array $data)
    {
        return $this->connection->insert($tableName, $data);
    }

    /**
     * @param string $tableName
     * @return \DibiFluent
     */
    public function delete($tableName)
    {
        return $this->connection->delete($tableName);
    }
}