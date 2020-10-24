<?php

namespace System\Support\Session;

interface FlashInterface
{

    public function add($type, $message);

    public function name(string $name);

    public function get(string $name, ...$types);

    public function has(string $name);

}