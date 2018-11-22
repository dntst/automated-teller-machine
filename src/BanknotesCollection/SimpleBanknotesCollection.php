<?php

namespace Atm\BanknotesCollection;

use Atm\Banknote;

class SimpleBanknotesCollection implements BanknotesCollectionInterface
{
    private $collection = [];

    public function add(Banknote $banknote)
    {
        if(!array_key_exists($banknote->getValue(), $this->collection)) {
            $this->collection[$banknote->getValue()] = 0;
        }

        $this->collection[$banknote->getValue()]++;
    }

    public function remove(int $value): bool
    {
        if(!array_key_exists($value, $this->collection)) {
            return false;
        }

        $this->collection[$value]--;

        if($this->collection[$value] === 0) {
            unset($this->collection[$value]);
        }

        return true;
    }

    public function count(int $value): int
    {
        if(!array_key_exists($value, $this->collection)) {
            return 0;
        }

        return $this->collection[$value];
    }

    public function getSortedBanknotesValues(int $sort = self::SORT_DESC): array
    {
        $collection = $this->collection;
        if($sort === self::SORT_ASC) {
            ksort($collection);
        } else {
            krsort($collection);
        }
        $collection = array_keys($collection);

        return $collection;
    }

    public function getAmount(): int
    {
        $amount = 0;

        array_walk($this->collection, function($key, $value) use (&$amount) {
            $amount += $key * $value;
        });

        return $amount;
    }
}