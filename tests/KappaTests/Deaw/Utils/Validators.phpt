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

use Kappa\Deaw\Utils\Validators;
use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class ValidatorsTest
 *
 * @package KappaTests\Deaw\Utils
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class ValidatorsTest extends TestCase
{
	/**
	 * @param bool $expected
	 * @param string|array $select
	 * @dataProvider provideIsSelectValidData
	 */
	public function testIsSelectValid($expected, $select)
	{
		Assert::same($expected, Validators::isSelectValid($select));
	}

	public function provideIsSelectValidData()
	{
		return [
			[true, 'foo'],
			[true, ['foo' => 'bar']],
			[false, 4],
			[false, [1 => 'foo']],
			[false, ['foo' => 1]],
			[false, ""],
			[false, ["" => "foo"]],
			[false, ["foo" => ""]]
		];
	}
}

\run(new ValidatorsTest());
