<?php

namespace Supports\Facades;

class Queue
{
    private static $instance;
    public $redis;

    public function __construct()
    {
        $this->redis = new \Predis\Client([
            'scheme' => config('app.redis.scheme'),
            'host' => config('app.redis.host'),
            'port' => config('app.redis.port'),
            'database' => config('app.redis.database'),
            'read_write_timeout' => config('app.redis.read_write_timeout')
        ]);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function worker($taskQ, $di, $id = null)
    {
        if (null === $id) {
            $id = getmypid();
        }
        $workerID = $taskQ . ':worker:' . $id;
        $this->redis->lpush($taskQ . ':workers', $workerID);
        $run = true;
        while ($run) {
            // Kiểm tra sự tồn tại của $taskQ trước khi thực hiện
            if (!$this->redis->exists($taskQ)) {
                $run = false;
                break;
            }

            $message =  $this->redis->brpoplpush($taskQ, $workerID, 0);
            if ($message) {
                try {
                    $o = json_decode($message);
                    $d = $o->d;
                    if ($o->e) {
                        if (method_exists($di, $o->e)) {
                            call_user_func([$di, $o->e], $d);
                        } else {
                            switch ($o->e) {
                                case 'print':
                                    echo $d, "\n";
                                    break;
                                case 'fail':
                                    $run = false;
                                    throw new \Exception($d->err);
                                    break;
                                case 'quit':
                                    $run = false;
                                    break;
                                default:
                                    throw new \Exception('message had an unrecognized event');
                                    break;
                            }
                        }
                    } else {
                        throw new \Exception('message did not contain an event');
                    }
                    $run = false;
                } catch (\Exception $e) {
                    Logger::error("ERROR RUN JOB : " . $e->getMessage());
                    $run = false;
                    break;
                } finally {
                    $this->redis->lRem($workerID, 1, $message);
                }
            }
        }
        $this->redis->lRem($taskQ . ':workers', 0, $workerID);
    }
}
