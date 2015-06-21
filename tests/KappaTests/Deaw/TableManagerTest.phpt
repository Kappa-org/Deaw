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

namespace KappaTests\Deaw;

use Kappa\Deaw\TableManager;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class TableManagerTest
 *
 * @package Kappa\Deaw\Tests
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class TableManagerTest extends TestCase
{
	/** @var TableManager */
	private $tableManager;

	protected function setUp()
	{
		$table = \Mockery::mock('Kappa\Deaw\Table');
		$table->shouldReceive("getTableName")->once()->withNoArgs()->andReturn("foo");
		$this->tableManager = new TableManager([$table]);
	}
	public function testGetTable()
	{
		Assert::type('Kappa\Deaw\Table', $this->tableManager->getTable('foo'));
	}

	public function testNonTable()
	{
		Assert::null($this->tableManager->getTable('bar'));
		Assert::null($this->tableManager->create('bar'));
	}

	public function testCreate()
	{
		Assert::type('Kappa\Deaw\Table', $this->tableManager->create('foo'));
	}
}

\run(new TableManagerTest());
