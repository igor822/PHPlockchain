<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Blockchain\Block;

class BlockTest extends TestCase
{
    public function testInitial()
    {
        $block = new Block('0', 1234, []);

        $this->assertInstanceOf(Block::class, $block);
    }

    public function testDefinedData()
    {
        $previousHash = '0';
        $timestamp = 1234;
        $data = [];
        $block = new Block($previousHash, $timestamp, $data);

        $this->assertEquals($previousHash, $block->getPreviousHash());
        $this->assertEquals($data, $block->getData());
    }

    public function testCreateHash()
    {
        $previousHash = '0';
        $timestamp = 1234;
        $data = [];
        $block = new Block($previousHash, $timestamp, $data);

        $contents = [serialize($data), $timestamp, $previousHash];
        $hash = hash(Block::HASH_TYPE, serialize($contents));

        $this->assertEquals($block->calculateHash(), $hash);
    }

    public function testValidationBlock()
    {
        $mock = $this->getMockBuilder(Block::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->method('getHash')->willReturn('0');

        $previousHash = '0';
        $timestamp = 1234;
        $data = [];
        $block = new Block($previousHash, $timestamp, $data);

        $this->assertTrue($block->isValid($mock));
    }
}
