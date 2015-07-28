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

/**
 * Class TableFactory
 *
 * @package Kappa\Deaw
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class TableFactory
{
	private $dibiConnection;

	/**
	 * @param \DibiConnection $dibiConnection
	 */
	public function __construct(\DibiConnection $dibiConnection)
	{
		$this->dibiConnection = $dibiConnection;
	}

	/**
	 * Returns new Table instance
	 * @param string $tableName
	 * @return Table
	 */
	public function create($tableName)
	{
		return new Table($this->dibiConnection, $tableName);
	}
}
