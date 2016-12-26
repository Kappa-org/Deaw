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

use Dibi\Connection;
use Kappa\Deaw\Transactions\Savepoint;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class SavepointTest
 * @package KappaTests\Deaw\Transactions
 */
class SavepointTest extends TestCase 
{
    public function testNewSavepoint()
    {
        $connectionMock = \Mockery::mock('Dibi\Connection');
        $connectionMock->shouldReceive('begin')->once()->andReturnNull();
        $savepoint1 = new Savepoint($connectionMock);
        $savepoint2 = new Savepoint($connectionMock);
        Assert::notSame($savepoint1->getName(), $savepoint2->getName());
    }
}


\run(new SavepointTest);
