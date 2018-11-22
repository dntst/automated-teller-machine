<?php

namespace Tests;

use Atm\Banknote;
use Atm\BanknotesCollection\BanknotesCollectionInterface;
use Atm\BanknotesCollection\SimpleBanknotesCollection;
use PHPUnit\Framework\TestCase;

final class SimpleBanknotesCollectionTest extends TestCase
{
    /**
     * @var BanknotesCollectionInterface
     */
    protected $banknotesCollection;

    protected function setUp()
    {
        $this->banknotesCollection = new SimpleBanknotesCollection();
        $this->banknotesCollection->add(new Banknote(100));
        $this->banknotesCollection->add(new Banknote(500));
        $this->banknotesCollection->add(new Banknote(500));
    }

    public function testSimpleBanknotesCollectionAddAndCount()
    {
        $this->assertEquals($this->banknotesCollection->count(50), 0);
        $this->assertEquals($this->banknotesCollection->count(100), 1);
        $this->assertEquals($this->banknotesCollection->count(500), 2);
    }

    public function testSimpleBanknotesCollectionRemove()
    {
        $this->assertFalse($this->banknotesCollection->remove(50));
        $this->assertTrue($this->banknotesCollection->remove(100));
        $this->assertFalse($this->banknotesCollection->remove(100));
        $this->assertTrue($this->banknotesCollection->remove(500));
        $this->assertTrue($this->banknotesCollection->remove(500));
        $this->assertFalse($this->banknotesCollection->remove(500));
    }

    public function testSimpleBanknotesCollectionGetAmount()
    {
        $this->assertEquals($this->banknotesCollection->getAmount(), 1100);
        $this->banknotesCollection->remove(100);
        $this->assertEquals($this->banknotesCollection->getAmount(), 1000);
    }
}