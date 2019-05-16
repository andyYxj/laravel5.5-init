<?php

namespace App\Console\Commands\Task\Admin\Demo;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Helps\LogHelper;

class TaskTwo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task_admin_demo_tasktwo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'demo taskTwo';

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
       // $this->line('我是测试任务2号，我也是一分钟执行一次');
        //while(true){
            LogHelper::writeLocalLog('我是2号任务，我一分钟执行一次,我自己偷偷的2s 跑一次，看看会不会挂','info');
           // Log::info('我是2号任务，我一分钟执行一次,我自己偷偷的2s 跑一次，看看会不会挂');
      //  }

    }
}
