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

use Dibi\Row;
use Kappa\Deaw\DataAccess;
use Kappa\Deaw\Query\QueryBuilder;
use Kappa\Deaw\Transactions\Transaction;
use Kappa\Deaw\Transactions\TransactionFactory;
use Kappa\Deaw\Utils\DibiWrapper;
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

    /** @var \DibiConnection */
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
        $this->connection = new \DibiConnection($this->config);
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
        $this->table = new DataAccess(new DibiWrapper(new QueryBuilder($this->connection, 'user')), new TransactionFactory($this->connection));
    }

    public function testFetch()
    {
        Assert::equal([
            new \DibiRow(['id' => 1, 'name' => 'foo', 'string' => 'text']),
            new \DibiRow(['id' => 2, 'name' => 'bar', 'string' => 'text'])
        ], $this->table->fetch(new FetchQueryObject()));
    }

    public function testFetchOne()
    {
        Assert::equal(new \DibiRow(['id' => 1, 'name' => 'foo', 'string' => 'text']), $this->table->fetchOne(new FetchOneQueryObject()));
    }

    public function testFetchSingle()
    {
        Assert::same(FetchSingleQueryObject::ID, $this->table->fetchSingle(new FetchSingleQueryObject()));
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

    public function testTransactionalRollback()
    {
        Assert::same(2, $this->connection->select('COUNT(*)')->from('user')->fetchSingle());
        $this->table->transactional(function (Transaction $transaction) {
            $this->table->execute(new ExecutableQueryObject());
            $transaction->rollback();
        });
        Assert::same(2, $this->connection->select('COUNT(*)')->from('user')->fetchSingle());
    }

    public function testTransactionalCommit()
    {
        Assert::same(2, $this->connection->select('COUNT(*)')->from('user')->fetchSingle());
        $this->table->transactional(function (Transaction $transaction) {
            $this->table->execute(new ExecutableQueryObject());
            $transaction->commit();
        });
        Assert::same(3, $this->connection->select('COUNT(*)')->from('user')->fetchSingle());
    }

    public function testTransactionalSavepoint()
    {
        Assert::same(2, $this->connection->select('COUNT(*)')->from('user')->fetchSingle());
        $this->table->transactional(function (Transaction $transaction) {
            $this->table->execute(new ExecutableQueryObject());
            $savepoint = $transaction->savepoint();
            $this->table->execute(new ExecutableQueryObject());
            $savepoint->rollback();
            $transaction->commit();
        });
        Assert::same(3, $this->connection->select('COUNT(*)')->from('user')->fetchSingle());
    }

    protected function tearDown()
    {
        $this->connection->query("DROP TABLE IF EXISTS `user`;");
    }
}

Environment::lock("database", dirname(TEMP_DIR));

\run(new DataAccessTest(getDatabaseConnection()));
