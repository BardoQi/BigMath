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
use BardoQi\BigMath\BigInteger;

/**
 * global function
 */
if (!function_exists('BInt')){
    /**
     * @param string $value
     * @return BigInteger
     */
    function BInt($value = '0'):BigInteger
    {
        return BigInteger::of($value);
    }
}

/**
 * global function
 */
if (!function_exists('_bi')){
    /**
     * @param BigInteger $value
     * @return BigInteger
     */
    function _bi(BigInteger $value):BigInteger
    {
        return $value;
    }
}