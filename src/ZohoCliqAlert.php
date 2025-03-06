<?php

namespace MarJose123\ZohoCliqAlert;

use MarJose123\ZohoCliqAlert\Jobs\SendToCliqJob;

class ZohoCliqAlert
{
    /**
     * Zoho Cliq User Email address
     */
    protected string $to = '';

    /**
     * Channel Name on where the message should be sent.
     */
    protected string $channel = '';

    protected string $botName = '';

    protected bool $markAsRead = false;

    protected bool $sendAlsoToChannel = false;

    protected bool $sendAlsoToUser = false;

    protected ZohoDataCenter $zohoDataCenter;

    protected int $delay = 0;

    protected string $message = '';

    protected ?array $embed = [];

    protected ?string $queue = null;

    /**
     * @return $this
     */
    public function dataCenter(ZohoDataCenter $dataCenter): self
    {
        $this->zohoDataCenter = $dataCenter;

        return $this;
    }

    /**
     * @param  string  $id  Email Address of the Zoho Cliq user. This is not needed if you intended to send it in Channel
     * @return $this
     */
    public function to(string $id): static
    {
        $this->to = $id;
        $this->sendAlsoToUser = true;

        return $this;
    }

    /**
     * @param  string  $name  Name of the Zoho Cliq Channel
     * @return $this
     */
    public function channel(string $name): static
    {
        $this->channel = $name;
        $this->sendAlsoToChannel = true;

        return $this;
    }

    /**
     * @param  string  $botName  Use this parameter to send a message in a channel as a bot. Note that the bot should already be a participant in the channel.
     * @return $this
     */
    public function asBot(string $botName): self
    {
        $this->botName = $botName;

        return $this;
    }

    /**
     * @param  bool  $markAsRead  Use these to mark the sent message as read for the user. By default, the message will be unread for the message posted by the user.
     * @return $this
     */
    public function markAsRead(bool $markAsRead = true): self
    {
        $this->markAsRead = $markAsRead;

        return $this;
    }

    /**
     * @param  int  $minutes  Delay for sending the message
     * @return $this
     */
    public function delayMinutes(int $minutes = 0): self
    {
        $this->delay += $minutes;

        return $this;
    }

    /**
     * @param  int  $hours  Delay for sending the message
     * @return $this
     */
    public function delayHours(int $hours = 0): self
    {
        $this->delay += $hours * 60;

        return $this;
    }

    /**
     * @param  ?string  $queue  Queue connection name
     * @return $this
     */
    public function queue(?string $queue = 'default'): self
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * @param  string  $message  the message you want to display
     * @param  array  $embed  these are the message cards. See Zoho Cliq Cards: https://www.zoho.com/cliq/help/restapi/v2/#Message_Cards
     */
    public function message(string $message, array $embed = []): self
    {
        $this->message = $message;
        $this->embed = $embed;

        return $this;
    }

    public function send(): void
    {
        $payload = [
            'channel' => $this->channel,
            'bot' => $this->botName,
            'to' => $this->to,
            'message' => $this->message,
            'embed' => $this->embed,
            'dataCenter' => $this->zohoDataCenter,
            'markAsRead' => $this->markAsRead,
        ];

        SendToCliqJob::dispatch($payload)
            ->onQueue($this->queue)
            ->delay($this->delay)
            ->afterResponse()
            ->afterCommit();
    }
}
