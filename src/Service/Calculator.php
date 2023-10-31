<?php

namespace App\Service;

class Calculator
{
    public function performCalculation(array $data)
    {
        switch($data['operand']) {
            case '+':
                return round($data['value_one'] + $data['value_two'], 2);
            case '-':
                return round($data['value_one'] - $data['value_two'], 2);
        }
    }
}