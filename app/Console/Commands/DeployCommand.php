<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DeployCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy {--force : Force deployment without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the application using Envoy';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting deployment...');

        // Ask for confirmation unless --force is used
        if (!$this->option('force') && !$this->confirm('Are you sure you want to deploy?')) {
            $this->warn('Deployment cancelled.');
            return 1;
        }

        // Check if Envoy is installed
        $envoyPath = base_path('vendor/bin/envoy');
        if (!file_exists($envoyPath)) {
            $this->error('Envoy is not installed. Please run: composer require laravel/envoy');
            return 1;
        }

        // Run the Envoy deployment
        $this->info('Executing Envoy deployment script...');
        
        $process = new Process([
            $envoyPath,
            'run',
            'deploy',
            '--path=' . base_path()
        ]);

        $process->setTimeout(600); // 10 minutes timeout
        $process->setIdleTimeout(60); // 1 minute idle timeout

        try {
            $process->mustRun(function ($type, $buffer) {
                // Output the process buffer in real time
                $this->line($buffer);
            });

            $this->info('✅ Deployment completed successfully!');
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Deployment failed: ' . $e->getMessage());
            return 1;
        }
    }
}
