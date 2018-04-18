<?php declare(strict_types=1);

class Block
{
    const HASH_TYPE = 'sha256';

    private $previousHash;

    private $data = [];

    private $blockHash;

    private $timestamp;

    public function __construct(string $previousHash, int $timestamp, array $data)
    {
        $this->previousHash = $previousHash;
        $this->data = $data;
        $this->timestamp = $timestamp;
        $this->blockHash = $this->calculateHash();
    }

    public function isValid(Block $previousBlock): bool
    {
        if ($this->getPreviousHash() !== $previousBlock->getBlockHash()) {
            return false;
        }

        if ($this->calculateHash() !== $this->getBlockHash()) {
            return false;
        }

        return true;
    }

    public function calculateHash(): string
    {
        $contents = [serialize($this->data), $this->timestamp, $this->previousHash];
        $hash = $this->hashIt(serialize($contents));
        return $hash;
    }

    public function getPreviousHash(): string
    {
        return $this->previousHash;
    }

    public function getData(): array
    {
        return $this->data;
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
