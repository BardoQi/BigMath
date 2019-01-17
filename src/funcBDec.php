<?php
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
    function BDec(string $value = '0'):BigDecimal
    {
        return BigDecimal::of($value);
    }
}