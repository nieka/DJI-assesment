<?php

namespace App\Services;

use App\Models\Colleague;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ColleagueApiHandler
{
    /**
     * @return Collection
     */
    public function getColleagues(): Collection
    {
        $response = Http::get("https://pastebin.com/raw/uDzdKzGG");

        if (!$response->successful()) {
            //todo improve error logging so we know what went wrong
            Log::error('Failed to fetch colleagues');

            return collect([]);
        }

        $colleagues = collect([]);

        foreach($response->json() as $jsonColleague) {
            $colleagues->push(new Colleague ($jsonColleague));
        }

        return $colleagues;
    }

    /**
     * @param string $email
     * @return Colleague|null
     */
    public function getColleague(string $email): ?Colleague
    {
        return $this->getColleagues()
            ->where('email', $email)
            ->first();
    }
}
