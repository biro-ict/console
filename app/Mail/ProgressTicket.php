<?php

    namespace App\Mail;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;


    class ProgressTicket extends Mailable{

        use Queueable , SerializesModels;
        public $name;
        public $ticket_number;
        public $technician;

        public function __construct($name, $ticket_number, $technician) {
            $this->name = $name;
            $this->ticket_number = $ticket_number;
            $this->technician = $technician;
            
        }

        public function build(){
            return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Biro ICT - Helpdesk')->view('mail.progress_ticket');
        }
    }


?>