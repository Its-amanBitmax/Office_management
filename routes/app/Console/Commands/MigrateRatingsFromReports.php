<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateRatingsFromReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:ratings-from-reports';

    protected $description = 'Migrate existing ratings from reports table to ratings table';

    public function handle()
    {
        $this->info('Starting migration of ratings from reports to ratings table...');

        $reports = \App\Models\Report::whereNotNull('admin_rating')->orWhereNotNull('team_lead_rating')->get();

        $count = 0;

        foreach ($reports as $report) {
            $ratingDate = \Carbon\Carbon::parse($report->created_at)->toDateString();

            // Handle admin rating
            if ($report->admin_rating !== null) {
                $existing = \App\Models\Rating::where('employee_id', $report->employee_id)
                    ->where('stars', $report->admin_rating)
                    ->where('rating_date', $ratingDate)
                    ->first();

                if (!$existing) {
                    \App\Models\Rating::create([
                        'employee_id' => $report->employee_id,
                        'stars' => $report->admin_rating,
                        'rating_date' => $ratingDate,
                    ]);
                    $count++;
                }
            }

            // Handle team lead rating
            if ($report->team_lead_rating !== null) {
                $existing = \App\Models\Rating::where('employee_id', $report->employee_id)
                    ->where('stars', $report->team_lead_rating)
                    ->where('rating_date', $ratingDate)
                    ->first();

                if (!$existing) {
                    \App\Models\Rating::create([
                        'employee_id' => $report->employee_id,
                        'stars' => $report->team_lead_rating,
                        'rating_date' => $ratingDate,
                    ]);
                    $count++;
                }
            }
        }

        $this->info("Migration completed. {$count} ratings migrated.");

        return 0;
    }
}
