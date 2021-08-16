<?php

namespace App\Jobs;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;
use League\Csv\Statement;

class SubscribersParseFromFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;// Название файла с которым ведётся работа

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @throws \League\Csv\Exception
     * @throws \League\Csv\InvalidArgument
     */
    public function handle()
    {
        $reader = Reader::createFromPath(storage_path()."\app\\".$this->filePath, 'r')->setDelimiter(';');
        $reader->setHeaderOffset(0);

        $subscribersCount = count($reader);

        $subscribersLimit = 30; // Количество записей за раз читаймое из файла
        for ($i = 1; $i < $subscribersCount; $i += $subscribersLimit) {
            $list = Statement::create()
                ->offset($i)
                ->limit($subscribersLimit)
                ->process($reader);

            $data = [];
            foreach ($list->getRecords() as $record) {
                $data[] = $record; // тут можно обрабатывать колонки
            }
            Log::info(json_encode($data));

            Subscriber::upsert(
                $data, // Вставляем разом записи
                ['email', 'fio'],
                ['fio']// При одинаковой почте - обновляем фио (для дублирования - переместить поле fio)
            );
        }
    }
}
