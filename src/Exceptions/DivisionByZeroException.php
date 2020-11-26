<?php

namespace BardoQi\BigMath\Exceptions;

//use BardoQi\BigMath\Exceptions\BigMathException;

/**
 * Exception thrown when a division by zero occurs.
 * We only implements with parent call.
 */
class DivisionByZeroException extends BigMathException
{

    /**
     * @return DivisionByZeroException
     */
    public static function divisionByZero() : DivisionByZeroException
    {
        return new self('Division by zero.');
    }

    /**
     * @return DivisionByZeroException
     */
    public static function invertingZero() : DivisionByZeroException
    {
        return new self('Division by zero while inverting zero.');
    }



}