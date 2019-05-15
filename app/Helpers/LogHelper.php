<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/15
 * Time: 11:35
 */

namespace App\Helps;

use Illuminate\Support\Facades\Log;

class LogHelper
{
    /**
     * 支持 8种日志级别emergency、alert、critical、error、warning、 notice、info 和 debug
     * @param string $data
     * @param $logLevel
     * @param int $days  表示最大保留几个文件，也即几天文件，设置为0 则不删除文件
     * @param string $path  文件路径
     * @param string $logName  文件名
     */
    public static function writeLocalLog($data = '', $logLevel, $days = 60, $path = '', $logName = '')
    {
        $path    = $path ?: storage_path() . '/logs/';
        $logName = $logName ?: 'single-log.log';
        $monolog = Log::getMonolog();
        $monolog->popHandler();
        Log::useDailyFiles($path . '/' . $logName, $days);
        switch ($logLevel) {
            case 'emergency':
                Log::emergency($data);
                break;
            case 'alert':
                Log::alert($data);
                break;
            case 'critical':
                Log::critical($data);
                break;
            case 'error':
                Log::error($data);
                break;
            case 'warning':
                Log::warning($data);
                break;
            case 'notice':
                Log::notice($data);
                break;
            case 'info':
                Log::info($data);
                break;
            case 'debug':
                Log::debug($data);
                break;
            default:
                Log::info($data);
        }

    }
}