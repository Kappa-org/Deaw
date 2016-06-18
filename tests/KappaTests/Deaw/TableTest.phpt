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
use Dibi\Row;
use Kappa\Deaw\Query\QueryBuilder;
use Kappa\Deaw\Table;
use KappaTests\Deaw\Tests\ExecutableQueryObject;
use KappaTests\Deaw\Tests\FetchOneQueryObject;
use KappaTests\Deaw\Tests\FetchQueryObject;
use KappaTests\Deaw\Tests\FetchSingleQueryObject;
use KappaTests\Deaw\Tests\InvalidQueryObject;
use Tester\Environment;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class TableTest
 *
 * @package KappaTests\Deaw
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class TableTest extends TestCase
{
	const TABLE = 'user';

	/** @var Table */
	private $table;

	/** @var Connection */
	private $connection;

	/** @var array */
	private $config;

	/**
	 * @param array $config
	 */
	public function __construct($config)
	{
		$this->config = $config;
	}

	protected function setUp()
	{
		$this->connection = new Connection($this->config);
		$this->connection->query("DROP TABLE IF EXISTS `user`;");
		$this->connection->query("
			CREATE TABLE `user` (
				`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
				`name` varchar(255) NOT NULL,
				`string` varchar(255) NOT NULL
			) ENGINE='MyISAM' COLLATE 'utf8_czech_ci';"
		);
		$this->connection->query("INSERT INTO `user` (`name`, `string`) VALUES ('foo', 'text')");
		$this->connection->query("INSERT INTO `user` (`name`, `string`) VALUES ('bar', 'text')");
		$this->table = new Table(new QueryBuilder($this->connection, 'user'));
	}

	public function testFindAll()
	{
		// Default
		Assert::equal([
			new Row(['id' => 1, 'name' => 'foo', 'string' => 'text']),
			new Row(['id' => 2, 'name' => 'bar', 'string' => 'text'])
		], $this->table->findAll(self::TABLE));

		// With order
		Assert::equal([
			new Row(['id' => 2, 'name' => 'bar', 'string' => 'text']),
			new Row(['id' => 1, 'name' => 'foo', 'string' => 'text'])
		], $this->table->findAll(self::TABLE, ['id' => 'DESC']));

		// With limit
		Assert::equal([
			new Row(['id' => 1, 'name' => 'foo', 'string' => 'text'])
		], $this->table->findAll(self::TABLE, null, 1));

		// With offset
		Assert::equal([
			new Row(['id' => 2, 'name' => 'bar', 'string' => 'text'])
		], $this->table->findAll(self::TABLE, null, 1, 1));
	}

	public function testFindBy()
	{
		// Default
		Assert::equal([
			new Row(['id' => 1, 'name' => 'foo', 'string' => 'text']),
			new Row(['id' => 2, 'name' => 'bar', 'string' => 'text'])
		], $this->table->findBy(self::TABLE, ['string' => 'text']));

		// With order
		Assert::equal([
			new Row(['id' => 2, 'name' => 'bar', 'string' => 'text']),
			new Row(['id' => 1, 'name' => 'foo', 'string' => 'text'])
		], $this->table->findBy(self::TABLE, ['string' => 'text'], ['id' => 'DESC']));

		// With limit
		Assert::equal([
			new Row(['id' => 1, 'name' => 'foo', 'string' => 'text'])
		], $this->table->findBy(self::TABLE, ['string' => 'text'], null, 1));

		// With offset
		Assert::equal([
			new Row(['id' => 2, 'name' => 'bar', 'string' => 'text'])
		], $this->table->findBy(self::TABLE, ['string' => 'text'], null, 1, 1));

		// Where
		Assert::equal([
			new Row(['id' => 2, 'name' => 'bar', 'string' => 'text'])
		], $this->table->findBy(self::TABLE, ['id' => 2]));
	}

	public function testFindOneBy()
	{
		Assert::equal(new Row(['id' => 1, 'name' => 'foo', 'string' => 'text']), $this->table->findOneBy(self::TABLE, ['id' => 1]));
	}

	public function testFetch()
	{
		Assert::equal([
			new Row(['id' => 1, 'name' => 'foo', 'string' => 'text']),
			new Row(['id' => 2, 'name' => 'bar', 'string' => 'text'])
		], $this->table->fetch(new FetchQueryObject()));
	}

	public function testFetchOne()
	{
		Assert::equal(new Row(['id' => 1, 'name' => 'foo', 'string' => 'text']), $this->table->fetchOne(new FetchOneQueryObject()));
	}

	public function testFetchSingle()
	{
		Assert::same(FetchSingleQueryObject::ID, $this->table->fetchSingle(new FetchSingleQueryObject()));
	}

	public function testExecute()
	{
		Assert::same(3, $this->table->execute(new ExecutableQueryObject(), \dibi::IDENTIFIER));
	}

	public function testInsert()
	{
		Assert::same(2, $this->connection->select('COUNT(*)')->from(self::TABLE)->fetchSingle());
		$this->table->insert(self::TABLE, ['name' => 'foo foo', 'string' => 'text'])->execute();
		Assert::same(3, $this->connection->select('COUNT(*)')->from(self::TABLE)->fetchSingle());
	}

	public function testUpdate()
	{
		Assert::same('foo', $this->connection->select('name')->from(self::TABLE)->where('id = ?', 1)->fetchSingle());
		$this->table->update(self::TABLE, ['name' => 'foo foo'])->where('id = ?', 1)->execute();
		Assert::same('foo foo', $this->connection->select('name')->from(self::TABLE)->where('id = ?', 1)->fetchSingle());
	}

	public function testDelete()
	{
		Assert::same(2, $this->connection->select('COUNT(*)')->from(self::TABLE)->fetchSingle());
		$this->table->delete(self::TABLE)->where('id = ?', 2)->execute();
		Assert::same(1, $this->connection->select('COUNT(*)')->from(self::TABLE)->fetchSingle());
	}

	public function testInvalidQueryObject()
	{
		Assert::exception(function () {
			$this->table->execute(new InvalidQueryObject());
		}, 'Kappa\Deaw\MissingBuilderReturnException');
	}

	protected function tearDown()
	{
		$this->connection->query("DROP TABLE IF EXISTS `user`;");
	}
}

Environment::lock("database", dirname(TEMP_DIR));

\run(new TableTest(getDatabaseConnection()));
