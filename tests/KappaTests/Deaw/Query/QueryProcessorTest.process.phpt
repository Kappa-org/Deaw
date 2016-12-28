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

namespace KappaTests\Deaw\Utils;

use Kappa\Deaw\Query\QueryProcessor;
use KappaTests\Deaw\Tests\FetchQueryObject;
use KappaTests\Deaw\Tests\InvalidQueryObject;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class DibiWrapperTest
 * @package KappaTests\Deaw\Utils
 */
class QueryProcessorTest extends TestCase
{
    /** @var DibiWrapper */
    private $dibiWrapper;

    protected function setUp()
    {
        $connectionMock = \Mockery::mock('\DibiConnection');
        $dibiFluent = new \DibiFluent($connectionMock);
        $queryBuilderMock = \Mockery::mock('\Kappa\Deaw\Query\QueryBuilder');
        $queryBuilderMock->shouldReceive('createQuery')->once()->andReturn($dibiFluent);

        $this->dibiWrapper = new QueryProcessor($queryBuilderMock);
    }

    public function testValidQuery()
    {
        Assert::type('\DibiFluent', $this->dibiWrapper->process(new FetchQueryObject()));
    }

    public function testInvalidQuery()
    {
        Assert::exception(function () {
            $this->dibiWrapper->process(new InvalidQueryObject());
        }, '\Kappa\Deaw\MissingBuilderReturnException');
    }
}


\run(new QueryProcessorTest);
