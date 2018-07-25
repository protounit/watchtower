<?php
namespace Protounit\WatchTower\Helpers;

use GuzzleHttp\Client;

/**
 * Class Guzzle
 * Creates client and sends message to channel
 */
class Guzzle
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->client = new Client([
            'base_uri' => 'https://api.telegram.org/bot' . $config['botId'] . '/sendMessage'
        ]);
    }

    /**
     * Send message via GuzzleHttp and die to prevent fork bomb
     *
     * @param string $channel
     * @param string $message
     */
    public function sendMessage(string $channel, string $message)
    {
        $pid = pcntl_fork();

        if ($pid === -1) {
            die('Unable to create child process');
        }

        if (!$pid) {
            try {
                $this->client->post(
                    '',
                    [
                        'form_params' => [
                            'parse_mode' => 'html',
                            'chat_id' => $channel,
                            'text' => $message,
                        ],
                    ]
                );
            } catch (\Throwable $exception) {
                // Won't control child process
                die('error');
            }

            die('Ok');
        }

    }
}
