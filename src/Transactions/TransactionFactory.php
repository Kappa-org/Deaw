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

/**
 * Class TransactionFactory
 * @package Kappa\Deaw
 */
class TransactionFactory
{
    /** @var DibiWrapper */
    private $wrapper;

    /**
     * TransactionFactory constructor.
     * @param DibiWrapper $dibiWrapper
     */
    public function __construct(DibiWrapper $dibiWrapper)
    {
        $this->wrapper = $dibiWrapper;
    }

    /**
     * Create a new Transaction
     * @return Transaction
     */
    public function create()
    {
        return new Transaction($this->wrapper);
    }
}