<?php

namespace App\Service;

class Calculator
{
    public function performCalculation(array $data)
    {
//      Calcul selon l'opérateur
        switch($data['operand']) {
            case '+':
                return round($data['value_one'] + $data['value_two'], 2);
            case '-':
                return round($data['value_one'] - $data['value_two'], 2);
        }
    }
}