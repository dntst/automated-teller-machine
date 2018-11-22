<?php

namespace Atm;

use Atm\BanknotesCollection\BanknotesCollectionInterface;
use Atm\Exception\NotEnoughMoneyException;
use Atm\Exception\WrongRequestedAmountException;

class Atm
{
    private $banknotesStorage;

    public function __construct(BanknotesStorage $banknotesStorage)
    {
        $this->banknotesStorage = $banknotesStorage;
    }

    /**
     * @param int $requestedAmount
     * @param BanknotesCollectionInterface $externalCollection
     * @return BanknotesCollectionInterface
     * @throws NotEnoughMoneyException|WrongRequestedAmountException
     */
    public function getCash(int $requestedAmount, BanknotesCollectionInterface $externalCollection): BanknotesCollectionInterface
    {
        $remainingAmount = $requestedAmount;
        $atmCollection = $this->banknotesStorage->getBanknotesCollection();

        if ($requestedAmount > $atmCollection->getAmount()) {
            throw new NotEnoughMoneyException('Not enough money.');
        }

        while ($remainingAmount > 0) {
            foreach ($atmCollection->getSortedBanknotesValues() as $banknoteValue) {
                if ($remainingAmount - $banknoteValue < 0) {
                    continue;
                }
                $remainingAmount -= $banknoteValue;
                $atmCollection->remove($banknoteValue);
                $externalCollection->add(new Banknote($banknoteValue));
                break;
            }

            if ($remainingAmount === 0) {
                return $externalCollection;
            } elseif ($remainingAmount < $atmCollection->getSortedBanknotesValues(BanknotesCollectionInterface::SORT_ASC)[0]) {
                break;
            }
        }

        throw new WrongRequestedAmountException('Cannot complete request for that amount.');
    }
}