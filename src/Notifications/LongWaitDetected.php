<?php

namespace Ugarit\Horizon\Notifications;

use Heritage\Bus\Queueable;
use Heritage\Notifications\Messages\MailMessage;
use Heritage\Notifications\Messages\NexmoMessage;
use Heritage\Notifications\Messages\SlackMessage;
use Heritage\Notifications\Notification;
use Heritage\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Heritage\Notifications\Slack\SlackMessage as ChannelIdSlackMessage;
use Heritage\Support\Str;
use Ugarit\Horizon\Contracts\LongWaitDetectedNotification;
use Ugarit\Horizon\Horizon;

class LongWaitDetected extends Notification implements LongWaitDetectedNotification
{
    use Queueable;

    /**
     * The queue connection name.
     *
     * @var string
     */
    public $longWaitConnection;

    /**
     * The queue name.
     *
     * @var string
     */
    public $longWaitQueue;

    /**
     * The wait time in seconds.
     *
     * @var int
     */
    public $seconds;

    /**
     * Create a new notification instance.
     *
     * @param  string  $connection
     * @param  string  $queue
     * @param  int  $seconds
     * @return void
     */
    public function __construct($connection, $queue, $seconds)
    {
        $this->longWaitQueue = $queue;
        $this->seconds = $seconds;
        $this->longWaitConnection = $connection;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return array_filter([
            Horizon::$slackWebhookUrl ? 'slack' : null,
            Horizon::$smsNumber ? 'nexmo' : null,
            Horizon::$email ? 'mail' : null,
        ]);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Heritage\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->error()
            ->subject(config('horizon.name').': Long Queue Wait Detected')
            ->greeting('Oh no! Something needs your attention.')
            ->line(sprintf(
                'The "%s" queue on the "%s" connection has a wait time of %s seconds.',
                $this->longWaitQueue, $this->longWaitConnection, $this->seconds
            ));
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Heritage\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        $fromName = 'Ugarit Horizon';
        $title = 'Long Wait Detected';
        $text = 'Oh no! Something needs your attention.';
        $imageUrl = 'https://ugarit.com/assets/img/horizon-48px.png';

        $content = sprintf(
            '[%s] The "%s" queue on the "%s" connection has a wait time of %s seconds.',
            config('horizon.name'),
            $this->longWaitQueue,
            $this->longWaitConnection,
            $this->seconds
        );

        if (class_exists('\Heritage\Notifications\Slack\SlackMessage') &&
            class_exists('\Heritage\Notifications\Slack\BlockKit\Blocks\SectionBlock') &&
            ! (is_string(Horizon::$slackWebhookUrl) && Str::startsWith(Horizon::$slackWebhookUrl, ['http://', 'https://']))) {
            return (new ChannelIdSlackMessage)
                ->username($fromName)
                ->image($imageUrl)
                ->text($text)
                ->headerBlock($title)
                ->sectionBlock(function (SectionBlock $block) use ($content): void { // @phpstan-ignore-line
                    $block->text($content);
                });
        }

        return (new SlackMessage) // @phpstan-ignore-line
            ->from($fromName)
            ->to(Horizon::$slackChannel)
            ->image($imageUrl)
            ->error()
            ->content($text)
            ->attachment(function ($attachment) use ($title, $content) {
                $attachment->title($title)
                    ->content($content);
            });
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Heritage\Notifications\Messages\NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)->content(sprintf( // @phpstan-ignore-line
            '[%s] The "%s" queue on the "%s" connection has a wait time of %s seconds.',
            config('horizon.name'), $this->longWaitQueue, $this->longWaitConnection, $this->seconds
        ));
    }

    /**
     * The unique signature of the notification.
     *
     * @return string
     */
    public function signature()
    {
        return md5($this->longWaitConnection.$this->longWaitQueue);
    }
}
