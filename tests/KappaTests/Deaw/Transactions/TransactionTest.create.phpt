<?php
/**
 * This file is part of the Kappa/Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 *
 * @testCase
 */

namespace KappaTests\Deaw\Transactions;

use Kappa\Deaw\Transactions\Transaction;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class TransactionTest
 * @package KappaTests\Deaw\Transactions
 */
class TransactionTest extends TestCase 
{
	private $dibiWrapper;

	protected function setUp()
	{
		$dibiConnectionMock = \Mockery::mock('\DibiConnection');
		$dibiConnectionMock->shouldReceive('begin');
		$this->dibiWrapper = \Mockery::mock('Kappa\Deaw\Dibi\DibiWrapper');
		$this->dibiWrapper->shouldReceive('getConnection')->andReturn($dibiConnectionMock);
	}

	public function testNullSavepointName()
	{
		$transaction = Transaction::create($this->dibiWrapper);
		Assert::null($transaction->getSavepointName());
	}

	public function testNotNullSavepointName()
	{
		Transaction::$existsActiveTransaction = true;
		$transaction = Transaction::create($this->dibiWrapper);
		Assert::notSame(null, $transaction->getSavepointName());
	}
}


\run(new TransactionTest);
