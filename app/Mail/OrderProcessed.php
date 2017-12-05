<?php

    namespace App\Mail;

    use App\Order;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class OrderProcessed extends Mailable
    {
        use Queueable, SerializesModels;

        protected $order;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct(Order $order)
        {
            $this->order = $order;
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            $this->subject("Your order with Club JB");
            $view = $this->markdown('emails.orders.processed', ['order' => $this->order]);

            return $view;
        }
    }
