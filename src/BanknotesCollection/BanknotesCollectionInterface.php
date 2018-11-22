<?php

namespace Atm\BanknotesCollection;

use Atm\Banknote;

interface BanknotesCollectionInterface
{
    const SORT_ASC = 1;
    const SORT_DESC = 2;

    public function add(Banknote $banknote);

    public function remove(int $value): bool;

    public function count(int $value): int;

    public function getSortedBanknotesValues(int $sort = self::SORT_DESC): array;

    public function getAmount(): int;
}