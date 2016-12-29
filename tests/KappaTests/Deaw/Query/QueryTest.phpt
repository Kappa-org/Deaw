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
use Kappa\Deaw\Query\Query;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class QueryTest
 * @package KappaTests\Deaw\Query
 */
class QueryTest extends TestCase
{
	const TABLE = 'foo';

	/** @var Query */
	private $query;

	private $config;

	public function __construct($config)
	{
		$this->config = $config;
	}

	protected function setUp()
	{
		$connection = new Connection($this->config);
		$this->query = new Query(new DibiWrapper($connection));
	}

	public function testInsert()
	{
		$result = $this->query->insert(self::TABLE, ['name' => 'bar']);
		Assert::type('\Dibi\Fluent', $result);
		Assert::same("INSERT INTO `foo` (`name`) VALUES ('bar')", (string)$result);
	}

	public function testUpdate()
	{
		$result = $this->query->update(self::TABLE, ['name' => 'bar']);
		Assert::type('\Dibi\Fluent', $result);
		Assert::same("UPDATE `foo` SET `name`='bar'", (string)$result);
	}

	public function testDelete()
	{
		$result = $this->query->delete(self::TABLE);
		Assert::type('\DibiFluent', $result);
		Assert::same("DELETE FROM `foo`", (string)$result);
	}

	public function testSingleSelect()
	{
		$result = $this->query->select('name')->from(self::TABLE);
		Assert::type('\Dibi\Fluent', $result);
		Assert::same("SELECT `name` FROM `foo`", (string)$result);
	}

	public function testMultipleSelectors()
	{
		$result = $this->query->select('name, date')->from(self::TABLE);
		Assert::type('\Dibi\Fluent', $result);
		Assert::same("SELECT name, date FROM `foo`", (string)$result);
	}

	public function testStringsSelector()
	{
		$result = $this->query->select(['name', 'email'])->from(self::TABLE);
		Assert::type('\Dibi\Fluent', $result);
		Assert::same("SELECT name, email FROM `foo`", (string)$result);
	}

	public function testInvalidArraySelector()
	{
		Assert::exception(function () {
			$this->query->select([1]);
		}, 'Kappa\Deaw\InvalidArgumentException');
	}

	public function testInvalidSingleSelector()
	{
		Assert::exception(function () {
			$this->query->select(1);
		}, 'Kappa\Deaw\InvalidArgumentException');
	}
}

\run(new QueryTest(getDatabaseConnection()));
