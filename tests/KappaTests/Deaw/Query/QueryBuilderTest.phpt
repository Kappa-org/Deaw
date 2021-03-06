<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 *
 * @testCase
 */

namespace KappaTests\Deaw\Query;

use Dibi\Connection;
use Kappa\Deaw\Dibi\DibiWrapper;
use Kappa\Deaw\Query\QueryBuilder;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class QueryBuilerTest
 * @package KappaTests\Deaw\Queries
 */
class QueryBuilderTest extends TestCase
{
	/** @var QueryBuilder */
	private $queryBuilder;

	private $config;

	public function __construct($config)
	{
		$this->config = $config;
	}

	protected function setUp()
	{
		$connection = new Connection($this->config);
		$this->queryBuilder = new QueryBuilder(new DibiWrapper($connection));
	}

	public function testCreateQuery()
	{
		Assert::type('\Kappa\Deaw\Query\Query', $this->queryBuilder->createQuery());
	}
}


\run(new QueryBuilderTest(getDatabaseConnection()));
