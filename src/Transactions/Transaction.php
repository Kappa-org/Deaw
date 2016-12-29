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
use Nette\Utils\Random;

/**
 * Class Transaction
 * @package Kappa\Deaw
 */
class Transaction
{
	/** @var bool */
	static $existsActiveTransaction = false;

	/** @var DibiWrapper */
	private $wrapper;

	/** @var null|string */
	private $savepoint;

	/**
	 * Transaction constructor.
	 * @param DibiWrapper $dibiWrapper
	 * @param null|string $savepoint
	 */
	private function __construct(DibiWrapper $dibiWrapper, $savepoint = null)
	{
		$this->wrapper = $dibiWrapper;
		$this->savepoint = $savepoint;
		$this->wrapper->getConnection()->begin($this->savepoint);
	}

	/**
	 * @param DibiWrapper $dibiWrapper
	 * @return Transaction
	 */
	public static function create(DibiWrapper $dibiWrapper)
	{
		$savepoint = null;
		if (Transaction::$existsActiveTransaction) {
			$savepoint = Random::generate() . time();
		} else {
			Transaction::$existsActiveTransaction = true;
		}

		return new Transaction($dibiWrapper, $savepoint);
	}

	/**
	 * Commit transaction
	 */
	public function commit()
	{
		if (Transaction::$existsActiveTransaction) {
			Transaction::$existsActiveTransaction = false;
		}
		$this->wrapper->getConnection()->commit($this->savepoint);
	}

	/**
	 * Rollback transaction
	 */
	public function rollback()
	{
		if (Transaction::$existsActiveTransaction) {
			Transaction::$existsActiveTransaction = false;
		}
		$this->wrapper->getConnection()->rollback($this->savepoint);
	}

	/**
	 * @return null|string
	 */
	public function getSavepointName()
	{
		return $this->savepoint;
	}
}