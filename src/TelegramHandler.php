<?php
namespace Protounit\WatchTower;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
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
     * @param array   $options
     * @param integer $level
     * @param boolean $bubble
     */
    public function __construct(array $options = [], $level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

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
            $this->telegram->formatRecord($record),
            $this->config['useFork'] ?? true
        );
    }
}
