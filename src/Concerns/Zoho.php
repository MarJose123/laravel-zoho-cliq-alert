<?php

namespace MarJose123\ZohoCliqAlert\Concerns;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use MarJose123\ZohoCliqAlert\Exceptions\CliqAlertException;

trait Zoho
{
    /**
     * The access token for authenticating API requests with Zoho Cliq.
     */
    protected ?string $accessToken = null;

    /**
     * The authorization URL for Zoho
     */
    protected string $zohoOauthBaseUrl = 'https://accounts.zoho.com';

    /**
     * Sets the access token for authenticating API requests.
     *
     * @param  string  $accessToken  The access token to be set.
     */
    public function setAccessToken(string $accessToken): void
    {
        cache()->remember('zohoAccessToken', now()->addMinutes(50), function () use ($accessToken) {
            return $this->accessToken = $accessToken;
        });
    }

    /**
     * Gets the access token, fetching a new one if not already set.
     *
     * @param  string  $zohoOauthBaseUrl  Base URL for the account Oauth datacenter
     * @return string The access token.
     *
     * @throws CliqAlertException If there's an error obtaining the access token.
     */
    public function getAccessToken(string $zohoOauthBaseUrl): string
    {
        $this->zohoOauthBaseUrl ??= $zohoOauthBaseUrl;

        $this->accessToken = cache('zohoAccessToken');
        if (! $this->accessToken) {
            $this->setAccessToken($this->fetchAccessToken($zohoOauthBaseUrl));
        }

        return $this->accessToken;
    }

    /**
     * Fetches a new access token from Zoho Cliq.
     *
     * @param  string  $zohoOauthBaseUrl  Base URL for the account Oauth datacenter
     * @return string The fetched access token.
     *
     * @throws CliqAlertException If there's an error obtaining the access token.
     */
    protected function fetchAccessToken(string $zohoOauthBaseUrl): string
    {

        try {
            $response = Http::asForm()->post($zohoOauthBaseUrl.'/oauth/v2/token', [
                'client_id' => config('cliq.client_id'),
                'client_secret' => config('cliq.client_secret'),
                'grant_type' => 'client_credentials',
                'scope' => 'ZohoCliq.Webhooks.CREATE',
            ]);

            $data = $response->json();

            if (isset($data['error'])) {
                throw new CliqAlertException('Error obtaining access token: '.$data['error']);
            }

            return $data['access_token'];
        } catch (ConnectionException $exception) {
            throw new CliqAlertException($exception->getMessage());
        }
    }
}
