<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\Queries;

use Kappa\Deaw\InvalidArgumentException;

/**
 * Class QueryBuilder
 *
 * @package Kappa\Deaw\Queries
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class QueryBuilder
{
	/** @var \DibiConnection */
	private $connection;

	/** @var string */
	private $tableName;

	/**
	 * @param \DibiConnection $connection
	 * @param string $tableName
	 */
	public function __construct(\DibiConnection $connection, $tableName)
	{
		$this->connection = $connection;
		$this->tableName = $tableName;
	}

	/**
	 * @param Selector|Selector[] $selects
	 * @return \DibiFluent
	 * @throws InvalidArgumentException
	 */
	public function select($selects)
	{
		if ($selects instanceof Selector) {
			$selects->configure();
			$dibiFluent = $this->connection->select((string)$selects);
		} else {
			if (is_array($selects)) {
				$result = "";
				$i = 1;
				foreach ($selects as $select) {
					if (!$select instanceof Selector) {
						throw new InvalidArgumentException("Argument 'select()' method must be Selector");
					}
					$select->configure();
					$result .= (string)$select;
					if (count($selects) != $i) {
						$result .= ',';
					}
					$i++;
				}
				$dibiFluent = $this->connection->select($result);
			} else {
				throw new InvalidArgumentException("Invalid argument for 'select()' method in query object");
			}
		}
		$dibiFluent->from($this->tableName);

		return $dibiFluent;
	}

	/**
	 * @param array $data
	 * @return \DibiFluent
	 */
	public function update(array $data)
	{
		return $this->connection->update($this->tableName, $data);
	}

	/**
	 * @param array $data
	 * @return \DibiFluent
	 */
	public function insert(array $data)
	{
		return $this->connection->insert($this->tableName, $data);
	}

	/**
	 * @return \DibiFluent
	 */
	public function delete()
	{
		return $this->connection->delete($this->tableName);
	}
}
