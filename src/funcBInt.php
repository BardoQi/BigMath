<?php

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
    function BInt(string $value = '0'):BigInteger
    {
        return BigInteger::of($value);
    }
}