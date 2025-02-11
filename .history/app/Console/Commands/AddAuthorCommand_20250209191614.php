<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


class AddAuthorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-author-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding a new author...');

        // Get user input from CLI
        $firstName = $this->ask('Enter First Name');
        $lastName = $this->ask('Enter Last Name');
        $birthday = $this->ask('Enter Birthday (YYYY-MM-DD)');
        $biography = $this->ask('Enter Biography');
        $gender = $this->choice('Select Gender', ['male', 'female'], 0);
        $placeOfBirth = $this->ask('Enter Place of Birth');

        // Validate inputs
        if (!$firstName || !$lastName || !$birthday || !$biography || !$gender || !$placeOfBirth) {
            $this->error('All fields are required.');
            return;
        }

        // Fetch access token from session or config
        $token = $this->getRoyalAppsToken();


        // Prepare API request
        $response = Http::withToken($token)->post('https://candidate-testing.api.royal-apps.io/api/v2/authors', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'birthday' => $birthday,
            'biography' => $biography,
            'gender' => $gender,
            'place_of_birth' => $placeOfBirth,
        ]);

        // Handle response
        if ($response->successful()) {
            $this->info('Author added successfully!');
        } else {
            $this->error('Failed to add author: ' . $response->body());
        }
    }

    function getRoyalAppsToken()
    {
        $token = config('services.royal_apps.token');

        if (!$token) {
            // Check if a cached token exists
            if (Cache::has('royal_apps_token')) {
                return Cache::get('royal_apps_token');
            }

            // Get token from API
            $response = Http::post('https://candidate-testing.api.royal-apps.io/api/v2/auth/login', [
                'email' => 'ahsoka.tano@royal-apps.io',
                'password' => 'Kryze4President',
            ]);

            if ($response->successful()) {
                $token = $response->json('access_token');

                // Cache the token for 60 minutes
                Cache::put('royal_apps_token', $token, now()->addMinutes(60));

                return $token;
            }

            throw new \Exception('Failed to retrieve API token');
        }

        return $token;
    }
}
