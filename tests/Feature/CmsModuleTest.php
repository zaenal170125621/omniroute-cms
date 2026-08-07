<?php

namespace Tests\Feature;

use App\Mail\NewsletterConfirmation;
use App\Models\Faq;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CmsModuleTest extends TestCase
{
    public function test_public_faq_page_renders_faqs_from_database(): void
    {
        $firstFaq = Faq::orderBy('sort_order')->firstOrFail();

        $this->get('/faq')
            ->assertOk()
            ->assertSee($firstFaq->question);
    }

    public function test_order_and_pricing_pages_render_packages(): void
    {
        // Kedua halaman memakai satu sumber OrderController::PACKAGES.
        $this->get('/order')->assertOk()->assertSee('Starter')->assertSee('Business');
        $this->get('/pricing')->assertOk()->assertSee('Rp 3.500.000')->assertSee('Custom');
    }

    public function test_newsletter_subscribe_sends_confirmation_and_double_optin(): void
    {
        // Honeypot terisi (bot) → sukses palsu, tidak ada baris tersimpan.
        $this->post('/newsletter/subscribe', ['email' => 'bot@example.com', 'company_site' => 'http://spam'])
            ->assertOk()
            ->assertJson(['success' => true]);
        $this->assertDatabaseMissing('newsletter_subscribers', ['email' => 'bot@example.com']);

        Mail::fake();

        // Normal → terdaftar sebagai unconfirmed + email konfirmasi terkirim.
        $email = 'test-' . time() . '@example.com';
        $this->post('/newsletter/subscribe', ['email' => $email])
            ->assertOk()
            ->assertJson(['success' => true]);
        $this->assertDatabaseHas('newsletter_subscribers', ['email' => $email, 'confirmed' => false]);
        Mail::assertSent(NewsletterConfirmation::class, fn ($mail) => $mail->hasTo($email));

        $subscriber = NewsletterSubscriber::where('email', $email)->firstOrFail();

        // Email ter-render memuat link konfirmasi dengan token asli.
        $this->assertStringContainsString(
            route('newsletter.confirm', $subscriber->confirmation_token),
            view('emails.newsletter-confirmation', ['subscriber' => $subscriber])->render()
        );

        // Klik link di email → langganan aktif.
        $this->get(route('newsletter.confirm', $subscriber->confirmation_token))
            ->assertRedirect(route('home'));
        $this->assertDatabaseHas('newsletter_subscribers', ['email' => $email, 'confirmed' => true]);

        NewsletterSubscriber::where('email', $email)->delete(); // bersihkan baris test
    }

    public function test_filament_panel_renders_for_admin(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)
            ->get('/panel')
            ->assertOk()
            ->assertSee('Dasbor');

        // Resource konten ter-render (data asli dari DB).
        $this->actingAs($admin)
            ->get('/panel/faqs')
            ->assertOk();
        $this->actingAs($admin)
            ->get('/panel/leads')
            ->assertOk();
        $this->actingAs($admin)
            ->get('/panel/newsletter-subscribers')
            ->assertOk();
    }

    public function test_export_leads_csv_as_admin(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)
            ->get('/panel/leads/export')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }
}
