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

namespace KappaTests\Deaw\Query;

use KappaTests\Deaw\Tests\QueryObjectCustomPostFetch;
use KappaTests\Deaw\Tests\QueryObjectDefaultPostFetch;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class QueryObjectTest
 * @package KappaTests\Deaw\Queries
 */
class QueryObjectTest extends TestCase 
{
    public function testPostFetch()
    {
        $customQueryObject = new QueryObjectCustomPostFetch();
        Assert::same(QueryObjectCustomPostFetch::POST_FETCH_RETURN, $customQueryObject->postFetch('foo'));

        $defaultQueryObject = new QueryObjectDefaultPostFetch();
        Assert::same('foo', $defaultQueryObject->postFetch('foo'));
    }
}


\run(new QueryObjectTest());
