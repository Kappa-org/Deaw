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

namespace KappaTests\Deaw\Queries;

use Kappa\Deaw\Queries\QueryBuilder;
use KappaTests\Deaw\DateSelector;
use KappaTests\Deaw\NameSelector;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class QueryBuilderTest
 *
 * @package KappaTests\Deaw\Queries
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
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
		$connection = new \DibiConnection($this->config);
		$this->queryBuilder = new QueryBuilder($connection, 'foo');
	}

	public function testInsert()
	{
		$result = $this->queryBuilder->insert(['name' => 'bar']);
		Assert::type("DibiFluent", $result);
		Assert::same("INSERT INTO `foo` (`name`) VALUES ('bar')", (string)$result);
	}

	public function testUpdate()
	{
		$result = $this->queryBuilder->update(['name' => 'bar']);
		Assert::type("DibiFluent", $result);
		Assert::same("UPDATE `foo` SET `name`='bar'", (string)$result);
	}

	public function testDelete()
	{
		$result = $this->queryBuilder->delete();
		Assert::type("DibiFluent", $result);
		Assert::same("DELETE FROM `foo`", (string)$result);
	}

	public function testSingleSelect()
	{
		$result = $this->queryBuilder->select(new NameSelector());
		Assert::type("DibiFluent", $result);
		Assert::same("SELECT `foo`.`name` FROM `foo`", (string)$result);
	}

	public function testMultipleSelectors()
	{
		$result = $this->queryBuilder->select([new NameSelector(), new DateSelector()]);
		Assert::type("DibiFluent", $result);
		Assert::same("SELECT foo.name,foo.date FROM `foo`", (string)$result);
	}

	public function testInvalidSelector()
	{
		Assert::exception(function () {
			$this->queryBuilder->select("dd");
		}, 'Kappa\Deaw\InvalidArgumentException');
	}
}

\run(new QueryBuilderTest(getDatabaseConnection()));
