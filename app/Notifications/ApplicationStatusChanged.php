<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Application $application,
        public string $oldStatus,
        public string $newStatus
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->mailer('noreply')
            ->from(config('mail.from.noreply.address', env('MAIL_FROM_NOREPLY', 'noreply@careerx.com')), config('mail.from.noreply.name', 'CareerX'))
            ->subject('Application Status Update - ' . $this->application->jobPosting->title)
            ->markdown('emails.application-status-changed', [
                'studentName' => $notifiable->name,
                'jobTitle' => $this->application->jobPosting->title,
                'companyName' => $this->application->jobPosting->company->name,
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->newStatus,
                'application' => $this->application,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'job_title' => $this->application->jobPosting->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
        ];
    }
}
