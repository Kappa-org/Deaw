<?php
/**
 * This file is part of the Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 *
 * @testCase
 */

namespace KappaTests\Deaw\Transactions;

use Kappa\Deaw\Transactions\TransactionFactory;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class TransactionFactory
 * @package KappaTests\Deaw\Transactions
 */
class TransactionFactoryTest extends TestCase
{
	/** @var TransactionFactory */
	private $transactionFactory;

	protected function setUp()
	{
		$connectionMock = \Mockery::mock('\DibiConnection');
		$connectionMock->shouldReceive('begin');

		$dibiWrapperMock = \Mockery::mock('\Kappa\Deaw\Dibi\DibiWrapper');
		$dibiWrapperMock->shouldReceive('getConnection')->andReturn($connectionMock);

		$this->transactionFactory = new TransactionFactory($dibiWrapperMock);

	}

	public function testSimpleCreate()
	{
		$transaction = $this->transactionFactory->create();
		Assert::null($transaction->getSavepointName());
	}

	public function testNestedCreate()
	{
		$transaction1 = $this->transactionFactory->create();
		$transaction2 = $this->transactionFactory->create();
		Assert::null($transaction1->getSavepointName());
		Assert::notSame(null, $transaction2->getSavepointName());
	}
}


\run(new TransactionFactoryTest);
