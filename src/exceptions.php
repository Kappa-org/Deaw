<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw;

/**
 * Class InvalidSelectDefinitionException
 *
 * @package Kappa\Deaw
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class InvalidSelectDefinitionException extends \LogicException {}

/**
 * Class InvalidArgumentsException
 *
 * @package Kappa\Deaw
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class InvalidArgumentException extends \LogicException {}

/**
 * Class MissingBuilderReturn
 *
 * @package Kappa\Deaw
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class MissingBuilderReturnException extends \LogicException {}
