<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class addNewBuyer extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user;
    public $password;

    public function __construct($user,$password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->greeting('Hello, ' . ucfirst($this->user->first_name) . ' ' . ucfirst($this->user->last_name))
            ->subject(config('app.name').' - Account Created')
            ->line('Thank you for signing up to our DEMO platform. You are receiving this email because you or someone within your organization wants to begin using your Free account. You will now receive Requests for Quotations to this inbox, which will allow you to bid on requests posted by Buyers seeking goods or services through our on-line procurement tool. You will receive an email notification anytime there is an RFQ for goods and/or services that match your company’s portfolio.')
            ->line('You will also have access to list products for sale, create requests for shipping to hundreds of brokers, and add your products to our on-line catalog for the industry to see. All of this is Free to you!')
            ->line('Feel free to familiarize yourself with your dashboard, and feel free to reach out if you have any questions! Welcome to the DEMO community.')
            ->action('Login', url('login'))
            ->line('Email: '.$this->user->email)
            ->line('Password: '.$this->password)
            ->line('Thank you for choosing DEMO!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            
        ];
    }
}
