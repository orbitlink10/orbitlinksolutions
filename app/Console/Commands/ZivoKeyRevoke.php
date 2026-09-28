<?php

namespace App\Console\Commands;

use App\Models\ZivoApiKey;
use Illuminate\Console\Command;

class ZivoKeyRevoke extends Command
{
    protected $signature = 'zivo:key-revoke {id}';

    protected $description = 'Immediately revoke a Zivo read key';

    public function handle(): int
    {
        $key = ZivoApiKey::where('store_id', config('zivo.store_id'))->find($this->argument('id'));
        if (! $key) {
            $this->error('Key not found for this store.');

            return self::FAILURE;
        }
        $key->update(['revoked_at' => now()]);
        $this->info('Key revoked.');

        return self::SUCCESS;
    }
}
