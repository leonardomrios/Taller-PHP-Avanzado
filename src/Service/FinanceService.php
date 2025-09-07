<?php
namespace App\Service;

class FinanceService
{
    /** Interés compuesto: A = P(1 + r/n)^(n*t). Devuelve monto y ganancia. */
    public function compoundInterest(float $principal, float $rateAnnual, int $years, int $n = 12): array
    {
        $r = $rateAnnual; // ej. 0.12 para 12%
        $amount = $principal * pow(1 + $r / $n, $n * $years);
        return [
            'principal' => round($principal, 2),
            'rate' => $r,
            'years' => $years,
            'n' => $n,
            'amount' => round($amount, 2),
            'interest_earned' => round($amount - $principal, 2)
        ];
    }

    /** Cálculo simplificado de salario neto en Colombia: desc. salud (4%) + pensión (4%). */
    public function netSalaryColombia(float $gross): array
    {
        $salud = round($gross * 0.04, 2);
        $pension = round($gross * 0.04, 2);
        $net = round($gross - $salud - $pension, 2);
        return [
            'gross' => $gross,
            'salud_4' => $salud,
            'pension_4' => $pension,
            'net' => $net,
        ];
    }
}