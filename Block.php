<?php declare(strict_types=1);

class Block
{
    const HASH_TYPE = 'sha256';

    private $previousHash;

    private $transactions = [];

    private $blockHash;

    public function __construct($previousHash, $transactions)
    {
        $this->previousHash = $previousHash;
        $this->transactions = $transactions;
        $contents = [$this->hashIt(serialize($transactions)), $previousHash];
        $this->blockHash = $this->hashIt(serialize($contents));
    }

    public function getPreviousHash(): string
    {
        return $this->previousHash;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function getBlockHash(): string
    {
        return $this->blockHash;
    }

    private function hashIt($content): string
    {
        return hash(self::HASH_TYPE, $content);
    }
}
