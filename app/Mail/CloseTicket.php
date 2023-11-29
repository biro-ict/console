<?php

    namespace App\Mail;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;


    class CloseTicket extends Mailable{

        use Queueable , SerializesModels;
        public $name;
        public $ticket_number;
        public $technician;
        public $notes;

        public function __construct($name, $ticket_number, $technician, $notes) {
            $this->name = $name;
            $this->ticket_number = $ticket_number;
            $this->technician = $technician;
            $this->notes = $notes;
            
        }

        public function build(){
            return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Biro ICT - Helpdesk')->view('mail.close_ticket');
        }
    }


?>