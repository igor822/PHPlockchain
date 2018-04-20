<?php declare(strict_types=1);

namespace Blockchain;

class Block
{
    const HASH_TYPE = 'sha256';

    private $previousHash;

    private $data = [];

    private $blockHash;

    private $timestamp;

    private $bits;

    private $nounce;

    public function __construct(
        string $previousHash,
        int $timestamp,
        BlockContent $data,
        string $bits = '1b00ffff',
        int $nounce = 1
    ) {
        $this->previousHash = $previousHash;
        $this->data = $data;
        $this->timestamp = $timestamp;
        $this->bits = $bits;
        $this->nounce = $nounce;
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
        $contents = [
            serialize($this->data),
            $this->timestamp,
            $this->previousHash,
            $this->bits,
            $this->nounce
        ];
        $hash = $this->hashIt(serialize($contents));
        return $hash;
    }

    public function mineBlock(int $dificulty): self
    {
        $target = $this->getTargetFromBits();
        $hash = $this->blockHash;
        while (base_convert($hash, 16, 10) > $target) {
            $this->nounce++;
            $hash = $this->calculateHash();
        }
        return $this;
    }

    public function getTargetFromBits(): float
    {
        $exponent = hexdec(substr($this->bits, 0, 2));
        $coefficient = hexdec(substr($this->bits, 2));

        return $coefficient * 2 ** (8 * ($exponent - 3));
    }

    public function getPreviousHash(): string
    {
        return $this->previousHash;
    }

    public function getData(): BlockContent
    {
        return $this->data;
    }

    public function getHash(): string
    {
        return $this->blockHash;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getBits(): string
    {
        return $this->bits;
    }

    public function getNounce(): int
    {
        return $this->nounce;
    }

    private function hashIt($content): string
    {
        return hash(self::HASH_TYPE, $content);
    }
}
