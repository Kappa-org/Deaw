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
use Kappa\Deaw\InvalidArgumentException;

/**
 * Class Query
 * @package Kappa\Deaw\Queries
 */
class Query
{
	/** @var DibiWrapper */
	private $wrapper;

	/**
	 * Query constructor.
	 * @param DibiWrapper $dibiWrapper
	 */
	public function __construct(DibiWrapper $dibiWrapper)
	{
		$this->wrapper = $dibiWrapper;
	}

	/**
	 * @param string|array $select
	 * @return \Dibi\Fluent|\DibiFluent
	 */
	public function select($select)
	{
		return $this->wrapper->getConnection()->select($select);
	}

	/**
	 * @param string $tableName
	 * @param array $data
	 * @return \Dibi\Fluent|\DibiFluent
	 */
	public function update($tableName, array $data)
	{
		return $this->wrapper->getConnection()->update($tableName, $data);
	}

	/**
	 * @param string $tableName
	 * @param array $data
	 * @return \Dibi\Fluent|\DibiFluent
	 */
	public function insert($tableName, array $data)
	{
		return $this->wrapper->getConnection()->insert($tableName, $data);
	}

	/**
	 * @param string $tableName
	 * @return \Dibi\Fluent|\DibiFluent
	 */
	public function delete($tableName)
	{
		return $this->wrapper->getConnection()->delete($tableName);
	}
}