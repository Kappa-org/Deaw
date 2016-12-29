<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\DI;

use Nette\DI\CompilerExtension;

/**
 * Class DeawExtension
 * @package Kappa\Deaw\DI
 */
class DeawExtension extends CompilerExtension
{
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('queryBuilder'))
			->setClass('Kappa\Deaw\Query\QueryBuilder');

		$builder->addDefinition($this->prefix('queryProcessor'))
			->setClass('Kappa\Deaw\Query\QueryProcessor');

		$builder->addDefinition($this->prefix('dibiWrapper'))
			->setClass('Kappa\Deaw\Dibi\DibiWrapper');

		$builder->addDefinition($this->prefix('transactionFactory'))
			->setClass('Kappa\Deaw\Transactions\TransactionFactory');

		$builder->addDefinition($this->prefix('DataAccess'))
			->setClass('Kappa\Deaw\DataAccess');
	}
}