<?php

    namespace App\Mail;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;


    class CreateTicket extends Mailable{

        use Queueable , SerializesModels;
        public $name;
        public $ticket_number;
        public $ticket_subject;

        public function __construct($name, $ticket_number, $ticket_subject) {
            $this->name = $name;
            $this->ticket_number = $ticket_number;
            $this->ticket_subject = $ticket_subject;
            
        }

        public function build(){
            return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Biro ICT - Helpdesk')->view('mail.create_ticket');
        }
    }


?>