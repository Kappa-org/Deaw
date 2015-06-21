<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\BasicSelectors;

use Kappa\Deaw\Queries\Selector;

/**
 * Class SelectAll
 *
 * @package Kappa\Deaw\BasicSelectors
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class SelectAll extends Selector
{
	public function configure()
	{
		$this->setSelects(['*']);
	}
}
