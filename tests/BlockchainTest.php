<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Blockchain\Blockchain;
use Blockchain\BlockContent;
use Blockchain\Block;

class BlockchainTest extends TestCase
{
    public function testInitial()
    {
        $blockchain = new Blockchain();

        $this->assertInstanceOf(Blockchain::class, $blockchain);
    }

    public function testCreationOfNewBlock()
    {
        $data = new BlockContent();

        $blockchain = new Blockchain();
        $block = $blockchain->newBlock($data);

        $this->assertInstanceOf(Block::class, $block);
        $this->assertEquals($data, $block->getData());
    }

    public function testGenerateHashFromGeneratedBlock()
    {
        $data = new BlockContent();

        $blockchain = new Blockchain();
        $block = $blockchain->newBlock($data);

        $previousHash = $block->getPreviousHash();
        $timestamp = $block->getTimestamp();
        $nounce = $block->getNounce();
        $bits = $block->getBits();

        $contents = [serialize($data), $timestamp, $previousHash, $bits, $nounce];
        $hash = hash(Block::HASH_TYPE, serialize($contents));

        $this->assertEquals($hash, $block->getHash());
    }

    public function testSimilarityBetweenSameBlock()
    {
        $data = new BlockContent();

        $blockchain = new Blockchain();
        $block = $blockchain->newBlock($data);

        $this->assertEquals($block, $blockchain->getLastBlock());
    }
}
