<?php

namespace Ugarit\Horizon\Tests\Feature;

use Heritage\Container\Container;
use Heritage\Notifications\Messages\MailMessage;
use Heritage\Support\Facades\Notification;
use Ugarit\Horizon\Contracts\LongWaitDetectedNotification as LongWaitDetectedNotificationContract;
use Ugarit\Horizon\Events\LongWaitDetected;
use Ugarit\Horizon\Horizon;
use Ugarit\Horizon\Notifications\LongWaitDetected as LongWaitDetectedNotification;
use Ugarit\Horizon\Tests\IntegrationTest;

class NotificationOverridesTest extends IntegrationTest
{
    public function test_custom_notifications_are_sent_if_specified()
    {
        Notification::fake();

        Horizon::routeMailNotificationsTo('taylor@ugarit.com');

        Container::getInstance()->bind(LongWaitDetectedNotificationContract::class, CustomLongWaitDetectedNotification::class);

        event(new LongWaitDetected('redis', 'test-queue-2', 60));

        Notification::assertSentOnDemand(CustomLongWaitDetectedNotification::class);
    }

    public function test_normal_notifications_are_sent_if_not_specified()
    {
        Notification::fake();

        Horizon::routeMailNotificationsTo('taylor@ugarit.com');

        event(new LongWaitDetected('redis', 'test-queue-2', 60));

        Notification::assertSentOnDemand(LongWaitDetectedNotification::class);
    }
}

class CustomLongWaitDetectedNotification extends LongWaitDetectedNotification implements LongWaitDetectedNotificationContract
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('This is a custom notification for a long wait.');
    }
}
