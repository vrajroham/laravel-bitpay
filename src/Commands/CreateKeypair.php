<?php

namespace Vrajroham\LaravelBitpay\Commands;

use Bitpay\Client\BitpayException;
use BitPayKeyUtils\KeyHelper\PrivateKey;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Vrajroham\LaravelBitpay\Traits\CreateKeypairTrait;

class CreateKeypair extends Command
{
    private $config;
    private $privateKey;
    private $publicKey;
    private $storageEngine;
    private $sin;
    private $client;
    private $network;
    private $adapter;
    private $pairingCode;
    private $pairingCodeLabel = 'Laravel_BitPay';
    private $token;
    private $bar;
    use CreateKeypairTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-bitpay:createkeypair';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create and persist keypairs. Pair client with BitPay server.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->bar = $this->output->createProgressBar(7);

        $this->bar->setProgressCharacter('⚡');
        $this->bar->setBarCharacter('-');
        $this->bar->setEmptyBarCharacter(' ');

        $this->line('');

        $this->validateAndLoadConfig();

        $this->createAndPersistKeypair();

        $this->pairWithServerAndCreateToken();

        $this->writeNewEnvironmentFileWith();

        $this->laravel['config']['laravel-bitpay.token'] = $this->token;

        $this->line('');

        $this->line('<options=bold,underscore>Token</> - <options=bold;fg=green>'.$this->token.'</> //(Token copied to .env for you)');
        $this->line('<options=bold,underscore>Pairing code</> - <options=bold;fg=green>'.$this->pairingCode.'</>');

        $this->line('');

        $this->line('Please, copy the above pairing code and approve on your BitPay Account at the following link:');

        $this->line('');

        $this->line('Open -> <href='.$this->network.'/dashboard/merchant/api-tokens>'.$this->network.'/dashboard/merchant/api-tokens</>');

        $this->line('');

        $this->info('Once you have this Pairing Code approved you can start using the Client. ⛳');
    }

    /**
     * Create private key and public key. Store keypair in file storgae.
     */
    public function createAndPersistKeypair()
    {
        $this->bar->advance();
        $this->info(' - Generating private key.');

        $this->privateKey = new PrivateKey($this->config['private_key']);
        $this->privateKey->generate();

        $this->bar->advance();
        $this->info(' - Generating public key.');

        $this->publicKey = $this->privateKey->getPublicKey();

        if (in_array('__construct', get_class_methods($this->config['key_storage']))) {
            $this->storageEngine = new $this->config['key_storage']($this->config['key_storage_password']);
        } else {
            $this->storageEngine = new $this->config['key_storage']();
        }

        $this->bar->advance();
        $this->info(' - Using <options=bold;fg=red>'.get_class($this->storageEngine).'</> for secure storage.');

        $this->storageEngine->persist($this->privateKey);

        $this->bar->advance();
        $this->info(' - Keypairs stored securely.');
    }

    /**
     * Create token on server using generated keypairs and pair the client with server using pairing code.
     *
     * @throws \Bitpay\Client\BitpayException
     */
    public function pairWithServerAndCreateToken()
    {
        $this->sin = $this->publicKey->getSin()->__toString();

        $this->bar->advance();
        $this->info(' - Created Service Identification Number (SIN Key) for client.');

        if ('testnet' == $this->config['network']) {
            $this->network = 'https://test.bitpay.com';
        } elseif ('livenet' == $this->config['network']) {
            $this->network = 'https://bitpay.com';
        } else {
            $this->network = 'https://bitpay.com';
        }

        $bitpayClient = new Client(['base_uri' => $this->network]);

        $this->bar->advance();
        $this->info(' - Connecting Bitpay server 🖥️  and generating token & pairing code.');

        try {
            $this->pairingCodeLabel = config('app.name').'_BitPay_Client';
            $postData = [
                'id'     => (string) $this->sin,
                'label'  => $this->pairingCodeLabel,
                'facade' => 'merchant',
            ];
            $response = $bitpayClient->post('/tokens', [
                'json'    => $postData,
                'headers' => [
                    'x-accept-version: 2.0.0',
                    'Content-Type: application/json',
                    // Todo: If added below headers, bitpay responds with error, "This endpoint does not support the `user` facade"
                    // 'x-identity' => $this->publicKey->__toString(),
                    // 'x-signature' => $this->privateKey->sign($this->network.'/tokens'.json_encode($postData)),
                ],
            ]);
            $response = json_decode($response->getBody()->getContents());
        } catch (BitpayException $bitpayException) {
            throw $bitpayException;
        }

        $this->bar->finish();
        $this->info(' - New token and pairing code received from Bitpay server.');
        $this->token = $response->data[0]->token;
        $this->pairingCode = $response->data[0]->pairingCode;
    }
}
