<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all tables except users and organisations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Tables to exclude
        $excludedTables = ['users', 'organisations'];

        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Get all table names
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . env('DB_DATABASE'); // for MySQL

        // Drop all tables except excluded ones
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            if (!in_array($tableName, $excludedTables)) {
                DB::table($tableName)->truncate(); // or use DB::statement('TRUNCATE TABLE ' . $tableName);
                $this->info("Table {$tableName} has been truncated.");
            }
        }

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $this->info('Database reset complete.');
        return 0;
    }
}
