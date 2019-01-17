<?php
namespace BardoQi\BigMath;
use BardoQi\BigMath\BigInteger;
/**
 * Do not forget to import the global function!
 */
use function BardoQi\BigMath\BInt as BInt;


/**
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

    //for($i=$xstart; $i<=$xMax; $i += $step)
    for($i = BInt($xStart); $i->lte(BInt($xMax)); $i->plus($step)){
        $item = &$data[];
        $item['x']=$i->copy();
        //Parabola expresion: y = ax^2+bx+c
        $item['y']=BInt($a)->mul($i->pow(2))->add(BInt($b)->mul($i))->add(BInt($c));
    }

    return $data;

}

    $data = getParabolaData("100","200","300","0","100","10");
    echo "<pre>";
    print_r($data);