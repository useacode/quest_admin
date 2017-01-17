<?php
	include "classes/mobiledetect.class.php";
	include "data/config.php";
	include "classes/mysql.class.php";

	class App{

		var $busy = array();

		function __construct(){
			DataBase::setParams(Config::$dbparams);

			$sql = new SqlQuery("SELECT DATE_FORMAT( `date`, '%Y-%m-%d %H:%i') as d FROM  `data` where type = 'close'");
			while($sql->next()){
				$this->busy[]= $sql->d;						
			}
		}

		static $months = array(
        	"ЯНВАРЯ", "ФЕВРАЛЯ", "МАРТА", "АПРЕЛЯ", "МАЯ", "ИЮНЯ", "ИЮЛЯ", "АВГУСТА", "СЕНТЯБРЯ", "ОКТЯБРЯ", "НОЯБРЯ", "ДЕКАБРЯ"
        );

        static  $weakDays = array(
        	"понедельник", "вторник", "среда", "четверг", "пятница", "суббота", "воскресенье"
        );

		function getDay($i, $offset = 0){
			$offset *= 7;
			$weakDay = (int)date("N");
            $day = time() - 60 * 60 * 24 * $weakDay;
            return date("j", $day + 60 * 60 * 24 * ($i + $offset));
		}
		 
		function getMonth($i, $offset = 0){
			$offset *= 7;
			$weakDay = (int)date("N");
            $day = time() - 60 * 60 * 24 * $weakDay;
            return self::$months[date("n", $day + 60 * 60 * 24 * ($i + $offset)) - 1];
		}

		function getFullDayByDate($i){
			
			$weakDay = self::$weakDays[(int)date("N", time() + 60 * 60 * 24 * $i) - 1];
			$day = date("j", time() + 60 * 60 * 24 * $i);
			$month = self::$months[date("n", time() + 60 * 60 * 24 * ($i + $offset)) - 1];

			return $weakDay . ", " . $day . " " . $month; 
		}

		function getFullDateByDate($i){			
			return date("Y-m-j", time() + 60 * 60 * 24 * $i);
		}

		function getWeekDay($i, $offset = 0){
			$offset *= 7;
			$weakDay = (int)date("N");
            $day = time() - 60 * 60 * 24 * $weakDay;
			return self::$weakDays[date("N", $day + 60 * 60 * 24 * ($i + $offset)) - 1];
		}

		function fullDate($i, $offset = 0){
			$offset *= 7;
			$weakDay = (int)date("N");
            $day = time() - 60 * 60 * 24 * $weakDay;
			return date("Y-m-d", $day + 60 * 60 * 24 * ($i + $offset));
		}

		function isDisabled($i, $time = '00:00', $offset = 0){
			$offset *= 7;
			$weakDay = (int)date("N");
            //if ($i < $weakDay) return true;
			$day = time() - 60 * 60 * 24 * $weakDay;
			
			if (in_array(date("Y-m-d $time", $day + 60 * 60 * 24 * ($i + $offset)), $this->busy))
				return true;

			$sql = new SqlQuery("SELECT DATE_FORMAT( NOW(), '%Y-%m-%d %H:%i') > '" . date("Y-m-d $time", $day + 60 * 60 * 24 * ($i + $offset)). "' as d", true);
			if($sql->d == "1")
				return true;
			return false;
		}

		function isMobile(){
			
			$md = new Mobile_Detect();
			return $md->isMobile();
		}
                           
	}