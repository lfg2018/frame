<?php

interface TicketObserver{
	function buyTicketOver($args = null);
}

abstract class  TicketObserved{
	private $observers = array();
	public function addObserver(TicketObserver $observer){
		$this->observers[] = $oberver;
	}
	public function notify($ticket){
		foreach($this->observers as $observe){
			$observe->buyTicketOver();		
		}
	}
}

class BuyTicket extends TicketObserved{
	public function trigger($ticket){
		$this->notify($ticket);
	}
}

class buyTicketMSN implements TicketObserver{
	public function buyTicketOver($ticket = null){
		echo (data('Y-m-d H:i:s').'短信日志记录：购票成功：'.$ticket.'\r\n');
	}
}

class buyTicketCoupon implements TicketObserver{
	public function buyTicketOver($ticket = null){
		echo data('Y-m-d H:i:s').'优惠劵赠送成功'.$ticket.'\r\n';
	}
}

$buyObj = new BuyTicket();

$buyObj->addObserver(new buyTicketMSN());
$buyObj->addObserver(new buyTicketCoupon());

$buyObj->trigger('7排8号');
