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

/**
 * Class DibiWrapper
 * @package Kappa\Dibi
 */
class DibiWrapper
{
	/** @var \DibiConnection */
	private $connection;

	/**
	 * DibiWrapper constructor.
	 * @param \DibiConnection $dibiConnection
	 */
	public function __construct(\DibiConnection $dibiConnection)
	{
		$this->connection = $dibiConnection;
	}

	/**
	 * @return \DibiConnection
	 */
	public function getConnection()
	{
		return $this->connection;
	}
}