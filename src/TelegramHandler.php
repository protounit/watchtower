<?php
namespace Protounit\WatchTower;

use Monolog\Handler\AbstractProcessingHandler;
use Protounit\WatchTower\Helpers\Guzzle;
use Protounit\WatchTower\Helpers\Telegram;

/**
 * Class TelegramHandler
 * Client interface for dialog between Monolog and Telegram
 */
class TelegramHandler extends AbstractProcessingHandler
{
    /**
     * Configuration array
     *
     * @var array
     */
    protected $config;

    /**
     * Guzzle HTTP client helper object
     *
     * @var \Protounit\WatchTower\Helpers\Guzzle
     */
    protected $guzzle;

    /**
     * Telegram API client helper object
     *
     * @var \Protounit\WatchTower\Helpers\Telegram
     */
    protected $telegram;

    /**
     * TelegramHandler constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->config   = $options;
        $this->guzzle   = new Guzzle($options);
        $this->telegram = new Telegram($options);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $record
     */
    public function write(array $record)
    {
        $this->guzzle->sendMessage(
            $this->telegram->getChannel(),
            $this->telegram->formatRecord($record)
        );
    }
}
