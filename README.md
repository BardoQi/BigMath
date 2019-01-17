```
_______   __            __       __             __      __       
|       \ |  \          |  \     /  \           |  \    |  \      
| $$$$$$$\ \$$  ______  | $$\   /  $$  ______  _| $$_   | $$____  
| $$__/ $$|  \ /      \ | $$$\ /  $$$ |      \|   $$ \  | $$    \ 
| $$    $$| $$|  $$$$$$\| $$$$\  $$$$  \$$$$$$\\$$$$$$  | $$$$$$$\
| $$$$$$$\| $$| $$  | $$| $$\$$ $$ $$ /      $$ | $$ __ | $$  | $$
| $$__/ $$| $$| $$__| $$| $$ \$$$| $$|  $$$$$$$ | $$|  \| $$  | $$
| $$    $$| $$ \$$    $$| $$  \$ | $$ \$$    $$  \$$  $$| $$  | $$
 \$$$$$$$  \$$ _\$$$$$$$ \$$      \$$  \$$$$$$$   \$$$$  \$$   \$$
              |  \__| $$                                          
               \$$    $$                                          
                \$$$$$$                                           
```
# BigMath

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A PHP library to work with big integers. This library makes use of the GMP extension
and bcmath to do its calculations.
## Introduction
    
Maybe you ara a developer of blockchain using php. Maybe you often coding encrypt and decrypt. And you fund that there is no library easy to use for big integer or high precision number in php.
Now you could coding in most easy way with the BigMath!  

## Install

Via Composer

``` bash
$ composer require bardoqi/bigmath：dev-master
```

## Usage

``` php
    //with pecl Operator overloading extension:
    $number = BInt('8273467836243255543265432745') + BInt('2');
    //without pecl Operator overloading extension:
    $number = BInt('8273467836243255543265432745')->add(BInt('2'));
```
## Features

This library supports the following operations:

* Big Intgeger and high precision decimal support
....Class BigInteger: using with GMP.
....Class BigDecminal: using with bcmath.

* Global type converting functions; 
.... You need not use 'new' operator to create new object.
.... You Only need use:

``` php     
     //to get a new BigInteger instance of $var; 
     BInt($var); 
     //to get a new BigDecimal instance of $var; 
     BDec($var); 
```
* Simple init Mothod: of(string $value)
    
* Support using with [pecl Operator overloading extension][link-pecl-php-operator], there are operators could be used:
    
| Operator | Method |
|:---:| --- |
| $o + $arg | `__add($arg)` |
| $o - $arg | `__sub($arg)` |
| $o * $arg | `__mul($arg)` |
| $o / $arg | `__div($arg)` |
| $o % $arg | `__mod($arg)` |
| $o ** $arg | `__pow($arg)` |
| $o . $arg | `__concat($arg)` |
| $o &#x7c; $arg | `__bw_or($arg)` |
| $o & $arg | `__bw_and($arg)` |
| $o ^ $arg | `__bw_xor($arg)` |
| $o === $arg | `__is_identical($arg)` |
| $o !== $arg | `__is_not_identical($arg)` |
| $o == $arg | `__is_equal($arg)` |
| $o != $arg | `__is_not_equal($arg)` |
| $o < $arg | `__is_smaller($arg)` |
| $o <= $arg | `__is_smaller_or_equal($arg)` |
| $o > $arg | `__is_greater($arg)` &#42; |
| $o >= $arg | `__is_greater_or_equal($arg)` &#42; |
| $o <=> $arg | `__cmp($arg)` |
| ++$o | `__pre_inc()` |
| $o++  | `__post_inc()` |
| --$o | `__pre_dec()` |
| $o-- | `__post_dec()` |
| $o = $arg | `__assign($arg)` |
| $o += $arg | `__assign_add($arg)` |
| $o -= $arg | `__assign_sub($arg)` |
| $o \*= $arg | `__assign_mul($arg)` |
| $o /= $arg | `__assign_div($arg)` |
| $o %= $arg | `__assign_mod($arg)` |
| $o \*\*= $arg | `__assign_pow($arg)` |
| $o &#x7c;= $arg | `__assign_bw_or($arg)` |
| $o &= $arg | `__assign_bw_and($arg)` |
| $o ^= $arg | `__assign_bw_xor($arg)` |
    
    
    
* If without [pecl Operator overloading extension][link-pecl-php-operator], there are mothods of operators could be used:
    
|Operators| method                                  |
|  :----: |-----------------------------------------|
| +       |  add()                                  |
| -       |  sub(), substract()                     |
| *       |  mul(), multiply()                      |
| /       |  div(), divide()                        |
| %       |  mod()                                  |
| **      |  pow(), power()                         |
| ++      |  plus(), increment()                    |
| --      |  minus(), devrement                     |
| ==      |  eq(), equals()                         |
| !=      |  ne(), notEquals()                      |
| ===     |  identical()                            |
| !==     |  notIdentical(()                        |
| >       |  gt(), greaterThan()                    |
| >=      |  gte() greaterThanOrEqualsTo()          |
| <       |  lt(), lessThan()                       |
| <=      |  lte(), lessThanOrEqualsTo()            |
| <=>     |  cmp(), compareTo()                     |
| -       |  negate()                               |
| .       |  concat()                               |

* Mothods for coding simple:
    max();  min();  even(); odd(); sign();
    isOne();  isZero(); randomRange();
* Mothods of Mathematics:
    abs();  divideRem; powMod(); squareRoot();  
    factorial(); gcd(); 
* Mothods for bit orpeator(Only in BigInteger)
    andBits();   orBits(); clearBits(); complement()
    invert();  setBit();  testBit(); scan0(); scan1();
* Mothods of Math Theory(Only in BigInteger)
    isPrime();  jacobi(); legendre(); perfectSquare()
    popcount(); root();  
* Chain Operators support:
    You can just use:
    
``` php
    //with pecl Operator overloading extension:
    $x=($a+$b)*($c-$d);
    //without pecl Operator overloading extension:
    $x=BInt($a)->add(BInt($b))->multiply(BInt($c)->substract(BInt($d))); 		
```

## Sample Code

``` php
    //with Operator overloading extension:
    //if sample:
    if(abs($big_g)>abs($big_m)){
        $big_g = $big_g % $big_m;
    }
    
    //while sample:
    While (rt_v!=1){
        $x = $rd_v/$rt_v;
        //...
    }
    
    //for sample:
    for($i=$xstart; $i<$xMax; $i += $step){
        $item = &$data[];
        $item['x']=$i;
    }
    
    //without Operator overloading extension:
    //if sample:
    //if(abs($big_g)>abs($big_m)){...}
    if ($big_g->abs()->gt($big_m->abs())){
        $big_g = $big_g->mod($big_m);
    }
    
    //while sample:
    //While (rt_v!=1){...}
    while (!($rt_v->isOne())){ //rt!=1
        //x=rd/rt
        $x = $rd_v->div($rt_v);
        //...
    }
    
    //for sample:
    //for($i=$xstart; $i<$xMax; $i += $step)
    for($i = BInt($xStart); $i->lt(BInt($xMax)); $i->plus($step)){
        $item = &$data[];
        $item['x']=$i;
    }
    
    //More samples please read the code in exanples! 

```

## Change log
    
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.
    
## Testing

``` bash
$ composer test
```
## Road Map

Add: '<<' and '>>' Operator to class BigInteger
  
Add: '~' Operator to class BigInteger 
  
Add: trigonometric functions such as sin cos etc to class BigDecimal
  
Add: inverse trigonometric function such as asin acos etc to class BigDecimal
  
Add: hyperbolic trigonometric functions such as sinh cosh etc to class BigDecimal
  
Add: high precision math constant such as e and pi.
  
Add: rational number class

## Contributing
    
Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.
    
## Security
    
If you discover any security related issues, please create an issue in the issue tracker.
    
## Credits

- [Bardo Qi][link-author]
- [All Contributors][link-contributors]

## License
   
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
    
[ico-version]: https://img.shields.io/packagist/v/phpmath/biginteger.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phpmath/biginteger/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/phpmath/biginteger.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/phpmath/biginteger.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phpmath/biginteger.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/bardoqi/bigmath
[link-travis]: https://travis-ci.org/bardoqi/bigmath
[link-scrutinizer]: https://scrutinizer-ci.com/g/bardoqi/bigmath/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/bardoqi/bigmath
[link-downloads]: https://packagist.org/packages/bardoqi/bigmath
[link-author]: https://github.com/bardoqi
[link-contributors]: ../../contributors
[link-pecl-php-operator]:https://github.com/php/pecl-php-operator
