<?php

class IRGCalculator
{
    private $salary;
    private $salaryIntPart;
    private $amount = 0;
    private $taxes;
    private $taxesPercent = "0%";

    function __construct(int $salary = 0)
    {
        $this->salary = $salary;
        $this->salaryToInt($salary);
        $this->calculateAmount();
        $this->calculateTaxes();

        echo '<pre>';
        echo 'Salaire: ' . $this->salary;
        echo '<br/>';
        echo 'Salaire (int): ' . $this->salaryIntPart;
        echo '<br/>';
        echo 'Montant IRG: ' . $this->amount;
        echo '<br/>';
        echo 'Taxes: ' . $this->taxes;
        echo '<br/>';
        echo 'Tranche: ' . $this->taxesPercent;
        echo '<br/>';
        echo '</pre>';
    }

    /**
     * Setters
     */
    private function salaryToInt($salary)
    {
        $this->salaryIntPart = intval($salary);
    }

    /**
     * Getters
     */
    public function integerPart()
    {
        return $this->salaryIntPart;
    }

    /**
     * Utilities
     */
    public function calculateAmount()
    {
        if ($this->salary > 30000) {
            if ($this->salary > 30000 && $this->salary <= 39999) {
                $this->amount = ($this->integerPart() - 20000) * 0.23;
                $this->taxesPercent =  "23%";
            } elseif ($this->salary > 39999 && $this->salary <= 79999) {
                $this->amount = 4600 + ($this->integerPart() - 40000) * 0.27;
                $this->taxesPercent =  "27%";
            } elseif ($this->salary > 79999 && $this->salary <= 159999) {
                $this->amount = 15400 + ($this->integerPart() - 80000) * 0.3;
                $this->taxesPercent =  "30%";
            } elseif ($this->salary > 159999 && $this->salary < 320000) {
                $this->amount = 39400 + ($this->integerPart() - 160000) * 0.33;
                $this->taxesPercent =  "33%";
            } else {
                $this->amount = 92200 + ($this->integerPart() - 320000) * 0.35;
                $this->taxesPercent =  "35%";
            }
        }
        return [
            'amount' => $this->amount,
            'taxesPercent' => $this->taxesPercent
        ];
    }

    public function calculateTaxes()
    {
        $this->taxes = 0.4 * $this->amount;

        if ($this->taxes < 1000) {
            $this->taxes = 1000;
        } elseif ($this->taxes > 1500) {
            $this->taxes = 1500;
        }

        if ($this->salary <= 35000) {
            $this->taxes = $this->taxes * (137 / 51) - (27925 / 8);
        }

        $this->taxes = number_format(round($this->amount - $this->taxes, 2), 2, '.', ' ');
    }
}
