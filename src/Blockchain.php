<?php declare(strict_types=1);

namespace Blockchain;

class Blockchain
{
    private $chain;

    private $previousBlock;

    public function __construct()
    {
        $this->previousBlock = $this->newBlock(['genesis block']);
        $this->chain[] = $this->previousBlock;
    }

    public function newBlock(array $data): Block
    {
        $previousHash = $this->previousBlock ? $this->previousBlock->getHash() : 0;
        $block = new Block(
            (string) $previousHash,
            (new \DateTime())->getTimestamp(),
            $data
        );
        $this->chain[] = $block;
        return $block;
    }

    public function addBlock(Block $block): void
    {
        if ($this->isValidNewBlock($block, $this->getLastBlock())) {
            $this->previousBlock = $this->getLastBlock();
            $this->chain[] = $block;
        }
    }

    public function getLastBlock(): Block
    {
        return $this->chain[count($this->chain) - 1];
    }

    private function isValidNewBlock(Block $newBlock, Block $previousBlock): bool
    {
        if ($previousBlock->getHash() !== $newBlock->getPreviousHash()) {
            return false;
        }

        if ($newBlock->calculateHash() !== $newBlock->getHash()) {
            return false;
        }

        return true;
    }
}
