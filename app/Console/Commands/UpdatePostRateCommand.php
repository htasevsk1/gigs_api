<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdatePostRateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postRate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates values for `post_rate` column in users table.';

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        DB::statement("
            UPDATE `users` AS `target`,
            (
                SELECT
                    `u`.`id` AS `user_id`,
                    COUNT(*) AS `gigs_count`,
                    SUM(`g`.`number_of_positions`) AS `total_shifts`
                FROM `gigs` AS `g`
                JOIN `companies` AS `c` ON `g`.`company_id` = `c`.`id`
                JOIN `users` AS `u` ON `c`.`user_id` = `u`.`id`
                GROUP BY `u`.`id`
            ) AS `src`
            SET `target`.`post_rate` = (`src`.`gigs_count` / `src`.`total_shifts` ) * 100
            WHERE `target`.`id` = `src`.`user_id`;
        ");

        $this->output->success('Successfully updated post rates.');

        return true;
    }
}
