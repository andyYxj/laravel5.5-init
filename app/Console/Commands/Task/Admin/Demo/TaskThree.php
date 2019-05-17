<?php

namespace App\Console\Commands\Task\Admin\Demo;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TaskThree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task_admin_demo_taskthree';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->line('我是测试任务2号，我5分钟执行一次');
        $key_1=config('test.home.name');
        $key_2=config('test.app_name_test');
        $key_wechat=config('wechat.wechat.key');
        $key_super=config('superAdmin.superAdmin.key');
        Log::info('我是3号任务，我5分钟执行一次');
    }
}
