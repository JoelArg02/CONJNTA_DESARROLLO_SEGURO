<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Mail\InvoiceCreated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestInvoiceEmail extends Command
{
    protected $signature = 'test:invoice-email {invoice_id} {email}';
    protected $description = 'Test sending invoice email to a specific email address';

    public function handle()
    {
        $invoiceId = $this->argument('invoice_id');
        $email = $this->argument('email');

        try {
            $invoice = Invoice::with(['customer', 'items.product', 'creator'])->findOrFail($invoiceId);
            
            $this->info("Sending invoice {$invoice->invoice_number} to {$email}...");
            
            Mail::to($email)->send(new InvoiceCreated($invoice));
            
            $this->info("✅ Email sent successfully!");
            
        } catch (\Exception $e) {
            $this->error("❌ Error sending email: " . $e->getMessage());
        }
    }
}
