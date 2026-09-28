<?php

namespace App\Models\Concerns;

trait ZivoTransactionalWrites
{
    // Commit catalogue writes and their outbox events together. No network I/O here.
    public function save(array $options = [])
    {
        return config('zivo.webhooks.enabled')
            ? $this->getConnection()->transaction(fn () => parent::save($options))
            : parent::save($options);
    }

    public function delete()
    {
        return config('zivo.webhooks.enabled')
            ? $this->getConnection()->transaction(fn () => parent::delete())
            : parent::delete();
    }
}
