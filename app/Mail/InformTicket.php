<?php

    namespace App\Mail;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;


    class InformTicket extends Mailable{

        use Queueable , SerializesModels;
        public $name;
        public $creator;
        public $ticket_number;
        public $ticket_subject;

        public function __construct($name, $creator, $ticket_number, $ticket_subject) {
            $this->name = $name;
            $this->creator = $creator;
            $this->ticket_number = $ticket_number;
            $this->ticket_subject = $ticket_subject;
            
        }

        public function build(){
            return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Biro ICT - Helpdesk')->view('mail.inform_ticket');
        }
    }


?>