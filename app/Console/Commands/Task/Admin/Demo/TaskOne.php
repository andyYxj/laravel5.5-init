<?php

namespace App\Console\Commands\Task\Admin\Demo;

use App\Helps\LogHelper;
use Illuminate\Console\Command;
use App\Services\Cart\BusinessCartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * 一个测试任务类
 * Class TaskOne
 * @package App\Console\Commands\Task\Admin\Demo
 */
class TaskOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task_admin_demo_taskone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'admin 模块- a demo task';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $service;

    public function __construct(BusinessCartService $businessCartService)
    {
        parent::__construct();
        $this->service=$businessCartService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        //$this->line($this->service->list($request));
        //Log::info('我是1号任务，我一分钟执行一次');
      /*  $monolog = Log::getMonolog();
        $monolog->popHandler();
        Log::useDailyFiles( storage_path().'/logs/single-log.log', 30 );
        Log::info( 'single-log');*/
        LogHelper::writeLocalLog('testlog1213','info');
    }
}
