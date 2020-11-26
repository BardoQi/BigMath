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
use function BardoQi\BigMath\BDec as BDec;


class BigDComplex
{
    /**
     * @var BigDecimal
     */
    public $r;

    /**
     * @var BigDecimal
     */
    public $i;

    /**
     * BigDComplex constructor.
     * @param BigDecimal $r
     * @param BigDecimal $i
     */
    public function __construct(BigDecimal $r, BigDecimal $i) {
        $this->r = $r;
        $this->i = $i;
    }

    /**
     * @param mixed $r
     * @param mixed $i
     * @return BigDComplex
     */
    public static function of($r, $i):BigDComplex{
        if(!$r instanceof BigDecimal) {
            $r = BDec($r);
        }
        if(!$i instanceof BigDecimal) {
            $i = BDec($i);
        }
        return new BigDComplex($r,$i);
    }

    /**
     * @return BigDComplex
     */
    public function clone():BigDComplex{
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
        if ($this->i->equals(BDec(0.0))) {
            return $this->r->toString();
        } elseif (-1==$this->i->compareTo(BDec(0.0))) {
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
        if (is_a($num, 'BigDComplex')) {
            return ($this->r->equals($num->r) && $this->i->equals($num->i));
        } else {
            return (BDec($num)->equals($this->r) && $this->i->equals(BDec(0.0)));
        }
    }

    /**
     * @return BigDecimal
     */
    public function abs():BigDecimal {
        return $this->r->multiply($this->r)->add($this->i->multiply($this->i))->squareRoot();
    }


    /**
     * @return BigDComplex
     */
    public function neg():BigDComplex {
        return new BigDComplex($this->r->multiply(BDec(-1)), $this->i->multiply(BDec(-1)));
    }

    /**
     * @return BigDComplex
     */
    public function conj():BigDComplex {
        return $this->conjugate();
    }

    /**
     * @return BigDComplex
     */
    public function conjugate():BigDComplex {
        return new BigDComplex($this->r, $this->i->multiply(BDec(-1)));
    }

    /**
     * @return BigDComplex
     */
    public function inverse():BigDComplex {
        $denominator = $this->r->multiply($this->r)->add($this->i->multiply($this->i));
        if ($denominator->equals(BDec(0.0))) {
            throw DivisionByZeroException::invertingZero();
        } else {
            return new BigDComplex($this->r->divide($denominator), -$this->i->divide($denominator));
        }
    }

    /**
     * @param $num
     * @return BigDComplex
     */
    public function add($num):BigDComplex {
        if (is_a($num, 'BigDComplex'))
            return new BigDComplex($this->r->add($num->r), $this->i->add($num->i));
        else
            return new BigDComplex($this->r->add(BDec($num)), $this->i);
    }

    /**
     * @param $num
     * @return BigDComplex
     */
    public function sub($num):BigDComplex {
        return $this->subtract($num);
    }

    /**
     * @param $num
     * @return BigDComplex
     */
    public function subtract($num):BigDComplex {
        if (is_a($num, 'BigDComplex'))
            return new BigDComplex($this->r->subtract($num->r), $this->i->subtract( $num->i));
        else
            return new BigDComplex($this->r->subtract(BDec($num)), $this->i);
    }

    /**
     * @param $num
     * @return BigDComplex
     */
    public function mul($num):BigDComplex {
        return $this->multiply($num);
    }

    /**
     * @param $num
     * @return BigDComplex
     */
    public function multiply($num):BigDComplex {
        if (is_a($num, 'BigDComplex')) {
            return new BigDComplex(
                $this->r->multiply($num->r)->sub($this->i->multiply($num->i)),
                $this->i->multiply($num->r)->add($this->r->multiply($num->i))
            );
        } else {
            $real = BDec($num);
            return new BigDComplex($this->r->multiply($real) , $this->i->multiply($real));
        }
    }

    /**
     * @param $num
     * @return BigDComplex
     */
    public function div($num):BigDComplex {
        return $this->divide($num);
    }

    /**
     * @param $num
     * @return BigDComplex
     */
    public function divide($num) {
        if (is_a($num, 'BigDComplex')) {
            /** @var BigDecimal $denominator */
            $denominator = $num->r->multiply($num->r)->add($num->i->multiply($num->i)) ;
            if ($denominator->equals(BDec(0.0))) {
                throw DivisionByZeroException::divisionByZero();
            } else {
                return new BigDComplex(
                    $this->r->multiply($num->r)->add($this->i->multiply($num->i))->divide($denominator),
                    $this->i->multiply($num->r)->subtract($this->r->multiply($num->i))->divide($denominator)
                );
            }
        } else {
            $real = BDec($num);
            if ($real->equals(BDec(0.0))) {
                throw DivisionByZeroException::divisionByZero();
            } else {
                return new BigDComplex($this->r->divide($real), $this->i->divide($real));
            }
        }
    }

    /**
     * @return BigDComplex
     */
    public function sqr() {
        return $this->squareRoot();
    }

    /**
     * @return BigDComplex
     */
    public function sqrt() {
        return $this->squareRoot();
    }

    /**
     * @return BigDComplex
     */
    public function squareRoot() {
        if ($this->r == 0.0 && $this->i == 0.0) {
            return self::of(0.0, 0.0);
        } else {
            $abs = $this->abs();
            if ($this->i < 0.0) {
                return new BigDComplex($abs->add($this->r)->divide(BDec(2))->squareRoot(),
                    $abs->subtract($this->r)->divide(BDec(-2))->squareRoot());
            } else {
                return new BigDComplex($abs->add($this->r)->divide(BDec(2))->squareRoot(),
                    $abs->subtract($this->r)->divide(BDec(2))->squareRoot());
            }
        }
    }

}