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
        if ($this->getPreviousHash() !== $previousBlock->getHash()) {
            return false;
        }

        if ($this->calculateHash() !== $this->getHash()) {
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

    // @TODO 
    public function mineBlock(int $dificulty): void
    {
        return;
        $target = '';
        for ($i = 0; $i < $dificulty; $i++) {
            $target .= '0';
        }
        $hash = $this->blockHash;
        while (substr($hash, 0, $dificulty) != $target) {
            $nounce++;
            $hash = $this->calculateHash();
        }
    }

    public function getPreviousHash(): string
    {
        return $this->previousHash;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getHash(): string
    {
        return $this->blockHash;
    }

    private function hashIt($content): string
    {
        return hash(self::HASH_TYPE, $content);
    }
}
