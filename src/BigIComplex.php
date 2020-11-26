<?php
/**
 * BardoQi/BigMath (https://github.com/BardoQi/BigMath)
 *
 * @link https://github.com/BardoQi/BigMath for the canonical source repository
 * @copyright Copyright (c) 2015-2017 Bardo Qi (https://github.com/BardoQi/BigMath)
 * @license https://github.com/BardoQi/BigMath/LICENSE.md MIT
 */


namespace BardoQi\BigMath;
use BardoQi\BigMath\Exceptions\DivisionByZeroException;
/**
 * Do not forget to import the global function!
 */
use function BardoQi\BigMath\BInt as BInt;

class BigIComplex
{
    /**
     * @var BigInteger
     */
    public $r;

    /**
     * @var BigInteger
     */
    public $i;

    /**
     * BigIComplex constructor.
     * @param BigInteger $r
     * @param BigInteger $i
     */
    public function __construct(BigInteger $r, BigInteger $i) {
        $this->r = $r;
        $this->i = $i;
    }

    /**
     * @param mixed $r
     * @param mixed $i
     * @return BigIComplex
     */
    public static function of($r, $i):BigIComplex{
        if(!$r instanceof BigInteger) {
            $r = BInt($r);
        }
        if(!$i instanceof BigInteger) {
            $i = BInt($i);
        }
        return new BigIComplex($r,$i);
    }

    /**
     * @return BigIComplex
     */
    public function clone():BigIComplex{
        return self::of($this->r,$this->i);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return BigInteger|string
     */
    public function toString() {
        if ($this->i->equals(BInt(0.0))) {
            return $this->r->toString();
        } elseif (-1==$this->i->compareTo(BInt(0.0))) {
            return $this->r->toString() . ' - ' . $this->i->abs()->toString() . 'i';
        } else {
            return $this->r->toString() . ' + ' . $this->i->toString() . 'i';
        }
    }

    /**
     * @param $num
     * @return bool
     */
    public function equals($num) {
        if (is_a($num, 'BigIComplex')) {
            return ($this->r->equals($num->r) && $this->i->equals($num->i));
        } else {
            return (BInt($num)->equals($this->r) && $this->i->equals(BInt(0.0)));
        }
    }

    /**
     * @return BigInteger
     */
    public function abs():BigInteger {
        return $this->r->multiply($this->r)->add($this->i->multiply($this->i))->squareRoot();
    }


    /**
     * @return BigIComplex
     */
    public function neg():BigIComplex {
        return new BigIComplex($this->r->multiply(BInt(-1)), $this->i->multiply(BInt(-1)));
    }

    /**
     * @return BigIComplex
     */
    public function conj():BigIComplex {
        return $this->conjugate();
    }

    /**
     * @return BigIComplex
     */
    public function conjugate():BigIComplex {
        return new BigIComplex($this->r, $this->i->multiply(BInt(-1)));
    }

    /**
     * @return BigIComplex
     */
    public function inverse():BigIComplex {
        $denominator = $this->r->multiply($this->r)->add($this->i->multiply($this->i));
        if ($denominator->equals(BInt(0.0))) {
            throw DivisionByZeroException::invertingZero();
        } else {
            return new BigIComplex($this->r->divide($denominator), -$this->i->divide($denominator));
        }
    }

    /**
     * @param $num
     * @return BigIComplex
     */
    public function add($num):BigIComplex {
        if (is_a($num, 'BigIComplex'))
            return new BigIComplex($this->r->add($num->r), $this->i->add($num->i));
        else
            return new BigIComplex($this->r->add(BInt($num)), $this->i);
    }

    /**
     * @param $num
     * @return BigIComplex
     */
    public function sub($num):BigIComplex {
        return $this->subtract($num);
    }

    /**
     * @param $num
     * @return BigIComplex
     */
    public function subtract($num):BigIComplex {
        if (is_a($num, 'BigIComplex'))
            return new BigIComplex($this->r->subtract($num->r), $this->i->subtract( $num->i));
        else
            return new BigIComplex($this->r->subtract(BInt($num)), $this->i);
    }

    /**
     * @param $num
     * @return BigIComplex
     */
    public function mul($num):BigIComplex {
        return $this->multiply($num);
    }

    /**
     * @param $num
     * @return BigIComplex
     */
    public function multiply($num):BigIComplex {
        if (is_a($num, 'BigIComplex')) {
            return new BigIComplex(
                $this->r->multiply($num->r)->sub($this->i->multiply($num->i)),
                $this->i->multiply($num->r)->add($this->r->multiply($num->i))
            );
        } else {
            $real = BInt($num);
            return new BigIComplex($this->r->multiply($real) , $this->i->multiply($real));
        }
    }

    /**
     * @param $num
     * @return BigIComplex
     */
    public function div($num):BigIComplex {
        return $this->divide($num);
    }

    /**
     * @param $num
     * @return BigIComplex
     */
    public function divide($num) {
        if (is_a($num, 'BigIComplex')) {
            /** @var BigInteger $denominator */
            $denominator = $num->r->multiply($num->r)->add($num->i->multiply($num->i)) ;
            if ($denominator->equals(BInt(0.0))) {
                throw DivisionByZeroException::divisionByZero();
            } else {
                return new BigIComplex(
                    $this->r->multiply($num->r)->add($this->i->multiply($num->i))->divide($denominator),
                    $this->i->multiply($num->r)->subtract($this->r->multiply($num->i))->divide($denominator)
                );
            }
        } else {
            $real = BInt($num);
            if ($real->equals(BInt(0.0))) {
                throw DivisionByZeroException::divisionByZero();
            } else {
                return new BigIComplex($this->r->divide($real), $this->i->divide($real));
            }
        }
    }

    /**
     * @return BigIComplex
     */
    public function sqr():BigIComplex {
        return $this->squareRoot();
    }

    /**
     * @return BigIComplex
     */
    public function sqrt():BigIComplex {
        return $this->squareRoot();
    }

    /**
     * @return BigIComplex
     */
    public function squareRoot():BigIComplex {
        if ($this->r == 0.0 && $this->i == 0.0) {
            return self::of(0.0, 0.0);
        } else {
            $abs = $this->abs();
            if ($this->i < 0.0) {
                return new BigIComplex($abs->add($this->r)->divide(BInt(2))->squareRoot(),
                    $abs->subtract($this->r)->divide(BInt(-2))->squareRoot());
            } else {
                return new BigIComplex($abs->add($this->r)->divide(BInt(2))->squareRoot(),
                    $abs->subtract($this->r)->divide(BInt(2))->squareRoot());
            }
        }
    }

}


