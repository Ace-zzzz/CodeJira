<?php

namespace App\Imports;

use App\Models\Campus;
use App\Models\Program;
use App\Models\Enrollment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;
use Throwable;

class EnrollmentImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        try
        {
            $campus = Campus::firstOrCreate(['name' => 'Sta. Mesa Campus']);

            // Skip the first few non-data rows (e.g., headers or titles)
            $rows = $rows->slice(5); // Adjust index as needed if actual data starts later

            foreach ($rows as $row) {
                $name = $row[1]; // Column B: Program Name
                $count = $row[2]; // Column C: No.
                $percent = $row[3]; // Column D: %

                // Skip rows with headers or totals
                if (
                    empty($name) ||
                    in_array(strtolower(trim($name)), ['programs', 'total', 'masters programs', 'doctoral programs'])
                ) {
                    continue;
                }

                $program = Program::firstOrCreate(['name' => $name], [
                    'program_category_id' => 1, // default category for now
                ]);

                Log::info("Row debug: ", $row->toArray());

                Enrollment::create([
                    'program_id' => $program->id,
                    'campus_id' => $campus->id,
                    'program_name' => $name,
                    'number_of_students' => (int) $count,
                    'percentage' => (float) $percent,
                ]);
            }
        }
        catch(Throwable $error)
        {
            Log::error('ERRO UPON IMPORTING EXCEL: ', [
                'message ' => $error->getMessage()
            ]);
        }
    }
}
