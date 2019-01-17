<?php


namespace BardoQi\BigMath\Exceptions;

use RuntimeException;
use Throwable;

/**
 * Base class for all BigMath exceptions.
 *
 * This class is abstract because we need to implements Throwable
 */
abstract class BigMathException extends RuntimeException implements Throwable
{

}