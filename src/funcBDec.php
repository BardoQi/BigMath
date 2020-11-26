<?php
/**
 * BardoQi/BigMath (https://github.com/BardoQi/BigMath)
 *
 * @link https://github.com/BardoQi/BigMath for the canonical source repository
 * @copyright Copyright (c) 2015-2017 Bardo Qi (https://github.com/BardoQi/BigMath)
 * @license https://github.com/BardoQi/BigMath/LICENSE.md MIT
 */

declare(strict_types=1);

namespace BardoQi\BigMath;

use BardoQi\BigMath\Exceptions\DivisionByZeroException;
use BardoQi\BigMath\BigDecimal;

/**
 * global function
 */
if (!function_exists('BDec')){
    /**
     * @param string $value
     * @return BigDecimal
     */
    function BDec($value = '0'):BigDecimal
    {
        return BigDecimal::of($value);
    }
}

/**
 * global function
 */
if (!function_exists('_bd')){
    /**
     * @param BigDecimal $value
     * @return BigDecimal
     */
    function _bd(BigDecimal $value):BigDecimal
    {
        return $value;
    }
}