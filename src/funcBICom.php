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
use BardoQi\BigMath\BigIComplex;

/**
 * global function
 */
if (!function_exists('BICom')){
    /**
     * @param string $r
     * @param string $i
     * @return \BardoQi\BigMath\BigIComplex
     */
    function BICom($r ='0', $i='0' ):BigIComplex
    {
        return BigIComplex::of($r,$i);
    }
}

/**
 * global function
 */
if (!function_exists('_bic')){
    /**
     * @param BigIComplex $value
     * @return BigIComplex
     */
    function _bic(BigIComplex $value):BigIComplex
    {
        return $value;
    }
}