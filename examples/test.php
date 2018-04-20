<?php

use Blockchain\Block;
use Blockchain\BlockContent;

require __DIR__ . '/../vendor/autoload.php';

$genesisTransaction = new BlockContent(['a sends 11 bitcoins to b', 'b sends 44 bitcoins to c']);
$genesisBlock = new Block(0, (new \DateTime())->getTimestamp(), $genesisTransaction);

$blockTransaction = new BlockContent(['a sends 11 bitcoins to b', 'b sends 44 bitcoins to c']);
$block1 = new Block($genesisBlock->getHash(), (new \DateTime())->getTimestamp(), $blockTransaction);

$block2Transaction = new BlockContent(['a sends 11 bitcoins to b', 'b sends 44 bitcoins to c']);
$block2 = new Block($block1->getHash(), (new \DateTime())->getTimestamp(), $block2Transaction);

echo sprintf('Genesis Block: %s' . PHP_EOL, $genesisBlock->getHash());
echo sprintf('Block 1: %s' . PHP_EOL, $block1->getHash());
echo sprintf('Block 2: %s' . PHP_EOL, $block2->getHash());

var_dump($block1->isValid($genesisBlock));

echo ($block1);
