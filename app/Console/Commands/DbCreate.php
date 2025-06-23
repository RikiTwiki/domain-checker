<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use PDO;
use PDOException;

class DbCreate extends Command
{
    protected $signature   = 'db:create';
    protected $description = 'Создать базу данных, указанную в .env (только PostgreSQL)';

    public function handle(): int
    {
        $db   = Config::get('database.connections.pgsql.database');
        $host = Config::get('database.connections.pgsql.host');
        $port = Config::get('database.connections.pgsql.port');
        $user = Config::get('database.connections.pgsql.username');
        $pass = Config::get('database.connections.pgsql.password');

        try {
            // Подключаемся к системной БД postgres
            $pdo = new PDO("pgsql:host=$host;port=$port;dbname=postgres", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            // Проверяем, существует ли база
            $exists = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$db'")->fetch();

            if ($exists) {
                $this->info("База \"$db\" уже существует ✅");
            } else {
                $pdo->exec("CREATE DATABASE \"$db\";");
                $this->info("База \"$db\" успешно создана 🎉");
            }
        } catch (PDOException $e) {
            $this->error('Ошибка соединения или создания БД: '.$e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}