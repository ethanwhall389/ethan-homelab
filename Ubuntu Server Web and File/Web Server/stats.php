<?php
header('Content-Type: application/json; charset=utf-8');

//Get CPU usage
function getCpuUsage() {
        $load = sys_getLoadavg();
        return round($load[0] * 100 / 4, 1);
};

function getMemoryUsage() {
    $free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);

    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);

    $memory_usage = round($mem[2]/$mem[1]*100, 1);
    $memory_used_gb = round($mem[2]/1024/1024, 2);
    $memory_total_gb = round($mem[1]/1024/1024, 2);

    return array(
        'percent' => $memory_usage,
        'used' => $memory_used_gb,
        'total' => $memory_total_gb
    );
}

function getDiskUsage() {
    $disk_total = disk_total_space('/');
    $disk_free = disk_free_space('/');
    $disk_used = $disk_total - $disk_free;
    $disk_usage = round($disk_used / $disk_total * 100, 1);
    $disk_used_gb = round($disk_used / 1024 / 1024 / 1024, 2);
    $disk_total_gb = round($disk_total / 1024 / 1024 / 1024, 2);

    return array(
        'percent' => $disk_usage,
        'used' => $disk_used_gb,
        'total' => $disk_total_gb
    );
}

function getUptime() {
    $uptime = shell_exec('uptime -p');
    return trim(str_replace('up ', '', $uptime));
}

function getServerHostname() {
    return gethostname();
};


//collect all stats

$stats = [
    'cpu' => getCpuUsage(),
    'memory' => getMemoryUsage(),
    'disk' => getDiskUsage(),
    'uptime' => getUptime(),
    'hostname' => getServerHostname(),
    'timestamp' => date('Y-m-d H:i:s')
];

//return json
echo json_encode($stats);
?>