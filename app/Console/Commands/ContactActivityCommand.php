<?php

namespace App\Console\Commands;

use App\Models\ContactMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ContactActivityCommand extends Command
{
    protected $signature = 'contact:activity {--limit=20 : Number of recent submissions to show}';

    protected $description = 'Show recent contact form submissions and log activity';

    public function handle(): int
    {
        $limit = (int) $this->option('limit');

        $this->components->info('Recent submissions (database)');

        $messages = ContactMessage::query()
            ->latest()
            ->limit($limit)
            ->get(['id', 'created_at', 'name', 'email', 'ip_address', 'device_type', 'browser', 'platform']);

        if ($messages->isEmpty()) {
            $this->line('  No submissions found.');
        } else {
            $this->table(
                ['ID', 'Time (UTC)', 'Name', 'Email', 'IP', 'Device'],
                $messages->map(fn (ContactMessage $message) => [
                    $message->id,
                    $message->created_at,
                    $message->name,
                    $message->email,
                    $message->ip_address ?? '—',
                    collect([$message->device_type, $message->browser, $message->platform])->filter()->implode(' / ') ?: '—',
                ]),
            );
        }

        $this->newLine();
        $this->components->info('Recent log entries');

        $logFile = collect(File::glob(storage_path('logs/contact-*.log')))
            ->sort()
            ->last();

        if (! $logFile || ! File::exists($logFile)) {
            $this->line('  No contact log file yet.');

            return self::SUCCESS;
        }

        $lines = collect(file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))
            ->take(-$limit)
            ->values();

        if ($lines->isEmpty()) {
            $this->line('  Log file is empty.');
        } else {
            foreach ($lines as $line) {
                $this->line('  '.$line);
            }
        }

        $this->newLine();
        $this->line("Log file: {$logFile}");
        $this->line('Watch live: php artisan pail --filter=contact');

        return self::SUCCESS;
    }
}
