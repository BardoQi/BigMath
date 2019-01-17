<?php
/**
 * !!Important!
 * This file is a code sample with using the pecl Operator Overloading Extension.
 */
namespace BardoQi\BigMath;

use BardoQi\BigMath\BigInteger;
/**
 * Do not forget to import the global function!
 */
use function BardoQi\BigMath\BInt as BInt;

/**
 * This file is a code sample with using the pecl Operator Overloading Extension.
 */
if (!extension_loaded ( "operator" )){
    die("This code require the pecl Operator Overloading Extension!");
}
/**
 *
 * Retrieve the data array of parabola curve from the paramaters given.
 *
 * @param string $a
 * @param string $b
 * @param string $c
 * @param string $xStart
 * @param string $xMax
 * @param string $step
 * @return mixed
 */
function getParabolaData(string $a,string $b,string $c, string $xStart,  string $xMax,  string $step):array
{
    $data=[];

    for($i = BInt($xStart); $i <= BInt($xMax); $i += BInt($step)){
        $item = &$data[];
        $item['x']=$i;
        //Parabola expresion: y = ax^2+bx+c
        $item['y']=BInt($a)*($i**2)+BInt($b)*($i)+BInt($c);
    }

    return $data;

}

$data = getParabolaData("100","200","300","0","100","10");
echo "<pre>";
print_r($data);