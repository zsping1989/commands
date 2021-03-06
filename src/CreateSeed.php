<?php

namespace Custom\Commands;

use Custom\Commands\Bases\BaseCreate;
use Illuminate\Support\Facades\DB;

class CreateSeed extends BaseCreate
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:seed {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自定义模板填充文件生成';

    protected $type='php';
    protected $tpl = 'create/seed';
    protected $baseNamespace = '';
    /**
     * 绑定模型
     * @var
     */
    protected $bindModel;


    protected function getOutputPath(){
        $this->outputPath = database_path('seeds/'.class_basename($this->argument('model')).'TableSeeder');
    }

    /**
     * 创建迁徙文件
     */
    protected function readyDatas(){
        $model = 'App\\'.str_replace('/','\\',$this->argument('model'));
        $this->bindModel = new $model();
        $data['php'] = '<?php';
        $data['model'] = $model;
        $data['json'] = 'JSON';
        $data['class'] = class_basename($this->argument('model'));
        $connection = $this->bindModel->getConnectionName() ?: config('database.default');
        $prefix = config('database.connections.'.$connection.'.prefix');
        $trueTable = $prefix.$this->bindModel->getTable();
        $data['data'] = collect(DB::connection($connection)->select('SELECT * FROM `'.$trueTable.'`'))->map(function($item){
            return collect($item)->toArray();
        })->toJson();
        $this->datas = $data;
    }
}
