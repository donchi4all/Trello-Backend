<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\DbDumper\Compressors\GzipCompressor;
use Spatie\DbDumper\Databases\MySql;
use Spatie\DbDumper\Exceptions\CannotStartDump;
use Spatie\DbDumper\Exceptions\DumpFailed;

class SQLDBDumpController extends Controller
{

    public function dumpDB()
    {
        $databaseName =  config('database.connections.mysql.database');
        $userName =  config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');;

        try {
            \Spatie\DbDumper\Databases\MySql::create()
                ->setDbName($databaseName)
                ->setUserName($userName)
                ->setPassword($password)
                ->dumpToFile('db-backups/' . time() . '_dump.sql');
        } catch (CannotStartDump | DumpFailed $e) {
            return badRequest($e->getMessage());
        }

        return success('successfully dumpToFile',[]);
    }
}
