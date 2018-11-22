<?php

namespace Atm;

use Atm\BanknotesCollection\BanknotesCollectionInterface;

class BanknotesStorage
{
    private $banknotesCollection;

    public function __construct(BanknotesCollectionInterface $banknotesCollection)
    {
        $this->banknotesCollection = $banknotesCollection;
    }

    public function getBanknotesCollection(): BanknotesCollectionInterface
    {
        return $this->banknotesCollection;
    }
}