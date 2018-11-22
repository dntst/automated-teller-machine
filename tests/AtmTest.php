<?php

namespace Tests;

use Atm\Atm;
use Atm\Banknote;
use Atm\BanknotesCollection\SimpleBanknotesCollection;
use Atm\BanknotesStorage;
use Atm\Exception\NotEnoughMoneyException;
use Atm\Exception\WrongRequestedAmountException;
use PHPUnit\Framework\TestCase;


final class AtmTest extends TestCase
{
    /**
     * @var Atm
     */
    protected $atm;

    protected function setUp()
    {
        $banknotesCollection = new SimpleBanknotesCollection();

        $banknotesCollection->add(new Banknote(50));
        $banknotesCollection->add(new Banknote(50));
        $banknotesCollection->add(new Banknote(50));

        $banknotesCollection->add(new Banknote(100));
        $banknotesCollection->add(new Banknote(100));
        $banknotesCollection->add(new Banknote(100));

        $banknotesCollection->add(new Banknote(500));
        $banknotesCollection->add(new Banknote(500));
        $banknotesCollection->add(new Banknote(500));

        $banknotesCollection->add(new Banknote(1000));
        $banknotesCollection->add(new Banknote(1000));
        $banknotesCollection->add(new Banknote(1000));

        // Amount 4950
        $banknotesStorage = new BanknotesStorage($banknotesCollection);
        $this->atm = new Atm($banknotesStorage);
    }

    public function testAtmGetCashThrowsNotEnoughMoneyException()
    {
        $this->expectException(NotEnoughMoneyException::class);

        $banknotesCollection = new SimpleBanknotesCollection();

        $this->atm->getCash(5000, $banknotesCollection);
    }

    public function testAtmGetCashThrowsWrongRequestedAmountException()
    {
        $this->expectException(WrongRequestedAmountException::class);

        $banknotesCollection = new SimpleBanknotesCollection();

        $this->atm->getCash(4930, $banknotesCollection);
    }

    public function testAtmGetCash()
    {
        $banknotesCollection = new SimpleBanknotesCollection();

        $outputCollection = $this->atm->getCash(3750, $banknotesCollection);

        $this->assertEquals(3, $outputCollection->count(1000));
        $this->assertEquals(1, $outputCollection->count(500));
        $this->assertEquals(2, $outputCollection->count(100));
        $this->assertEquals(1, $outputCollection->count(50));
        $this->assertEquals(3750, $outputCollection->getAmount());
    }
}