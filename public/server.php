<?php
class Server {
    private $serv;
    private $logFile;
    
    public function __construct() {
        $this->serv = new swoole_server('0.0.0.0', 9501);   // 允许所有IP访问
        $this->serv->set([
            'worker_num' => 4,   // 一般设置为服务器CPU数的1-4倍
            'task_worker_num' => 1,  // task进程的数量（一般任务都是同步阻塞的，可以设置为单进程单线程）
            'daemonize' => true,  // 以守护进程执行
            'package_eof' => PHP_EOL,  // 设置EOF
            'open_eof_split' => true,  // 按照EOF进行分包，防止TCP粘包
        //  'task_ipc_mode' => 1,  // 使用unix socket通信，默认模式
        //  'log_file' => '/data/log/queue.log' ,    // swoole日志
        
        // 数据包分发策略（dispatch_mode=1/3时，底层会屏蔽onConnect/onClose事件，
        // 原因是这2种模式下无法保证onConnect/onClose/onReceive的顺序，非请求响应式的服务器程序，请不要使用模式1或3）
        //  'dispatch_mode' => 2,        // 固定模式，根据连接的文件描述符分配worker。这样可以保证同一个连接发来的数据只会被同一个worker处理
        ]);

        $this->logFile = dirname(__FILE__).'/log.txt';        // 以守护进程执行的时候，要绝对路径
        $this->serv->on('Receive', [$this, 'onReceive']);
        $this->serv->on('Task', [$this, 'onTask']);
        $this->serv->on('Finish', [$this, 'onFinish']);
        $this->serv->start();
    }
    
    /**
    * 接收到数据时回调此函数，发生在worker进程中
    * $server，swoole_server对象
    * $fd，TCP客户端连接的文件描述符
    * $from_id，TCP连接所在的Reactor线程ID
    * $data，收到的数据内容，可能是文本或者二进制内容
    */
    public function onReceive($serv, $fd, $from_id, $data ) {
        $str  = "=========== onReceive ============ \n";
        $str .= "Get Message From Client $fd:$data \n";
        error_log($str, 3, $this->logFile);
        $serv->task( $data );
    }
    
    /**
    * 在task_worker进程内被调用。worker进程可以使用swoole_server_task函数向task_worker进程投递新的任务。当前的Task进程在调用onTask回调函数时会将进程状态切换为忙碌，
    * 这时将不再接收新的Task，当onTask函数返回时会将进程状态切换为空闲然后继续接收新的Task。
    * $task_id是任务ID，由swoole扩展内自动生成，用于区分不同的任务。$task_id和$src_worker_id组合起来才是全局唯一的，不同的worker进程投递的任务ID可能会有相同
    * $src_worker_id来自于哪个worker进程
    * $data 是任务的内容
    */
    public function onTask($serv, $task_id, $src_worker_id, $data) {
        $data   = trim($data);　　// 删除EOF
        $array  = json_decode( $data , true );
        $str    = "=========== onTask ============ \n";
        $str   .= var_export($array, 1);
        error_log($str, 3 , $this->logFile);
        return $array;
    }
    
    /**
    * 当worker进程投递的任务在task_worker中完成时，task进程会通过swoole_server->finish()方法将任务处理的结果发送给worker进程
    * $task_id是任务的ID
    * $data是任务处理的结果内容（也就是onTask()函数，中return的值）
    */
    public function onFinish($serv, $task_id, $data) {
        $str  = "=========== onFinish ============ \n";
        $str .= "Task $task_id finish ! \n";
        $str .= var_export($data, 1);
        error_log($str, 3, $this->logFile);
    }

}
$server = new Server();

