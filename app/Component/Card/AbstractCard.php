<?php
namespace App\Component\Card;

abstract class AbstractCard
{
    private const SBERBANK = 'sberbank';
    private const TINKOFF = 'tinkoff';
    private const ALPHA = 'alpha bank';

    public function getCardService(): string
    {
        $codeCard = substr($this->getCard(), 0, 4);

        return match ($codeCard) {
            '1134' => 'Visa',
            '1235' => 'Mastercard',
            '1344' => 'Mir',
            default => 'Unknown',
        };
    }

    public function getCardBank(): string
    {
        $codeCard = substr($this->getCard(), 0, 5);

        return match ($codeCard) {
            '11341', '12351', '13441' => self::SBERBANK,
            '11342', '12352', '13442' => self::TINKOFF,
            '11343', '12353', '13443' => self::ALPHA,
            default => 'Unknown',
        };
    }
}