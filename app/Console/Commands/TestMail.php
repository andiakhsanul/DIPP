<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email=test@example.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test email to verify mail configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('Sending test email to: ' . $email);
        $this->info('Using mailer: ' . config('mail.default'));
        $this->info('SMTP Host: ' . config('mail.mailers.smtp.host'));
        $this->newLine();

        try {
            Mail::raw('This is a test email from DIPP Application. If you receive this, your mail configuration is working correctly!', function($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email from DIPP - ' . now()->format('Y-m-d H:i:s'));
            });

            $this->newLine();
            $this->components->success('✅ Test email sent successfully!');
            $this->info('Check your Mailtrap inbox at: https://mailtrap.io/inboxes');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->newLine();
            $this->components->error('❌ Failed to send test email!');
            $this->error('Error: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
}
