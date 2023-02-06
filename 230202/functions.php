<?php
function getKlantGeg($id)
{
    global $pdo;

    $sql = 'SELECT * FROM `watergroep_klanten` WHERE id = :id;';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function insertMeterstand($id, $meterstand)
{
    global $pdo;

    $sql = "INSERT INTO `watergroep_inzendingen` (`id`, `watergroep_klanten_id`, `meterstand`, `created_at`, `updated_at`)
VALUES (NULL, :id, :meterstand, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'meterstand' => $meterstand]);
}

function countInzendingen($id)
{
    global $pdo;

    $sql = "SELECT count(`id`) as count FROM `watergroep_inzendingen` WHERE `watergroep_klanten_id` = :id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch()->count;
}

function getLatests($id)
{
    global $pdo;

    $sql = "SELECT `id`,`meterstand`,`created_at`,`updated_at` FROM `watergroep_inzendingen` WHERE `watergroep_klanten_id` = :id ORDER BY id DESC;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll();
}

function getId($token)
{
    global $pdo;

    $sql = "SELECT id FROM `watergroep_klanten` WHERE token = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->execute((['token' => $token]));
    $response = $stmt->fetch();
    return $response ? $response->id : "";
}

function updateToken($id, $newToken)
{
    global $pdo;

    $sql = "UPDATE `watergroep_klanten` SET `token` = :token WHERE `watergroep_klanten`.`id` = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'token' => $newToken]);
}

function getTime($time)
{
    $time_difference = time() - $time;

    if ($time_difference < 1) {
        return 'minder dan 1 seconde geleden';
    }
    $condition = array(
        12 * 30 * 24 * 60 * 60 =>  'jaar',
        30 * 24 * 60 * 60       =>  'maand',
        24 * 60 * 60            =>  'dag',
        60 * 60                 =>  'uur',
        60                      =>  'minuut',
        1                       =>  'second'
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return  $t . ' ' . $str . ($t > 1 ? 'en' : '');
        }
    }
}

function randomToken($tokenLen)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $tokenArr = [];
    $count = strlen($chars) - 1;
    for ($i = 0; $i < $tokenLen; $i++) {
        $n = rand(0, $count);
        $tokenArr[] = $chars[$n];
    }
    return implode($tokenArr);
}

function isKnownToken($token_to_check)
{
    global $pdo;

    $sql = "SELECT count(token) as count FROM `watergroep_klanten` WHERE token = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["token" => $token_to_check]);
    $count = $stmt->fetch()->count;
    return $count > 0;
}
