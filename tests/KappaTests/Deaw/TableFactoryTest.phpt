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

use Dibi\Connection;
use Kappa\Deaw\TableFactory;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class TableManagerTest
 *
 * @package Kappa\Deaw\Tests
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class TableFactoryTest extends TestCase
{
	/** @var TableFactory */
	private $tableFactory;

	/** @var array */
	private $config;

	/**
	 * @param $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}


	protected function setUp()
	{
		$this->tableFactory = new TableFactory(new Connection($this->config));
	}

	public function testCreate()
	{
		Assert::type('Kappa\Deaw\Table', $this->tableFactory->create('foo'));
	}
}

\run(new TableFactoryTest(getDatabaseConnection()));
