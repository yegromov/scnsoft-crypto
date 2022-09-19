<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Denpa\Bitcoin\Client as BitcoinClient;
use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;

class CryptoController extends AbstractController
{
    #[Route('/bitcoin')]
    public function bitcoin(): Response
    {   
        $bitcoinHost = $this->getParameter('app.bitcoin.host');
        $bitcoinPort = $this->getParameter('app.bitcoin.port');
        $bitcoinUser = $this->getParameter('app.bitcoin.username');
        $bitcoinPassword = $this->getParameter('app.bitcoin.password');

        $bitcoind = new BitcoinClient('http://'.$bitcoinUser.':'.$bitcoinPassword.'@'.$bitcoinHost.':'.$bitcoinPort.'/');
        
        $data = $bitcoind->getBlockChainInfo();
        $blockChainInfo = json_encode($data, JSON_PRETTY_PRINT);

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

        $blockdata = print_r($block, true);


        return new Response(
            '<html><body>Bitcoin <pre>' . $blockChainInfo . '</pre></body></html>'
        );
    }

    #[Route('/eth')]
    public function eth(): Response
    {
        $web3 = new Web3(new HttpProvider(new HttpRequestManager("ADD_YOUR_ETHEREUM_NODE_URL")));

        $eth = $web3->eth;

        $eth->blockNumber(function ($err, $data) {
            echo "Latest block number is: " . $data . " \n";
        });
        return new Response(
            '<html><body>Eth</body></html>'
        );
    }
}
