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

    /**
     * @param string $previousHash
     * @param int $timestamp
     * @param BlockContent $data
     * @param string $bits
     * @param int $nounce
     */
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

    /**
     * @param Block $previousBlock
     * @return bool
     */
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

    /**
     * @return string
     */
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

    /**
     * @return self
     */
    public function mineBlock(): self
    {
        $target = $this->getTargetFromBits();
        $hash = $this->blockHash;
        while (base_convert($hash, 16, 10) > $target) {
            $this->nounce++;
            $hash = $this->calculateHash();
        }
        return $this;
    }

    /**
     * @return float
     */
    public function getTargetFromBits(): float
    {
        $exponent = hexdec(substr($this->bits, 0, 2));
        $coefficient = hexdec(substr($this->bits, 2));

        return $coefficient * 2 ** (8 * ($exponent - 3));
    }

    /**
     * @return string
     */
    public function getPreviousHash(): string
    {
        return $this->previousHash;
    }

    /**
     * @return BlockContent
     */
    public function getData(): BlockContent
    {
        return $this->data;
    }

    /**
     * @return string 
     */
    public function getHash(): string
    {
        return $this->blockHash;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getBits(): string
    {
        return $this->bits;
    }

    /**
     * @return int
     */
    public function getNounce(): int
    {
        return $this->nounce;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode([
            'hash' => $this->blockHash,
            'data' => $this->getData(),
            'previousHash' => $this->previousHash,
        ]);
    }

    /**
     * @return string
     */
    private function hashIt($content): string
    {
        return hash(self::HASH_TYPE, $content);
    }
}
