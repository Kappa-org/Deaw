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

namespace KappaTests\Deaw\BasicSelectors;

use Kappa\Deaw\BasicSelectors\Count;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class Count
 *
 * @package KappaTests\Deaw\BasicSelectors
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class CountTest extends TestCase
{
	private $selector;

	protected function setUp()
	{
		$this->selector = new Count();
		$this->selector->configure();
	}

	public function testToString()
	{
		Assert::same('COUNT(*)', (string)$this->selector);
	}
}

\run(new CountTest());
