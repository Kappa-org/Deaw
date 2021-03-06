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
use Dibi\Event;
use Dibi\Row;
use Kappa\Deaw\DataAccess;
use Kappa\Deaw\Dibi\DibiWrapper;
use Kappa\Deaw\Query\QueryBuilder;
use Kappa\Deaw\Query\QueryProcessor;
use Kappa\Deaw\Transactions\Transaction;
use Kappa\Deaw\Transactions\TransactionFactory;
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
 * Class DataAccessTest
 * @package KappaTests\Deaw
 */
class DataAccessTest extends TestCase
{
	const TABLE = 'user';

	/** @var DataAccess */
	private $table;

	/** @var \DibiConnection|\Dibi\Connection */
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
			) ENGINE='InnoDB' COLLATE 'utf8_czech_ci';"
		);
		$this->connection->query("INSERT INTO `user` (`name`, `string`) VALUES ('foo', 'text')");
		$this->connection->query("INSERT INTO `user` (`name`, `string`) VALUES ('bar', 'text')");
		$dibiWrapper = new DibiWrapper($this->connection);
		$this->table = new DataAccess(new QueryProcessor(new QueryBuilder($dibiWrapper, 'user')), new TransactionFactory($dibiWrapper));
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

	public function testFetchAssoc()
	{
		Assert::equal([
			1 => new Row(['id' => 1, 'name' => 'foo', 'string' => 'text']),
			2 => new Row(['id' => 2, 'name' => 'bar', 'string' => 'text']),
		], $this->table->fetchAssoc(new FetchQueryObject(), 'id'));
	}

	public function testFetchPairs()
	{
		Assert::equal([
			1 => 'foo',
			2 => 'bar'
		], $this->table->fetchPairs(new FetchQueryObject(), 'id', 'name'));
	}

	public function testExecute()
	{
		Assert::same(3, $this->table->execute(new ExecutableQueryObject(), \dibi::IDENTIFIER));
	}

	public function testInvalidQueryObject()
	{
		Assert::exception(function () {
			$this->table->execute(new InvalidQueryObject());
		}, 'Kappa\Deaw\MissingBuilderReturnException');

		Assert::exception(function () {
			$this->table->fetch(new InvalidQueryObject());
		}, 'Kappa\Deaw\MissingBuilderReturnException');

		Assert::exception(function () {
			$this->table->fetchOne(new InvalidQueryObject());
		}, 'Kappa\Deaw\MissingBuilderReturnException');

		Assert::exception(function () {
			$this->table->fetchSingle(new InvalidQueryObject());
		}, 'Kappa\Deaw\MissingBuilderReturnException');
	}

	public function testSimpleTransactionCommit()
	{
		$results = [];
		$this->connection->onEvent[] = function (Event $e) use (&$results) {
			$results[] = [$e->type, $e->sql];
		};
		$transaction = $this->table->createTransaction();
		$this->table->execute(new ExecutableQueryObject());
		$transaction->commit();

		Assert::null($transaction->getSavepointName());
		Assert::equal($results, [
			[Event::BEGIN, ""],
			[Event::INSERT, "INSERT INTO `user` (`name`) VALUES ('bar')"],
			[Event::COMMIT, ""]
		]);
	}

	public function testSimpleTransactionRollback()
	{
		$results = [];
		$this->connection->onEvent[] = function (Event $e) use (&$results) {
			$results[] = [$e->type, $e->sql];
		};
		$transaction = $this->table->createTransaction();
		$this->table->execute(new ExecutableQueryObject());
		$transaction->rollback();

		Assert::null($transaction->getSavepointName());
		Assert::equal($results, [
			[Event::BEGIN, ""],
			[Event::INSERT, "INSERT INTO `user` (`name`) VALUES ('bar')"],
			[Event::ROLLBACK, ""]
		]);
	}

	public function testNestedTransactions()
	{
		$results = [];
		$this->connection->onEvent[] = function (Event $e) use (&$results) {
			$results[] = [$e->type, $e->sql];
		};
		$transaction1 = $this->table->createTransaction();
		$this->table->execute(new ExecutableQueryObject());
		$transaction2 = $this->table->createTransaction();
		$this->table->execute(new ExecutableQueryObject());
		$transaction2->commit();
		$transaction1->commit();

		Assert::null($transaction1->getSavepointName());
		Assert::notSame(null, $transaction2->getSavepointName());
		Assert::equal($results, [
			[Event::BEGIN, ""],
			[Event::INSERT, "INSERT INTO `user` (`name`) VALUES ('bar')"],
			[Event::BEGIN, "{$transaction2->getSavepointName()}"],
			[Event::INSERT, "INSERT INTO `user` (`name`) VALUES ('bar')"],
			[Event::COMMIT, "{$transaction2->getSavepointName()}"],
			[Event::COMMIT, ""]
		]);
	}

	protected function tearDown()
	{
		$this->connection->query("DROP TABLE IF EXISTS `user`;");
	}
}

Environment::lock("database", dirname(TEMP_DIR));

\run(new DataAccessTest(getDatabaseConnection()));
