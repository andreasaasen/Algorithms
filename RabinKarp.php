<?php

class RollingHash
{
    public function __construct($text, $wordLength)
    {
        $this->result = null;
        $this->text = $text;
        $this->wordLength = strlen($wordLength);
        $this->hash = 0;
        $this->base = 255;
        for ($i = 0; $i < $this->wordLength; $i++) {
            $this->hash += $this->hashLetter($text[$i], $this->wordLength, $i);
        }

        $this->start = 0;
        $this->end = $this->wordLength;
    }

    public function move()
    {
        if ($this->end <=strlen($this->text) - 1) {
            $this->hash -= ord($this->text[$this->start]) * $this->base**($this->wordLength -1);
            $this->hash *= $this->base;
            $this->hash +=  ord($this->text[$this->end]);
            $this->start +=1;
            $this->end += 1;

        }
    }

    public function scopeText()
    {
        $this->result = $this->text[$this->start];
        return substr($this->text, $this->start, $this->wordLength);
        //return $this->result;
    }

    private function hashLetter($text, $wordLength, $position)
    {
        return (ord($text) * ($this->base**($wordLength - $position -1)));
    }
}

function rabinKarp($word, $text) {
    if ($word =="" || $text == "") {
        return null;
    }
    if (strlen($word) > strlen($text)) {

        return null;
    }

    $rollingHash = new RollingHash($text, $word);
    $wordHash = new RollingHash($word, $word);


    for ($i = 0, $iMax = strlen($text); $i <= $iMax; $i++) {
        var_dump($wordHash->hash);
        if ($rollingHash->hash == $wordHash->hash) {

            if ($rollingHash->scopeText() == $word) {
                return "Ja din text finns på index: ". $i. "\n";
            }
        }
            $rollingHash->move();
    }
        return null;
}

echo rabinKarp("A", "aAbcde");