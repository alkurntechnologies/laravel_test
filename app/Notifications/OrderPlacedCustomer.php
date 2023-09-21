<?php

namespace App\Notifications;

use http\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrderPlacedCustomer extends Notification
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
            ->greeting('Hello ' . ucfirst($this->order->user->name).',')
            ->subject(config('app.name').' - Order Placed Successfully')
           ->line('Your order is successfully placed on '. config('app.name'))
           ->line('Below are your order details:');
           $i = 1;
           $mail->line('Order No.'. $this->order->order_number);
           foreach($this->order->products as $key => $product)
           {
            if($product->product){
                $name = $product->product->name ;
            }
            $mail->line('Product #'.$i);
            $mail->line('Name: ' .$name);
            $mail->line('Price: $' .$product->price);
            $mail->line('Quantity: ' .$product->quantity);
            $mail->line('total: $' .$product->item_total);
            $i++;
           }
            

            $mail->line('Thank you for your order and for choosing E-Railspot!');

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
            'title' => 'Your order is succesfully placed',
            "type" => 'front-user',
            "link" => url('/orders'),
            'msg' => "Your order (".$this->order->order_number.") is succesfully placed"." ".config('app.name')
        ];
    }
}
