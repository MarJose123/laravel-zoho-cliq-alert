<?php

namespace MarJose123\ZohoCliqAlert\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use MarJose123\ZohoCliqAlert\Concerns\Zoho;
use MarJose123\ZohoCliqAlert\Exceptions\CliqAlertException;
use MarJose123\ZohoCliqAlert\ZohoDataCenter;

class SendToCliqJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Zoho;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     */
    public int $maxExceptions = 3;

    /**
     * @param object{
     *     channel: string,
     *     bot: string,
     *     to: string,
     *     message: string,
     *     embed: array,
     *     dataCenter: ZohoDataCenter,
     *     markAsRead: bool
     * } $cliq
     */
    public function __construct(private readonly object $cliq) {}

    /**
     * @throws CliqAlertException
     * @throws ConnectionException
     */
    public function handle(): void
    {
        $dataCenterOauthUrl = $this->cliq->dataCenter->getOauthBaseUrl();
        $dataCenterBaseUrl = $this->cliq->dataCenter->getBaseUrl();
        $endpoint = "{$dataCenterBaseUrl}/api/v2/channelsbyname/{$this->cliq->channel}/message";
        if (! $this->cliq->bot) {
            $endpoint .= "?bot_unique_name={$this->cliq->bot}";
        }

        $payload = ['text' => $this->cliq->message];
        if (! empty($this->cliq->embed)) {
            $payload = array_merge($payload, $this->cliq->embed);
        }

        Http::withToken($this->getAccessToken($dataCenterOauthUrl))
            ->post($endpoint, $payload);
    }
}
