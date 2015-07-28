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

use Kappa\Deaw\TableFactory;
use Nette\DI\Container;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class DeawExtensionTest
 *
 * @package Kappa\Deaw\Tests
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
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

	public function testTableManager()
	{
		$type = 'Kappa\Deaw\TableFactory';
		/** @var TableFactory $service */
		$service = $this->container->getByType($type);
		Assert::type($type, $service);
		Assert::type('Kappa\Deaw\Table', $service->create("user"));
	}
}

\run(new DeawExtensionTest(getContainer()));
