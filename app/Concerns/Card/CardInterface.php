<?php

namespace App\Concerns\Card;

interface CardInterface
{
    public function getCard();

    public function setCard(string $card);
}