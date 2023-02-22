<?php

namespace App\Component\Card;

use App\Concerns\Card\CardInterface;

class Card extends AbstractCard implements CardInterface
{
    private string $card;

    /**
     * @return string
     */
    public function getCard(): string
    {
        return preg_replace('/\s+/', '', $this->card);
    }

    /**
     * @param  string  $card
     */
    public function setCard(string $card): void
    {
        $this->card = $card;
    }
}