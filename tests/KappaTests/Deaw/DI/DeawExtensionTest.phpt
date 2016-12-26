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

namespace Kappa\Deaw\Tests;

use Kappa\Deaw\Query\QueryBuilder;
use Kappa\Deaw\Table;
use Kappa\Deaw\Transactions\TransactionFactory;
use Kappa\Deaw\Utils\DibiWrapper;
use Nette\DI\Container;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class DeawExtensionTest
 * @package Kappa\Deaw\Tests
 */
class DeawExtensionTest extends TestCase
{
    /** @var Container */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function testTable()
    {
        $type = 'Kappa\Deaw\Table';
        /** @var Table $service */
        $service = $this->container->getByType($type);
        Assert::type($type, $service);
    }

    public function testDibiWrapper()
    {
        $type = 'Kappa\Deaw\Utils\DibiWrapper';
        /** @var DibiWrapper $service */
        $service = $this->container->getByType($type);
        Assert::type($type, $service);
    }

    public function testQueryBuilder()
    {
        $type = 'Kappa\Deaw\Query\QueryBuilder';
        /** @var QueryBuilder $service */
        $service = $this->container->getByType($type);
        Assert::type($type, $service);
    }

    public function testTransactionFactory()
    {
        $type = 'Kappa\Deaw\Transactions\TransactionFactory';
        /** @var TransactionFactory $service */
        $service = $this->container->getByType($type);
        Assert::type($type, $service);
    }
}

\run(new DeawExtensionTest(getContainer()));
