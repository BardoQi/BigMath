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
use BardoQi\BigMath\BigDComplex;

/**
 * global function
 */
if (!function_exists('BDCom')){
    /**
     * @param string $r
     * @param string $i
     * @return \BardoQi\BigMath\BigDComplex
     */
    function BDCom($r ='0', $i='0' ):BigDComplex
    {
        return BigDComplex::of($r,$i);
    }
}

/**
 * global function
 */
if (!function_exists('_bdc')){
    /**
     * @param BigDComplex $value
     * @return BigDComplex
     */
    function _bdc(BigDComplex $value):BigDComplex
    {
        return $value;
    }
}