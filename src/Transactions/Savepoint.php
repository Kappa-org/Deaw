<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\Transactions;

use Kappa\Deaw\Dibi\DibiWrapper;
use Nette\Utils\Random;

/**
 * Class Savepoint
 * @package Kappa\Deaw
 */
class Savepoint
{
    /** @var string */
    private $name;

    /** @var DibiWrapper */
    private $wrapper;

    /**
     * Savepoint constructor.
     * @param DibiWrapper $dibiWrapper
     */
    public function __construct(DibiWrapper $dibiWrapper)
    {
        $this->name = Random::generate() . time();
        $this->wrapper = $dibiWrapper;
        $this->wrapper->getConnection()->begin($this->name);
    }

    /**
     * Rollback savepoint
     */
    public function rollback()
    {
        $this->wrapper->getConnection()->rollback($this->name);
    }

    /**
     * Release savepoint
     */
    public function release()
    {
        $this->wrapper->getConnection()->commit($this->name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}