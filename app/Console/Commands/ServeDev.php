<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:dev {--host=127.0.0.1} {--port=8000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Laravel development server with development environment (SQLite)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');
        
        $this->info('Starting development server with SQLite database...');
        $this->info("Server: http://{$host}:{$port}");
        $this->info('Environment: local (using .env.development)');
        $this->info('Database: SQLite');
        $this->newLine();
        $this->comment('Press Ctrl+C to stop the server');
        $this->newLine();

        // Copy .env.development to .env temporarily
        $envPath = base_path('.env');
        $envDevPath = base_path('.env.development');
        $envBackupPath = base_path('.env.production.backup');

        // Backup current .env (production) to .env.production.backup
        if (file_exists($envPath)) {
            copy($envPath, $envBackupPath);
        }

        // Copy .env.development to .env
        if (file_exists($envDevPath)) {
            copy($envDevPath, $envPath);
            $this->info('✓ Loaded development environment');
        } else {
            $this->error('.env.development file not found!');
            return 1;
        }

        // Clear config cache to ensure new env is loaded
        $this->call('config:clear');
        $this->call('cache:clear');

        // Start the server
        $process = new Process([
            PHP_BINARY,
            'artisan',
            'serve',
            "--host={$host}",
            "--port={$port}"
        ], base_path());

        $process->setTimeout(null);

        try {
            $process->run(function ($type, $buffer) {
                echo $buffer;
            });
        } finally {
            // Restore production .env
            if (file_exists($envBackupPath)) {
                copy($envBackupPath, $envPath);
                unlink($envBackupPath);
                $this->newLine();
                $this->info('✓ Restored production environment');
            }
        }

        return 0;
    }
}
