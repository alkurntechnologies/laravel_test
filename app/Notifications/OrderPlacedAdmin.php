<?php

namespace App\Notifications;

use http\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrderPlacedAdmin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $mail =  (new MailMessage)
            ->greeting('Hello, Admin')
            ->subject(config('app.name').' - New Order Placed')
            ->line('New Order Placed by '.$this->order->user->name.' on '. config('app.name'))
            ->line('Below are the order details:');
            $i = 1;
            $mail->line('Order No.'. $this->order->order_number);
            foreach($this->order->products as $key => $product)
            {
                if($product->product){
                    $name = $product->product->name ;
                    $price = $product->product->price ;
                }
                $mail->line('Product #'.$i);
                $mail->line('Name: ' .$name);
                $mail->line('Price: $' .$price);
                $mail->line('Quantity: ' .$product->quantity);
                $mail->line('total: $' .$product->item_total);
                $i++;
            }
           
            $mail->line('Thank you for choosing Demo!');

        return $mail;
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
            'title' => 'New order placed',
            "type" => 'admin',
            "link" => url('/admin/manage-order-management'),
            'msg' => 'New Order Placed by '.$this->order->user->name.' on '. config('app.name')
        ];
    }
}