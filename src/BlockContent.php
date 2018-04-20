<?php declare(strict_types=1);

namespace Blockchain;

final class BlockContent
{
    private $data;

    public function __construct($data = null)
    {
        return $this->data;
    }

    public function getData()
    {
        return $data;
    }

    public function __toString()
    {
        return json_encode($this->data);
    }
}
