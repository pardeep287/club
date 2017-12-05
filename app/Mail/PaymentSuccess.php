<?php

    namespace App\Mail;

    use App\CCTransaction;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class PaymentSuccess extends Mailable
    {
        use Queueable, SerializesModels;

        protected $transaction;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct(CCTransaction $ccTransaction)
        {
            $this->transaction = $ccTransaction;
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            $this->subject("Payment for Order #{$this->transaction->id} with Club JB");
            $view = $this->markdown('emails.payments.success', ['transaction' => $this->transaction]);

            return $view;
        }
    }
