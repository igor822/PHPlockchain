<?php

require 'Blockchain.php';
require 'Block.php';

$blockchain = new Blockchain();

$blockTransaction = ['a sends 11 bitcoins to b', 'b sends 44 bitcoins to c'];
$block1 = new Block(
    $blockchain->getLatestBlock()->getHash(),
    (new \DateTime())->getTimestamp(),
    $blockTransaction
);

$blockchain->addBlock($block1);

$block2Transaction = ['a sends 11 bitcoins to b', 'b sends 44 bitcoins to c'];
$block2 = new Block($block1->getHash(), (new \DateTime())->getTimestamp(), $block2Transaction);

$blockchain->addBlock($block2);

var_dump($blockchain);
