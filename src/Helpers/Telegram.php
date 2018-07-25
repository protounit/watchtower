<?php
namespace Protounit\WatchTower\Helpers;

use Monolog\Logger;

/**
 * Class Telegram
 * Telegram handler. Creates message with default template and formatting
 */
class Telegram
{
    /**
     * Configuration
     *
     * @var array
     */
    protected $config;

    /**
     * ChannelId
     *
     * @var string
     */
    protected $channel;

    /**
     * Message
     *
     * @var string
     */
    protected $message;

    /**
     * Custom template for sprintf()
     *
     * @var string
     */
    protected $template = '<b>%s %s</b>\n<b>%s</b>\n\n<pre>%s</pre>\n<i>%s | %s</i>';

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config  = $config;
        $this->channel = $config['channelId'];
    }

    /**
     * Telegram channelId getter
     *
     * @return string
     */
    public function getChannel() : string
    {
        return $this->channel;
    }

    /**
     * Message getter
     *
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Message formatter
     *
     * @param  array  $record
     * @return string
     */
    public function formatRecord(array $record) : string
    {
        /** @var \DateTime $time */
        $message   = $record['message']    ?? 'No message';
        $context   = $record['context']    ?? '';
        $level     = $record['level']      ?? Logger::DEBUG;
        $levelName = $record['level_name'] ?? 'ERROR';
        $channel   = $record['channel']    ?? 'default';
        $time      = $record['datetime']   ?? new \DateTime();

        $time->setTimezone(new \DateTimeZone($this->config['timeZone']));

        $this->message = sprintf(
            $this->template,
            $this->getEmojiByLevel($level),
            $levelName,
            $message,
            $this->contextToString($context),
            $channel,
            $time->format('Y-m-d H:i:s')
        );

        return $this->filterMessage($this->message);
    }

    /**
     * Line delimeter filter
     *
     * @param  string $text
     * @return string
     */
    protected function filterMessage(string $text) : string
    {
        return str_replace('\n', PHP_EOL, $text);
    }

    /**
     * Return emoji for each LogLevel
     *
     * @param  integer $level
     * @return string
     */
    protected function getEmojiByLevel(int $level) : string
    {
        $emoji = [
            Logger::DEBUG     => '🦀',
            Logger::INFO      => '‍♻️',
            Logger::NOTICE    => '📜',
            Logger::WARNING   => '⚠️',
            Logger::ERROR     => '⛔️',
            Logger::CRITICAL  => '🔥',
            Logger::ALERT     => '❌',
            Logger::EMERGENCY => '🆘',
        ];

        return $emoji[$level] ?? $emoji[Logger::DEBUG];
    }

    /**
     * Array to json pretty string converter
     *
     * @param  array  $context
     * @return string
     */
    protected function contextToString(array $context) : string
    {
        return json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
