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

namespace KappaTests\Deaw\Utils;

use Kappa\Deaw\Utils\SelectFactory;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class SelectFactoryTest
 * @package KappaTests\Deaw\Utils
 */
class SelectFactoryTest extends TestCase 
{
    /**
     * @param string $expected
     * @param string $actual
     * @dataProvider dataProvideFormat
     */
    public function testFormat($expected, $actual)
    {
        Assert::same($expected, $actual);
    }

    /**
     * @return array
     */
    public function dataProvideFormat()
    {
        return [
            // Without table and prefix
            ['id, name, email', SelectFactory::format('id, name,email')],

            // With table without prefix
            ['users.id, users.name, users.email', SelectFactory::format('id, name,email', 'users')],
            
            // With prefix without table
            ['id as prefix_id, name as prefix_name, email as prefix_email', SelectFactory::format('id, name,email', null, 'prefix')],
            
            // With prefix with table
            ['users.id as prefix_id, users.name as prefix_name, users.email as prefix_email', SelectFactory::format('id, name,email', 'users', 'prefix')],
            
            // Prefix with custom alias
            ['id as prefix_id, name as prefix_name, email as extra_email', SelectFactory::format('id, name,email as extra_email', null, 'prefix')]
        ];
    }
}


\run(new SelectFactoryTest);
