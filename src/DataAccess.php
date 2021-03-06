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

use Kappa\Deaw\Query\Queryable;
use Kappa\Deaw\Query\QueryProcessor;
use Kappa\Deaw\Transactions\TransactionFactory;
use Nette\Utils\Callback;

/**
 * Class DataAccess
 * @package Kappa\Deaw
 */
class DataAccess
{
	/** @var QueryProcessor */
	private $queryProcessor;

	/** @var TransactionFactory */
	private $transactionFactory;

	/**
	 * DataAccess constructor.
	 * @param QueryProcessor $queryProcessor
	 * @param TransactionFactory $transactionFactory
	 */
	public function __construct(QueryProcessor $queryProcessor, TransactionFactory $transactionFactory)
	{
		$this->queryProcessor = $queryProcessor;
		$this->transactionFactory = $transactionFactory;
	}

	/**
	 * @param Queryable $query
	 * @return \Dibi\Row|\DibiRow|FALSE
	 */
	public function fetchOne(Queryable $query)
	{
		$data = $this->queryProcessor->process($query)->fetch();

		return $query->postFetch($data);
	}

	/**
	 * @param Queryable $query
	 * @param int|null $limit
	 * @param int|null $offset
	 * @return \DibiRow[]|\Dibi\Row
	 */
	public function fetch(Queryable $query, $limit = null, $offset = null)
	{
		$data = $this->queryProcessor->process($query)->fetchAll($offset, $limit);

		return $query->postFetch($data);
	}

	/**
	 * @param Queryable $query
	 * @return mixed
	 */
	public function fetchSingle(Queryable $query)
	{
		$data = $this->queryProcessor->process($query)->fetchSingle();

		return $query->postFetch($data);
	}

	/**
	 * @param Queryable $query
	 * @param string $assoc
	 * @return \DibiRow[]|\Dibi\Row
	 */
	public function fetchAssoc(Queryable $query, $assoc)
	{
		$data = $this->queryProcessor->process($query)->fetchAssoc($assoc);

		return $query->postFetch($data);
	}

	/**
	 * @param Queryable $query
	 * @param string $key
	 * @param string $value
	 * @return array
	 */
	public function fetchPairs(Queryable $query, $key = null, $value = null)
	{
		$data = $this->queryProcessor->process($query)->fetchPairs($key, $value);

		return $query->postFetch($data);
	}

	/**
	 * @param Queryable $query
	 * @param null $return
	 * @return \Dibi\Result|\DibiResult|int
	 */
	public function execute(Queryable $query, $return = null)
	{
		return $this->queryProcessor->process($query)->execute($return);
	}

	/**
	 * @param Queryable $query
	 * @return bool
	 */
	public function test(Queryable $query)
	{
		return $this->queryProcessor->process($query)->test();
	}

	/**
	 * @return Transactions\Transaction
	 */
	public function createTransaction()
	{
		return $this->transactionFactory->create();
	}
}
