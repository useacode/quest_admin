<?php
include __DIR__ . "/../data/config.php";
include __DIR__ . "/../classes/mysql.class.php";

DataBase::setParams(Config::$dbparams);

$matches = array();
if (preg_match('|/admin/api/getdata/(\d+)|', $_SERVER['REQUEST_URI'], $matches)) {
    $weekDays = array(
        "воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", "суббота"
    );

    $months = array(
        "ЯНВАРЯ", "ФЕВРАЛЯ", "МАРТА", "АПРЕЛЯ", "МАЯ", "ИЮНЯ", "ИЮЛЯ", "АВГУСТА", "СЕНТЯБРЯ", "ОКТЯБРЯ", "НОЯБРЯ", "ДЕКАБРЯ"
    );

    $pagenumber = (int) $matches[1];

    $beginDate = new DateTime('now', new DateTimeZone('Europe/Moscow'));
    $beginDate->setTime(0, 0, 0);
    $beginDate->add(new DateInterval('P' . ($pagenumber * 7) . 'D'));

    $endDate = new DateTime('now', new DateTimeZone('Europe/Moscow'));
    $endDate->setTime(23, 59, 59);
    $endDate->add(new DateInterval('P' . ($pagenumber * 7 + 6) . 'D'));

    $orders = new SqlQuery("SELECT * FROM data WHERE `date` >= ? AND `date` <= ?");
    $orders->build($beginDate->format("Y-m-d H:i:s"), $endDate->format("Y-m-d H:i:s"));
    $foundOrders = array();
    while ($row = $orders->next()) {
        if(isset($foundOrders[$row['date']]))
            $foundOrders[$row['date']] = "multi";
        else
            $foundOrders[$row['date']] = $row['type'];
    }

    $times = array('00:00', '01:15', '02:30', '10:15', '11:30', '12:45', '14:00', '15:15', '16:30', '17:45', '19:00', '20:15', '21:30', '22:45');

    $date = $beginDate;
    $result = [];
    for ($i = 0; $i <= 6; $i++) {
        $dateRow = [
            'weekDay' => $weekDays[(int) $date->format("w")],
            'date' => $date->format("j") . ' ' . $months[(int) $date->format("n")],
            'times' => []
        ];
        foreach ($times as $time) {
            $dateTime = $date->format("Y-m-d") . ' ' . $time;
            $dbDateTime = $date->format("Y-m-d") . ' ' . $time . ':00';
            $timeRow = [
                'time' => $time,
                'fullTime' => $dateTime,
                'status' => isset($foundOrders[$dbDateTime]) ? $foundOrders[$dbDateTime] : null,
            ];
            $dateRow['times'][] = $timeRow;
        }
        $result[] = $dateRow;
        $date->add(new DateInterval('P1D'));
    }
    header('Content-Type: application/json');
    echo json_encode($result);
} elseif (preg_match('|/admin/api/get/([0-9a-z%-]+)|i', $_SERVER['REQUEST_URI'], $matches)) {
    $date = urldecode($matches[1]);
    $query = new SqlQuery("SELECT * FROM data WHERE `date` = ?");
    $query->build($date);
    
    $foundOrders = [];

    while ($row = $query->next()) {
        $foundOrders[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'status' => $row['type'],
            'orderTime' => date_create($row['order_time'])->format("Y-m-d H:i"),
            'date' => date_create($row['date'])->format("Y-m-d H:i")
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($foundOrders);
} elseif (preg_match('|/admin/api/getnew|i', $_SERVER['REQUEST_URI'], $matches)) {
    $query = new SqlQuery("SELECT * FROM data WHERE type = 'wait'");
    $query->build($date);

    $foundOrders = [];

    while($row = $query->next()){
        $foundOrders[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'status' => $row['type'],
            'orderTime' => date_create($row['order_time'])->format("Y-m-d H:i"),
            'date' => date_create($row['date'])->format("Y-m-d H:i")
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($foundOrders);
} elseif (preg_match('|/admin/api/remove/(\d+)|i', $_SERVER['REQUEST_URI'], $matches)) {
    $id = $matches[1];
    $query = new SqlAction("DELETE FROM data WHERE id = ?");
    $query->exec($id);

    header('Content-Type: application/json');
    echo json_encode(array("result" => "ok"));
} elseif (preg_match('|/admin/api/accept/(\d+)|i', $_SERVER['REQUEST_URI'], $matches)) {
    $id = $matches[1];
    $query = new SqlAction("UPDATE data SET type = 'close' WHERE id = ?");
    $query->exec($id);

    header('Content-Type: application/json');
    echo json_encode(array("result" => "ok"));
} elseif (preg_match('|/admin/api/addnew|i', $_SERVER['REQUEST_URI'], $matches)) {
    $params = file_get_contents("php://input");
    $params = json_decode($params);

    $query = new SqlAction("INSERT INTO data (name, phone, `date`, type) VALUES (?, ?, ?, ?)");
    $query->exec($params->data->name, $params->data->phone, $params->data->time, $params->data->status);

    header('Content-Type: application/json');
    echo json_encode(array("result" => "ok"));
} elseif (preg_match('|/admin/api/settime|i', $_SERVER['REQUEST_URI'], $matches)) {
    $params = file_get_contents("php://input");
    $params = json_decode($params);

    $query = new SqlAction("UPDATE data SET `date` = ? WHERE id = ?");
    $query->exec($params->time, $params->id);

    header('Content-Type: application/json');
    echo json_encode(array("result" => "ok"));
}else {
    http_response_code(404);
}