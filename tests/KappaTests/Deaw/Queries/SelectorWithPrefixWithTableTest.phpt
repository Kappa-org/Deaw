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
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class SelectorTest
 *
 * @package KappaTests\Deaw\Queries
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class SelectorWithPrefixWithTableTest extends TestCase
{
	/** @var Selector */
	private $selector;

	protected function setUp()
	{
		$this->selector = new Selector("bar", "foo");
	}

	public function testSetSelects()
	{
		Assert::type(get_class($this->selector), $this->selector->setSelects(["foo", ["bar" => "bar2"]]));
		Assert::equal(["foo" => "", "bar" => "bar2"], $this->selector->getSelects());
	}

	public function testAddSelect()
	{
		Assert::type(get_class($this->selector), $this->selector->addSelect("foo"));
		Assert::equal(["foo" => ""], $this->selector->getSelects());
	}

	public function testGetSelects()
	{
		Assert::type(get_class($this->selector), $this->selector->setSelects(["foo", ["bar" => "bar2"]]));
		Assert::equal(["foo" => "", "bar" => "bar2"], $this->selector->getSelects());
	}

	public function testToString()
	{
		Assert::same("`bar`.foo as foo_foo,`bar`.bar as foo_bar2", (string)$this->selector->setSelects(["foo", ["bar" => "bar2"]]));
	}
}

\run(new SelectorWithPrefixWithTableTest());
