<?php

namespace App\Logging;

//use Monolog\Formatter\LineFormatter;
//use Illuminate\Support\Facades\Auth;
//use Monolog\Processor\ProcessIdProcessor;
//use App\Consts\UserConst;
//use Illuminate\Support\Facades\Session;
//use Monolog\Processor\MemoryUsageProcessor;

use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;

class CustomizeFormatter
{
    private $dateFormat = 'Y-m-d H:i:s.v';

    public function __invoke($logger)
    {
        // 修正がしやすいように配列を用いる
        $format = implode('	', [
            '[%datetime% %level_name% ID:%extra.uid%]',
            '[MEM(use:%extra.umem%,peak:%extra.pmem%)]',
            '%message%',
            '[Context:%context%]',
            '[IpAddress:%extra.ip%]',
            '[Referrer:%extra.referrer%]',
            '[%extra.class%/%extra.function%:%extra.line%行目]',
        ])
            . PHP_EOL;

        // ログのフォーマットと日付のフォーマットを指定する
        //$lineFormatter = new LineFormatter($format, $this->dateFormat, true, true);
        $lineFormatter = new CustomLineFormatter($format, $this->dateFormat, true, true);
        // IntrospectionProcessorを使うとextraフィールドが使えるようになる
        $ip = new IntrospectionProcessor(Logger::DEBUG, ['Illuminate\\']);
        // WebProcessorを使うとextra.ipが使えるようになる
        $wp = new WebProcessor();
        // MemoryUsageProcessorを使うとextra.memory_usageが使えるようになる
        // $mup = new MemoryUsageProcessor();
        // $idProcessor = new ProcessIdProcessor();
        $up = new UidProcessor();

        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($lineFormatter);
            // pushProcessorするとextra情報をログに埋め込んでくれる
            $handler->pushProcessor($ip);
            $handler->pushProcessor($wp);
            $handler->pushProcessor($up);
            //$handler->pushProcessor($mup);
            //addExtraFields()を呼び出す。extra.useridとextra.usernameをログに埋め込んでくれる
            $handler->pushProcessor([$this, 'addExtraFields']);
        }
    }
    public function addExtraFields(array $record): array
    {
        $record['extra']['umem'] = floor(memory_get_usage() / (1024 * 1024)) . 'MB';
        $record['extra']['pmem'] = floor(memory_get_peak_usage() / (1024 * 1024)) . 'MB';
        return $record;
    }
}
