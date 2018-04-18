<?php

require 'Block.php';

$genesisTransaction = ['a sends 11 bitcoins to b', 'b sends 44 bitcoins to c'];
$genesisBlock = new Block(0, (new \DateTime())->getTimestamp(), $genesisTransaction);

$blockTransaction = ['a sends 11 bitcoins to b', 'b sends 44 bitcoins to c'];
$block1 = new Block($genesisBlock->getBlockHash(), (new \DateTime())->getTimestamp(), $blockTransaction);

$block2Transaction = ['a sends 11 bitcoins to b', 'b sends 44 bitcoins to c'];
$block2 = new Block($block1->getBlockHash(), (new \DateTime())->getTimestamp(), $block2Transaction);

echo sprintf('Genesis Block: %s' . PHP_EOL, $genesisBlock->getBlockHash());
echo sprintf('Block 1: %s' . PHP_EOL, $block1->getBlockHash());
echo sprintf('Block 2: %s' . PHP_EOL, $block2->getBlockHash());

var_dump($block1->isValid($genesisBlock));
