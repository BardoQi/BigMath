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

use GMP;
use InvalidArgumentException;
use BardoQi\BigMath\Exceptions\DivisionByZeroException;


/**
 * A big integer value.
 * The class is a extension for gmp functions.
 * Except the gmp_intval, gmp_divexact, gmp_export, gmp_gcdext, gmp_import
 * and gmp_random, all other gmp functions are encapsulated in this class.
 */
class BigInteger
{
    /**
     * The value represented as a GMP resource.
     *
     * @var GMP
     */
    public $value;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $value, The value to set.
     */
    public function __construct(GMP $value)
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
     * @return BigInteger
     */
    public function copy(){
        return self::of($this->value);
    }

    /**
     * @return BigInteger
     */
    public function clone(){
        return self::of($this->value);
    }

    /**
     * @return BigInteger
     */
    public function __clone(){
        return self::of($this->value);
    }

    /**
     * Creates a new GMP object.
     *
     * @param string $value  The value to initialize with.
     * @return GMP
     * @throws InvalidArgumentException Thrown when the value is invalid.
     */
    public static function initValue(string $value): GMP
    {
        $result = @gmp_init($value);

        if ($result === false) {
            throw new InvalidArgumentException('The provided number is invalid.');
        }

        return $result;
    }

    /**
     * Converts the value to an absolute number.
     *
     * @return BigInteger
     */
    public function abs(): BigInteger
    {
        $result = gmp_abs($this->value);
        return self::of($result);
    }

    /**
     * Adds the given value to this value.
     *
     * @param BigInteger $b The value to add.
     * @return BigInteger
     */
    public function add(BigInteger $b): BigInteger
    {
        $result = gmp_add($this->value,$b->value);
        return self::of($result);
    }

    /**
     * Peforms a bitwise AND operation, returning the result.
     *
     * @param BigInteger $b The right hand value of the AND operation.
     * @return BigInteger
     */
    public function andBits(BigInteger $b): BigInteger
    {
        $result = gmp_and($this->value,$b->value);
        return self::of($result);
    }

    /**
     * Clears (sets to 0) bit index in a. The index starts at 0.
     *
     * @param int $index, The index of the bit to clear.
     *        Index 0 represents the least significant bit.
     * @return bool
     */
    public function clearBit(int $index): bool
    {
        if ($index>=0){
            gmp_clrbit($this->value,$index);
        }else{
            throw new InvalidArgumentException('The value of ondex should not be less than 0.');
        }
        return true;
    }

    /**
     * Compares this number and the given number.
     *
     * @param BigInteger $b The value to compare.
     * @return int  Returns -1 is the number is less than this number. 0 if equal and 1 when greater.
     */
    public function compareTo(BigInteger $b): int
    {
        return $this->cmp($b);
    }

    /**
     * Compares this number and the given number.
     *
     * @param BigInteger $b The value to compare.
     * @return int  Returns -1 is the number is less than this number. 0 if equal and 1 when greater.
     */
    public function cmp(BigInteger $b): int
    {
        $result = gmp_cmp($this->value, $b->value);

        // It could happen that gmp_cmp returns a value greater than one (e.g. gmp_cmp('123', '-123')). That's why
        // we do an additional check to make sure to return the correct value.
        return ($result <=> 0);
    }

    /**
     * Calculates one's complement
     *
     * @return BigInteger
     */
    public function complement(): BigInteger
    {
        $result = gmp_com($this->value);

        return self::of($result);
    }

    /**
     * Divides this value by the given value.
     *
     * @param BigInteger $b The value to divide by.
     * @return BigInteger
     */
    public function divide(BigInteger $b): BigInteger
    {
        return $this->div($b);
    }

    /**
     * Divides this value by the given value.
     *
     * @param BigInteger $b The value to divide by.
     * @return BigInteger
     */
    public function div(BigInteger $b): BigInteger
    {
        if ($b->isZero()){
            throw DivisionByZeroException::divisionByZero();
        }
        $result = gmp_div_q($this->value, $b->value, GMP_ROUND_ZERO);

        return self::of($result);
    }

    /**
     * Divides this value by the given value.
     *
     * @param BigInteger $b The value to divide by.
     * @param BigInteger $remainder The remainder returned.
     * @return BigInteger
     */
    public function divideRem(BigInteger $b, BigInteger &$remainder): BigInteger
    {
        return $this->divr($b,$remainder);
    }

    /**
     * Divides this value by the given value.
     *
     * @param BigInteger $b The value to divide by.
     * @param BigInteger $remainder The remainder returned.
     * @return BigInteger
     */
    public function divr(BigInteger $b, BigInteger &$remainder): BigInteger
    {
        if ($b->isZero()){
            throw DivisionByZeroException::divisionByZero();
        }
        $result = gmp_div_qr($this->value, $b->value, GMP_ROUND_ZERO);
        $remainder->value=$result[1];
        return self::of($result[0]);
    }

    /**
     * Check this number is equivalent to the given.
     *
     * @param BigInteger $b The value to compare.
     * @return bool.
     */
    public function equals(BigInteger $b): bool
    {
        return $this->eq($b);
    }

    /**
     * Check this number is equivalent to the given.
     *
     * @param BigInteger $b The value to compare.
     * @return bool.
     */
    public function eq(BigInteger $b): bool
    {
        $result = $this->cmp($b);
        return ($result == 0);
    }

    /**
     * Check this number is not equivalent to the given.
     *
     * @param BigInteger $b The value to compare.
     * @return bool.
     */
    public function ne(BigInteger $b): bool
    {
        $result = $this->cmp($b);
        return ($result != 0);
    }

    /**
     * Check this number is not equivalent to the given.
     *
     * @param BigInteger $b The value to compare.
     * @return bool.
     */
    public function notEquals(BigInteger $b): bool
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
        return (!$this->testbit(0));
    }

    /**
     * Calculates factorial of this value.
     *
     * @return BigInteger
     */
    public function factorial(): BigInteger
    {
        $result = gmp_fact($this->getValue());

        return self::of($result);
    }

    /**
     * Returns the greatest common divisor between the two BigInteger values..
     *
     * @param BigInteger $b  One of the values to find the GCD of.
     * @return BigInteger.
     */
    public function gcd(BigInteger $b): BigInteger
    {
        $result = gmp_gcd($this->value,$b->value);

        return self::of($result);
    }

    /**
     * Gets the value of the big integer.
     *
     * @return string
     */
    public function getValue(): string
    {
        return gmp_strval($this->value);
    }

    /**
     * Check if the value greater than the given.
     *
     * @param BigInteger $b The value to check with.
     * @return bool
     */
    public function greaterThan(BigInteger $b): bool
    {
        return $this->gt($b);
    }

    /**
     * Check if the value greater than the given.
     *
     * @param BigInteger $b The value to check with.
     * @return bool
     */
    public function gt(BigInteger $b): bool
    {
        $result = $this->cmp($b);

        return ($result==1);
    }

    /**
     * Check if the value greater than or equals to the given.
     *
     * @param BigInteger $b The value to check with.
     * @return bool
     */
    public function greaterThanOrEqualsTo(BigInteger $b): bool
    {
        return $this->gte($b);
    }

    /**
     * Check if the value greater than the given.
     *
     * @param BigInteger $b The value to check with.
     * @return bool
     */
    public function gte(BigInteger $b): bool
    {
        return ($this->cmp($b)>=0);
    }

    /**
     * Returns the hamming distance between a and b. Both operands should be non-negative.
     *
     * @param BigInteger $b  It should be positive.
     * @return int.
     */
    public function hamDist(BigInteger $b): int
    {
        return gmp_hamdist($this->value,$b->value);
    }


    /**
     * Computes the inverse of this modulo b.
     *
     * @param BigInteger $b
     * @return mixed  A GMP number on success or FALSE if an inverse does not exist.
     */
    public function invert(BigInteger $b): mixed
    {
        $result = gmp_invert($this->value, $b->value);
        if (false===$result){
            return false;
        }
        return  self::of($result);
    }

    /**
     *
     * Checks if the big integr equals one.
     *
     * @return bool
     */
    public function isOne():bool
    {
        return ($this->cmp(BInt('1'))==0);
    }

    /**
     *
     * Checks if the big integr equals zero.
     *
     * @return bool
     */
    public function isZero():bool
    {
        return ($this->cmp(BInt('0'))==0);
    }

    /**
     * Checks if the big integr is the prime number.
     *
     * @param float $probabilityFactor A normalized factor between 0 and 1 used for checking the probability.
     * @return bool Returns true if the number is a prime number false if not.
     */
    public function isPrime(float $probabilityFactor = 1.0): bool
    {
        $reps = (int)floor(($probabilityFactor * 5.0) + 5.0);

        if ($reps < 5 || $reps > 10) {
            throw new InvalidArgumentException('The provided probability number should be 5 to 10.');
        }

        return gmp_prob_prime($this->value, $reps) !== 0;
    }

    /**
     * Jacobi symbol of this and p. p should be odd and must be positive.
     *
     * @param BigInteger $b Should be odd and must be positive.
     * @return int
     */
    public function jacobi(BigInteger $b): int
    {
        return gmp_jacobi($this->value, $b->value);
    }

    /**
     * Compute the  Legendre symbol of this and $b. $b should be odd and must be positive.
     *
     * @param BigInteger $b
     * @return mixed
     */
    public function legendre(BigInteger $b): mixed
    {
        if ($this->lessThan(BInt('1')))
                return false;
        if (false===$this->Odd())
                return false;
        $value = gmp_legendre($this->value, $b->value);
        return  self::of($value);
    }

    /**
     * Check if the value less than the given.
     *
     * @param BigInteger $b The value to check with.
     * @return bool
     */
    public function lessThan(BigInteger $b): bool
    {
        return $this->lt($b);
    }

    /**
     * Check if the value less than the given.
     *
     * @param BigInteger $b The value to check with.
     * @return bool
     */
    public function lt(BigInteger $b): bool
    {
        $result = $this->cmp($b);
        return ($result==-1);
    }

    /**
     * Check if the value less than or equals to the given.
     *
     * @param BigInteger $b The value to check with.
     * @return bool
     */
    public function lessThanOrEqualsTo(BigInteger $b): bool
    {
        return $this->lte($b);
    }

    /**
     * Check if the value less than or equals to the given.
     *
     * @param BigInteger $b The value to check with.
     * @return bool
     */
    public function lte(BigInteger $b): bool
    {
        return  ($this->cmp($b)<=0);
    }
    /**
     * Returns the maximum of the two BigInteger values.
     *
     * @param BigInteger $b  One of the two values to be tested.
     * @return BigInteger.
     */
    public function max(BigInteger $b): BigInteger
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
     * Returns the mininum of the two BigInteger values.
     *
     * @param BigInteger $b  One of the two values to be tested.
     * @return BigInteger.
     */
    public function min(BigInteger $b): BigInteger
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
     * @return BigInteger
     */
    public function minus($b = 1): BigInteger
    {
        if(is_numeric($b)){
            $b = BigInteger::of($b);
        }
        $this->value = gmp_sub($this->value, $b->value);
        return $this;
    }

    /**
     * The opertor "--"
     * Returns the difference of this number and the given one.
     *
     * @param mixed $b
     * @return BigInteger
     */
    public function decrement($b=1): bool
    {
        return $this->minus($b);

    }

    /**
     * Performs a modulo operation with the given number.
     *
     * @param BigInteger $b The value to perform a modulo operation with.
     * @return BigInteger
     */
    public function mod(BigInteger $b): BigInteger
    {
        if ($b->isZero()){
            throw DivisionByZeroException::divisionByZero();
        }
        $result = gmp_mod($this->value, $b->value);

        return self::of($result);
    }

    /**
     * Performs a modulo on a BigInteger value raised to a power. b = (x^y) mod z.
     *
     * @param BigInteger $exp The power to raise the baseValue to.
     * @param BigInteger $mdl The modulus value to perform on the raised baseValue.
     * @return BigInteger
     */
    public function modPow(BigInteger $exp,BigInteger $mdl): BigInteger
    {
        $result = gmp_powm($this->value, $exp->value,$mdl->value);

        return self::of($result);
    }

    /**
     * Multiplies the given value with this value.
     *
     * @param BigInteger $b The value to multiply with.
     * @return BigInteger
     */
    public function multiply(BigInteger $b): BigInteger
    {
        return $this->mul($b);
    }

    /**
     * Multiplies the given value with this value.
     *
     * @param BigInteger $b The value to multiply with.
     * @return BigInteger
     */
    public function mul(BigInteger $b): BigInteger
    {
        $result = gmp_mul($this->value, $b->value);

        return self::of($result);
    }

    /**
     * Negates the value.
     *
     * @return BigInteger
     */
    public function negate(): BigInteger
    {
        $result = gmp_neg($this->value);

        return self::of($result);
    }

    /**
     * Find next prime number
     *
     * @return BigInteger
     */
    public function nextPrime(): BigInteger
    {
        $result = gmp_nextprime($this->value);

        return self::of($result);
    }

    /**
     * Create a new instance
     * @param Mixed $value
     * @return BigInteger
     */
    public static function of($value): BigInteger
    {
        if (is_numeric($value)){
            $value = self::initValue(strval($value));
        }
        if(is_string($value)){
            $value = self::initValue($value);
        }
        return new BigInteger ($value);
    }

    /**
     * Check if the number is odd
     *
     * @return bool
     */
    public function odd(): bool
    {
        return $this->testbit(0);
    }

    /**
     * Peforms a bitwise OR operation, returning the result.
     *
     * @param BigInteger $b The right hand value of the OR operation.
     * @return BigInteger
     */
    public function orBits(BigInteger $b): BigInteger
    {
        $result = gmp_or($this->value,$b->value);
        return self::of($result);
    }

    /**
     * Check if a number is a perfect square.
     *
     * @return bool
     */
    public function perfectSquare(): bool
    {
        return gmp_perfect_square($this->value);
    }

    /**
     * The opertor "++"
     * Returns the sum of this number and the given one.
     *
     * @param mixed $b
     * @return BigInteger
     */
    public function plus($b = 1): BigInteger
    {
        if (is_numeric($b)){
            $b=BigInteger::of($b);
        }
        $this->value = gmp_add($this->value, $b->value);
        return $this;
    }

    /**
     * The opertor "++"
     * Returns the sum of this number and the given one.
     *
     * @param mixed $b
     * @return BigInteger
     */
    public function increment($b=1): bool
    {
        return $this->plus($b);

    }

    /**
     * Get the population count.
     *
     * @return int
     */
    public function popCount(): int
    {
        return gmp_popcount($this->value);

    }

    /**
     * Performs a power operation with the given number.
     *
     * @param int $value, The value to perform a power operation with.
     * @return BigInteger
     */
    public function power(int $exp): BigInteger
    {
        return $this->pow($exp);
    }

    /**
     * Performs a power operation with the given number.
     *
     * @param int $value, The value to perform a power operation with.
     * @return BigInteger
     */
    public function pow(int $exp): BigInteger
    {
        $result = gmp_pow($this->value, $exp);

        return self::of($result);
    }

    /**
     * Generate a random number. The number will be between 0 and (2 ** bits) - 1.
     *
     * @param int $bit, The number of bits.
     * @return BigInteger
     */
    public function randomBits(int $bit): BigInteger
    {
        if (function_exists('gmp_random_bits')){
            $result = gmp_random_bits($bit);
            return self::of($result);
        }
        return self::of('0');
    }

    /**
     * Generate a random number. The number will be between min and max.
     *
     * @param BigInteger $min, A GMP number representing the lower bound for the random number
     * @param BigInteger $max, A GMP number representing the upper bound for the random number
     * @return BigInteger
     */
    public function randomRange(BigInteger $min,BigInteger $max): BigInteger
    {
        if (function_exists('gmp_random_range')) {
            $result = gmp_random_range($min->value, $max->value);
            return self::of($result);
        }
        return self::of('0');

    }

    /**
     * Sets the RNG seed for generate a random number.
     *
     * @param BigInteger $seed, The seed to be set for the random(), randomBits(), and randomRange() functions.
     * @return void
     */
    public function randomSeed(BigInteger $seed): void
    {
        gmp_random_seed($seed->value);

    }

    /**
     * Takes the nth root and returns the integer component of the result.
     *
     * @param int $nth  The positive root to take
     * @return BigInteger
     */
    public function root(int $nth): BigInteger
    {
        $result =  gmp_root($this->value,$nth);
        return self::of($result);
    }


    /**
     * Takes the nth root of a and returns the integer component and remainder of the result.
     *
     * @param int $nth  The positive root to take
     * @param BigInteger $remainder
     * @return BigInteger
     */
    public function rootRem(int $nth, BigInteger &$remainder ): BigInteger
    {
        $result =  gmp_rootrem($this->value,$nth);
        $remainder = self::of($result[1]);
        return self::of($result[0]);
    }


    /**
     * Scan for 0
     *
     * @param int $index
     * @return int
     */
    public function scan0(int $index): int
    {
        if ($index < 0){
            Throw new InvalidArgumentException('The value of index need not less than 0');
        }
        return gmp_scan0($this->value,$index);
    }

    /**
     * Scan for 1
     *
     * @param int $index
     * @return int
     */
    public function scan1(int $index): int
    {
        if ($index < 0){
            Throw new InvalidArgumentException('The value of index need not less than 0');
        }
        return gmp_scan1($this->value,$index);
    }

    /**
     * Set bit
     *
     * @param int $index The index of the bit to set. Index 0 represents the least significant bit.
     * @param bool|TRUE $bit_on True to set the bit (set it to 1/on); false to clear the bit (set it to 0/off).
     * @return BigInteger
     */
    public function setBit(int $index, bool $bit_on = TRUE): BigInteger
    {
        if ($index < 0){
            Throw new InvalidArgumentException('The value of index need not less than 0');
        }
        gmp_setbit($this->value,$index,$bit_on);
        return $this;
    }

    /**
     * Sets the value.
     *
     * @param string $value The value to set.
     * @return BigInteger
     */
    public function setValue(string $value): BigInteger
    {
        $this->value = self::initValue($value);

        return $this;
    }

    /**
     * Sign of number.
     *
     * @return int
     */
    public function sign(): int
    {
        return gmp_sign($this->value);
    }

    /**
     * Returns the integer square root of a BigInteger.
     *
     * @return BigInteger
     */
    public function squareRoot(): BigInteger
    {
        return $this->sqr();
    }

    /**
     * Returns the integer square root of a BigInteger.
     *
     * @return BigInteger
     */
    public function sqr(): BigInteger
    {
        $result = gmp_sqrt($this->value);

        return self::of($result);
    }

    /**
     * Returns the integer square root of a BigInteger.
     * @param BigInteger $remainder A variable to place the remainder in to.
     * @return BigInteger
     */
    public function squareRootRem(&$remainder): BigInteger
    {
        list($sqrt1, $remainder) = gmp_sqrtrem($this->value);

        return self::of($sqrt1);
    }

    /**
     * Subtracts the given value from this value.
     *
     * @param BigInteger $b The value to subtract.
     * @return BigInteger
     */
    public function subtract(BigInteger $b): BigInteger
    {
        return $this->sub($b);
    }

    /**
     * Subtracts the given value from this value.
     *
     * @param BigInteger $b The value to subtract.
     * @return BigInteger
     */
    public function sub(BigInteger $b): BigInteger
    {
        $result = gmp_sub($this->value, $b->value);
        return self::of($result);
    }

    /**
     * Tests if a bit is set.
     *
     * @param int $index
     * @return bool
     */
    public function testBit(int $index): bool
    {
        if ($index < 0){
            Throw new InvalidArgumentException('The value of index need not less than 0');
        }
        return gmp_testbit($this->value,$index);
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
     * Peforms a bitwise XOR operation, returning the result.
     *
     * @param BigInteger $b The right hand value of the XOR operation.
     * @return BigInteger
     */
    public function xorBits(BigInteger $b): BigInteger
    {
        $result = gmp_xor($this->value,$b->value);
        return self::of($result);
    }

    /**
     * Peforms string concat operation, returning the result.
     *
     * @param mixed $b
     * @return string
     */
    public function concat ($b): string{
        if ($b instanceof BigInteger){
            $b = $b->toString();
        }
        return $this->toString() . $b;
    }

    /**
     * Check this number is identical to the given.
     * @param $b
     * @return bool
     */
    public function identical($b):bool{
        return ($this === $b);
    }

    /**
     * Check this number is not identical to the given.
     * @param $b
     * @return bool
     */
    public function notIdentical($b):bool{
        return ($this !== $b);
    }

    /**
     * Operator overload function
     * $o + $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __add($arg){
        return $this->add($arg);
    }

    /**
     * Operator overload function
     * $o - $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __sub($arg){
        return $this->sub($arg);
    }

    /**
     * Operator overload function
     * $o * $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __mul($arg){
        return $this->mul($arg);
    }

    /**
     * Operator overload function
     * $o / $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __div($arg){
        return $this->div($arg);
    }

    /**
     * Operator overload function
     * $o % $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __mod($arg){
        return $this->mod($arg);
    }

    /**
     * Operator overload function
     * $o ** $arg
     * @param mixed $arg
     * @return BigInteger
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
     * $o | $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __bw_or($arg){
        return $this->orBits($arg);
    }

    /**
     * Operator overload function
     * $o & $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __bw_and($arg){
        return $this->andBits($arg);
    }

    /**
     * Operator overload function
     * $o ^ $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __bw_xor($arg){
        return $this->xorBits($arg);
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
     * @return BigInteger
     */
    public function __pre_inc(){
        return $this->plus();
    }

    /**
     * Operator overload function
     * $o++
     * @return BigInteger
     */
    public function __post_inc(){
        return $this->plus();
    }

    /**
     * Operator overload function
     * --$o
     * @return BigInteger
     */
    public function __pre_dec(){
        return $this->minus();
    }

    /**
     * Operator overload function
     * $o--
     * @return BigInteger
     */
    public function __post_dec(){
        return $this->minus();
    }

    /**
     * Operator overload function
     * $o = $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __assign($arg){
        $this->value = $arg->value;
        return $this;
    }

    /**
     * Operator overload function
     * $o += $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __assign_add($arg){
        return $this->plus($arg);
    }

    /**
     * Operator overload function
     * $o -= $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __assign_sub($arg){
        return $this->minus($arg);
    }

    /**
     * Operator overload function
     * $o *= $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __assign_mul($arg){
        if(is_numeric($arg)){
            $arg = BigInteger::of($arg);
        }
        $this->value = gmp_mul($this->value, $arg->value);
        return $this;
    }

    /**
     * Operator overload function
     * $o /= $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __assign_div($arg){
        if(is_numeric($arg)){
            $arg = BigInteger::of($arg);
        }
        if ($arg->isZero()){
            throw DivisionByZeroException::divisionByZero();
        }
        $this->value = gmp_div($this->value, $arg->value);
        return $this;
    }

    /**
     * Operator overload function
     * $o %= $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __assign_mod($arg){
        if(is_numeric($arg)){
            $arg = BigInteger::of($arg);
        }
        $this->value = gmp_mod($this->value, $arg->value);
        return $this;
    }

    /**
     * Operator overload function
     * $o **= $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __assign_pow($arg){
        if(is_numeric($arg)){
            $arg = BigInteger::of($arg);
        }
        $this->value = gmp_pow($this->value, $arg->value);
        return $this;
    }

    /**
     * Operator overload function
     * $o |= $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __assign_bw_or($arg){
        if(is_numeric($arg)){
            $arg = BigInteger::of($arg);
        }
        $this->value = gmp_or($this->value,$arg->value);
        return $this;
    }

    /**
     * Operator overload function
     * $o &= $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __assign_bw_and($arg){
        if(is_numeric($arg)){
            $arg = BigInteger::of($arg);
        }
        $this->value = gmp_and($this->value,$arg->value);
        return $this;
    }

    /**
     * Operator overload function
     * $o ^= $arg
     * @param mixed $arg
     * @return BigInteger
     */
    public function __assign_bw_xor($arg){
        if(is_numeric($arg)){
            $arg = BigInteger::of($arg);
        }
        $this->value = gmp_xor($this->value,$arg->value);
        return $this;
    }
}

