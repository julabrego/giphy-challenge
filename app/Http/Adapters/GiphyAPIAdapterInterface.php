<?php

namespace App\Http\Adapters;

interface GiphyApiAdapterInterface
{
    public function search(string $q, ?int $limit = null, ?int $offset = null);
}
