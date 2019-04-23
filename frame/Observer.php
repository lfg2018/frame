<?php

/**
 * 观察者接口类
 * Interface TicketObserver
 */

interface TicketObserver{
	function buyTicketOver($sender,$args = null);
}

/**
 * 事件产生类
 * Class TicketObserved
 */
abstract class  TicketObserved{
	private $observers = array();
	public function addObserver($observer){
		$this->observers[] = $observer;
	}
	public function notify($ticket){
		foreach($this->observers as $observe){
			$observe->buyTicketOver($observe,$ticket);
		}
	}
}

/**
 * 购票主体方事件
 * Class BuyTicket
 */
class BuyTicket extends TicketObserved{
    // 触发事件
	public function trigger($ticket){
		$this->notify($ticket);
	}
}

/**
 * 观察者1
* 购票成功后，发送短信通知
* Class buyTicketMSN
 */

class buyTicketMSN implements TicketObserver{
	public function buyTicketOver($sender,$ticket = null){
		echo (date('Y-m-d H:i:s').'短信日志记录：购票成功：'.$ticket."\r\n");
	}
}

/**
 * 观察者2
 * 购票成功后，记录日志
 * Class buyTicketCoupon
 */
class buyTicketCoupon implements TicketObserver{
	public function buyTicketOver($sender,$ticket = null){
		echo date('Y-m-d H:i:s').'优惠劵赠送成功'.$ticket."\r\n";
	}
}

//创建一个事件
$buyObj = new BuyTicket();
//为事件增加旁观者
$buyObj->addObserver(new buyTicketMSN());
$buyObj->addObserver(new buyTicketCoupon());
//执行事件 通知旁观者
$buyObj->trigger('7排8号');
