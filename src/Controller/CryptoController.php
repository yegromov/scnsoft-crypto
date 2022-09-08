<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Denpa\Bitcoin\Client as BitcoinClient;

class CryptoController
{
    #[Route('/bitcoin')]
    public function bitcoin(): Response
    {
        $bitcoind = new BitcoinClient('http://rpcuser:rpcpassword@localhost:8332/');

        $block = $bitcoind->getBlock('000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f');

        $block('hash')->get();     // 000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f
        $block['height'];          // 0 (array access)
        $block->get('tx.0');       // 4a5e1e4baab89f3a32518a88c31bc87f618f76673e2cc77ab2127b7afdeda33b
        $block->count('tx');       // 1
        $block->has('version');    // key must exist and CAN NOT be null
        $block->exists('version'); // key must exist and CAN be null
        $block->contains(0);       // check if response contains value
        $block->values();          // array of values
        $block->keys();            // array of keys
        $block->random(1, 'tx');   // random block txid
        $block('tx')->random(2);   // two random block txid's
        $block('tx')->first();     // txid of first transaction
        $block('tx')->last();      // txid of last transaction

        return new Response(
            '<html><body>Bitcoin</body></html>'
        );
    }

    #[Route('/eth')]
    public function eth(): Response
    {
        return new Response(
            '<html><body>Eth</body></html>'
        );
    }
}
