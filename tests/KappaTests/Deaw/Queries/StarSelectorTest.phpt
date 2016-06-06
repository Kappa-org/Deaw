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

use Kappa\Deaw\Queries\Selector;
use KappaTests\Deaw\AllSelector;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class StarSelectorTest
 *
 * @package KappaTests\Deaw\Queries
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class StarSelectorTest extends TestCase
{
	public function testWithTable()
	{
		$selector = new AllSelector("foo");
		$selector->configure();
		Assert::same('`foo`.*', (string)$selector);
	}

	public function testWithPrefix()
	{
		$selector = new AllSelector(null, "foo");
		$selector->configure();
		Assert::same('*', (string)$selector);
	}

	public function testWithTableAndPrefix()
	{
		$selector = new AllSelector("foo", "bar");
		$selector->configure();
		Assert::same('`foo`.*', (string)$selector);
	}

	public function testWithoutAll()
	{
		$selector = new AllSelector();
		$selector->configure();
		Assert::same('*', (string)$selector);
	}
}

\run(new StarSelectorTest());
