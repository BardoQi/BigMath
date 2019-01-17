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

/**
 * A Bc Math value.
 * The class is a extension for Bc Math functions.
 */
class BigDecimal
{
    /**
     * The value represented as a Bc Math string.
     *
     * @var string
     */
    public $value;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $value, The value to set.
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Converts this class to a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @return BigDecimal
     */
    public function copy(){
        return self::of($this->value);
    }

    /**
     * @return BigDecimal
     */
    public function clone(){
        return self::of($this->value);
    }

    /**
     * @return BigDecimal
     */
    public function __clone(){
        return self::of($this->value);
    }
 
    /**
     * Converts the value to an absolute number.
     *
     * @return BigDecimal
     */
    public function abs(): BigDecimal
    {
        if ($this->lt(BDec('0'))){
            return $this->mul(BDec('-1'));
        }
        return $this;
    }

    /**
     * Adds the given value to this value.
     *
     * @param BigDecimal $b The value to add.
     * @return BigDecimal
     */
    public function add(BigDecimal $b): BigDecimal
    {
        $result = bcadd($this->value,$b->value);
        return self::of($result);
    }

    /**
     * Compares this number and the given number.
     *
     * @param BigDecimal $b The value to compare.
     * @return int Returns -1 is the number is less than this number. 0 if equal and 1 when greater.
     */
    public function compareTo(BigDecimal $b): int
    {
        return $this->cmp($b);
    }

    /**
     * Compares this number and the given number.
     *
     * @param BigDecimal $b The value to compare.
     * @return int Returns -1 is the number is less than this number. 0 if equal and 1 when greater.
     */
    public function cmp(BigDecimal $b): int
    {
        return bccomp($this->value, $b->value);
    }

    /**
     * Divides this value by the given value.
     *
     * @param BigDecimal $b The value to divide by.
     * @return BigDecimal
     */
    public function divide(BigDecimal $b): BigDecimal
    {
        return $this->div($b);
    }

    /**
     * Divides this value by the given value.
     *
     * @param BigDecimal $b The value to divide by.
     * @return BigDecimal
     */
    public function div(BigDecimal $b): BigDecimal
    {
        if ($b->isZero()){
            throw DivisionByZeroException::divisionByZero();
        }
        $result = bcdiv($this->value, $b->value);

        return self::of($result);
    }

    /**
     * Divides this value by the given value.
     *
     * @param BigDecimal $b The value to divide by.
     * @return BigDecimal
     */
    public function divideQ(BigDecimal $b): BigDecimal
    {
        return $this->divq($b);
    }

    /**
     * Divides this value by the given value.
     *
     * @param BigDecimal $b The value to divide by.
     * @return BigDecimal
     */
    public function divq(BigDecimal $b): BigDecimal
    {
        if ($b->isZero()){
            throw DivisionByZeroException::divisionByZero();
        }
        $reminder = $this->mod($b);
        $divisor = $this->subtract($reminder);
        $result = bcdiv($divisor->value, $b->value);
        return self::of($result);
    }

    /**
     * Divides this value by the given value.
     *
     * @param BigDecimal $b The value to divide by.
     * @param BigDecimal $reminder
     * @return BigDecimal
     */
    public function divideQr(BigDecimal $b,BigDecimal &$reminder): BigDecimal
    {
        return $this->divqr($b,$reminder);
    }

    /**
     * Divides this value by the given value.
     *
     * @param BigDecimal $b The value to divide by.
     * @param BigDecimal $reminder
     * @return BigDecimal
     */
    public function divqr(BigDecimal $b,BigDecimal &$reminder): BigDecimal
    {
        if ($b->isZero()){
            throw DivisionByZeroException::divisionByZero();
        }
        $reminder = $this->mod($b);
        $divisor = $this->subtract($reminder);
        $result = bcdiv($divisor->value, $b->value);
        return self::of($result);
    }

    /**
     * Check this number is equivalent to the given.
     *
     * @param BigDecimal $b The value to compare.
     * @return bool
     */
    public function equals(BigDecimal $b): bool
    {
        return $this->eq($b);
    }

    /**
     * Check this number is equivalent to the given.
     *
     * @param BigDecimal $b The value to compare.
     * @return bool
     */
    public function eq(BigDecimal $b): bool
    {
        $result = $this->cmp($b);
        return ($result == 0);
    }

    /**
     * Check this number is not equivalent to the given.
     *
     * @param BigDecimal $b The value to compare.
     * @return bool
     */
    public function ne(BigDecimal $b): bool
    {
        $result = $this->cmp($b);
        return ($result != 0);
    }

    /**
     * Check this number is not equivalent to the given.
     *
     * @param BigDecimal $b The value to compare.
     * @return bool
     */
    public function notEquals(BigDecimal $b): bool
    {
        return $this->ne($b);
    }

    /**
     * Check if the number is even
     *
     * @return bool
     */
    public function even(): bool
    {
        return ($this->mod(BDec('2'))==0);
    }

    /**
     * Gets the value of the big integer.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Check if the value more than the given.
     *
     * @param BigDecimal $b The value to check with.
     * @return bool
     */
    public function greaterThan(BigDecimal $b): bool
    {

        return $this->gt($b);
    }

    /**
     * Check if the value more than the given.
     *
     * @param BigDecimal $b The value to check with.
     * @return bool
     */
    public function gt(BigDecimal $b): bool
    {
        $result = $this->cmp($b);

        return ($result==1);
    }

    /**
     * Check if the value greater than or equals to the given.
     *
     * @param BigDecimal $b The value to check with.
     * @return bool
     */
    public function greaterThanOrEqualsTo(BigDecimal $b): bool
    {

        return $this->gte($b);
    }

    /**
     * Check if the value greater than or equals to the given.
     *
     * @param BigDecimal $b The value to check with.
     * @return bool
     */
    public function gte(BigDecimal $b): bool
    {
        return ($this->cmp($b)>=0);
    }

    /**
     *
     * Checks if the big integr equals one.
     *
     * @return bool
     */
    public function isOne():bool
    {
        return ($this->cmp(BDec('1'))==0);
    }

    /**
     *
     * Checks if the big integr equals zero.
     *
     * @return bool
     */
    public function isZero():bool
    {
        return ($this->cmp(BDec('0'))==0);
    }

    /**
     * Check if the value less than the given.
     *
     * @param BigDecimal $b The value to check with.
     * @return bool
     */
    public function lessThan(BigDecimal $b): bool
    {
        return   $this->lt($b);
    }

    /**
     * Check if the value less than the given.
     *
     * @param BigDecimal $b The value to check with.
     * @return bool
     */
    public function lt(BigDecimal $b): bool
    {
        $result = $this->cmp($b);

        return ($result==-1);


    }

    /**
     * Check if the value less than or equals to the given.
     *
     * @param BigDecimal $b The value to check with.
     * @return bool
     */
    public function lessThanOrEqualsTo(BigDecimal $b): bool
    {
        return  $this->lte($b);
    }

    /**
     * Check if the value less than or equals to the given.
     *
     * @param BigDecimal $b The value to check with.
     * @return bool
     */
    public function lte(BigDecimal $b): bool
    {
        return  ($this->cmp($b)<=0);

    }

    /**
     * Returns the maximum of the two BigDecimal values.
     *
     * @param BigDecimal $b  One of the two values to be tested.
     * @return BigDecimal.
     */
    public function max(BigDecimal $b): BigDecimal
    {
        $result = $this->cmp($b);
        if ($result>=0){
            $max=$this->value;
        }else{
            $max=$b->value;
        }
        return self::of($max);
    }

    /**
     * Returns the mininum of the two BigDecimal values.
     *
     * @param BigDecimal $b  One of the two values to be tested.
     * @return BigDecimal.
     */
    public function min(BigDecimal $b): BigDecimal
    {
        $result = $this->cmp($b);
        if ($result>=0){
            $min=$b->value;
        }else{
            $min=$this->value;
        }
        return self::of($min);
    }

    /**
     * The opertor "--"
     * Returns the difference of this number and the given one.
     *
     * @param mixed $b
     * @return BigDecimal
     */
    public function minus($b = 1): BigDecimal
    {
        if(is_numeric($b)){
            $b = BigDecimal::of($b);
        }
        $this->value = bcsub($this->value, $b->value);
        return $this;
    }

    /**
     * The opertor "--"
     * Returns the difference of this number and the given one.
     *
     * @param mixed $b
     * @return BigDecimal
     */
    public function decrement($b = 1): BigDecimal
    {
        return $this->minus($b);
    }
    /**
     * Performs a modulo operation with the given number.
     *
     * @param BigDecimal $b The value to perform a modulo operation with.
     * @return BigDecimal
     */
    public function mod(BigDecimal $b): BigDecimal
    {
        if ($b->isZero()){
            throw DivisionByZeroException::divisionByZero();
        }
        $result = bcmod($this->value, $b->value);

        return self::of($result);
    }


    /**
     * Multiplies the given value with this value.
     *
     * @param BigDecimal $b The value to multiply with.
     * @return BigDecimal
     */
    public function multiply(BigDecimal $b): BigDecimal
    {
        return $this->mul($b);
    }

    /**
     * Multiplies the given value with this value.
     *
     * @param BigDecimal $b The value to multiply with.
     * @return BigDecimal
     */
    public function mul(BigDecimal $b): BigDecimal
    {
        $result = bcmul($this->value, $b->value);

        return self::of($result);
    }

    /**
     * Negates the value.
     *
     * @return BigDecimal
     */
    public function negate(): BigDecimal
    {
        return $this->mul(BDec('-1'));
    }

    /**
     * Check if the number is odd
     *
     * @return bool
     */
    public function odd(): bool
    {
        return ($this->mod(BDec('2'))==1);
    }

    /**
     * Create a new instance
     * @param string $value
     * @return BigDecimal
     */
    public static function of(string $value): BigDecimal
    {
        return new BigDecimal ($value);
    }

    /**
     * The opertor "++"
     * Returns the sum of this number and the given one.
     *
     * @param mixed $b
     * @return BigDecimal
     */
    public function plus($b = 1): BigDecimal
    {
        if (is_numeric($b)){
            $b=BigDecimal::of($b);
        }
        $this->value = bcadd($this->value, $b->value);
        return $this;
    }

    /**
     * The opertor "++"
     * Returns the sum of this number and the given one.
     *
     * @param mixed $b
     * @return BigDecimal
     */
    public function increment($b = 1): BigDecimal
    {
        return $this->plus($b);
    }

    /**
     * Performs a power operation with the given number.
     *
     * @param BigDecimal $exp, The value to perform a power operation with.
     * @param int $scale
     * @return BigDecimal
     */
    public function power(BigDecimal $exp,int $scale = 2 ): BigDecimal
    {
        return $this->pow($exp,$scale);
    }

    /**
     * Performs a power operation with the given number.
     *
     * @param BigDecimal $exp, The value to perform a power operation with.
     * @param int $scale
     * @return BigDecimal
     */
    public function pow(BigDecimal $exp,int $scale = 2 ): BigDecimal
    {
        $result = bcpow($this->value, $exp->value, $scale);

        return self::of($result);
    }

    /**
     * Use the fast-exponentiation method to raise base to the power exponent with respect to the modulus modulus.
     *
     * @param BigDecimal $exp
     * @param BigDecimal $mdl
     * @param int $scale
     * @return BigDecimal
     */
    public function powMod(BigDecimal $exp,BigDecimal $mdl, int $scale = 2  ): BigDecimal
    {
        $result = bcpowmod($this->value, $exp->value, $mdl->value, $scale);

        return self::of($result);
    }

    /**
     * Set default scale parameter for all bc math functions
     *
     * @param int $scale
     * @return bool
     */
    public function scale(int $scale):bool
    {
        return bcscale($scale);
    }

    /**
     * Sets the value.
     *
     * @param string $value The value to set.
     * @return BigDecimal
     */
    public function setValue(string $value): BigDecimal
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Sign of number.
     *
     * @return int
     */
    public function sign(): int
    {
        return $this->compareTo(BDec('0'));
    }

    /**
     * Returns the integer square root of a BigDecimal.
     *
     * @return BigDecimal
     */
    public function squareRoot(): BigDecimal
    {
        return $this->sqr();
    }

    /**
     * Returns the integer square root of a BigDecimal.
     *
     * @return BigDecimal
     */
    public function sqr(): BigDecimal
    {
        $result = bcsqrt($this->value);

        return self::of($result);
    }

    /**
     * Subtracts the given value from this value.
     *
     * @param BigDecimal $b The value to subtract.
     * @return BigDecimal
     */
    public function subtract(BigDecimal $b): BigDecimal
    {
        return $this->sub($b);
    }

    /**
     * Subtracts the given value from this value.
     *
     * @param BigDecimal $b The value to subtract.
     * @return BigDecimal
     */
    public function sub(BigDecimal $b): BigDecimal
    {
        $result = bcsub($this->value, $b->value);
        return self::of($result);
    }

     /**
     * Converts this class to a string.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->getValue();
    }

    /**
     * Peforms string concat operation, returning the result.
     *
     * @param mixed $b
     * @return string
     */
    public function concat (BigDecimal $b): string{
        if ($b instanceof BigDecimal){
            $b = $b->toString();
        }
        return $this->toString() . $b;
    }

    /**
     * Check this number is identical to the given.
     * @param BigDecimal $b
     * @return bool
     */
    public function identical(BigDecimal $b):bool{
        return ($this === $b);
    }

    /**
     * Check this number is not identical to the given.
     * @param BigDecimal $b
     * @return bool
     */
    public function notIdentical(BigDecimal $b):bool{
        return ($this !== $b);
    }

    /**
     * Operator overload function
     * $o + $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __add($arg){
        return $this->add($arg);
    }
    /**
     * Operator overload function
     * $o - $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __sub($arg){
        return $this->sub($arg);
    }
    /**
     * Operator overload function
     * $o * $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __mul($arg){
        return $this->mul($arg);
    }
    /**
     * Operator overload function
     * $o / $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __div($arg){
        return $this->div($arg);
    }
    /**
     * Operator overload function
     * $o % $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __mod($arg){
        return $this->mod($arg);
    }
    /**
     * Operator overload function
     * $o ** $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __pow($arg){
        return $this->pow($arg);
    }

    /**
     * Operator overload function
     * $o . $arg
     * @param mixed $arg
     * @return string
     */
    public function __concat($arg){
        return $this->concat($arg);
    }
    /**
     * Operator overload function
     * $o === $arg
     * @param mixed $arg
     * @return bool
     */
    public function __is_identical($arg){
        return $this->identical($arg);
    }
    /**
     * Operator overload function
     * $o !== $arg
     * @param mixed $arg
     * @return bool
     */
    public function __is_not_identical($arg){
        return $this->notIdentical($arg);
    }
    /**
     * Operator overload function
     * $o == $arg
     * @param mixed $arg
     * @return bool
     */
    public function __is_equal($arg){
        return $this->eq($arg);
    }
    /**
     * Operator overload function
     * $o != $arg
     * @param mixed $arg
     * @return bool
     */
    public function __is_not_equal($arg){
        return $this->ne($arg);
    }
    /**
     * Operator overload function
     * $o < $arg
     * @param mixed $arg
     * @return bool
     */
    public function __is_smaller($arg){
        return $this->lt($arg);
    }
    /**
     * Operator overload function
     * $o <= $arg
     * @param mixed $arg
     * @return bool
     */
    public function __is_smaller_or_equal($arg){
        return $this->lte($arg);
    }
    /**
     * Operator overload function
     * $o > $arg
     * @param mixed $arg
     * @return bool
     */
    public function __is_greater($arg){
        return $this->gt($arg);
    }
    /**
     * Operator overload function
     * $o >= $arg
     * @param mixed $arg
     * @return bool
     */
    public function __is_greater_or_equal($arg){
        return $this->gte($arg);
    }
    /**
     * Operator overload function
     * $o <=> $arg
     * @param mixed $arg
     * @return int
     */
    public function __cmp($arg){
        return $this->cmp($arg);
    }
    /**
     * Operator overload function
     * ++$o
     * @return BigDecimal
     */
    public function __pre_inc(){
        return $this->plus();
    }
    /**
     * Operator overload function
     * $o++
     * @return BigDecimal
     */
    public function __post_inc(){
        return $this->plus();
    }
    /**
     * Operator overload function
     * --$o
     * @return BigDecimal
     */
    public function __pre_dec(){
        return $this->minus();
    }
    /**
     * Operator overload function
     * $o--
     * @return BigDecimal
     */
    public function __post_dec(){
        return $this->minus();
    }
    /**
     * Operator overload function
     * $o = $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __assign($arg){
        $this->value = $arg->value;
        return $this;
    }
    /**
     * Operator overload function
     * $o += $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __assign_add($arg){
        return $this->plus($arg);
    }
    /**
     * Operator overload function
     * $o -= $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __assign_sub($arg){
        return $this->minus($arg);
    }
    /**
     * Operator overload function
     * $o *= $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __assign_mul($arg){
        if(is_numeric($arg)){
            $arg = BigDecimal::of($arg);
        }
        $this->value = bcmul($this->value, $arg->value);
        return $this;
    }
    /**
     * Operator overload function
     * $o /= $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __assign_div($arg){
        if(is_numeric($arg)){
            $arg = BigDecimal::of($arg);
        }
        if ($arg->isZero()){
            throw DivisionByZeroException::divisionByZero();
        }
        $this->value = bcdiv($this->value, $arg->value);
        return $this;
    }
    /**
     * Operator overload function
     * $o %= $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __assign_mod($arg){
        if(is_numeric($arg)){
            $arg = BigDecimal::of($arg);
        }
        $this->value = bcmod($this->value, $arg->value);
        return $this;
    }
    /**
     * Operator overload function
     * $o **= $arg
     * @param mixed $arg
     * @return BigDecimal
     */
    public function __assign_pow($arg){
        if(is_numeric($arg)){
            $arg = BigDecimal::of($arg);
        }
        $this->value = bcpow($this->value, $arg->value);
        return $this;
    }

}

