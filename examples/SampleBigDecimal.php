<?php
namespace BardoQi\BigMath;


use BardoQi\BigMath\BigDecimal;
/**
 * Do not forget to import the global function!
 */
use function BardoQi\BigMath\BDec as BDec;

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
    for($i = BDec($xStart); $i->lte(BDec($xMax)); $i->plus($step)){
        $item = &$data[];
        $item['x']=$i->copy();
        //Parabola expresion: y = ax^2+bx+c
        $item['y']=BDec($a)->mul($i->pow(BDec("2")))->add(BDec($b)->mul($i))->add(BDec($c));
    }

    return $data;

}

$data = getParabolaData("100","200","300","0","100","10");
echo "<pre>";
print_r($data);