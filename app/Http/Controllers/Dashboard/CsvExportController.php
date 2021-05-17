<?php


namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Quotation;

use Exception;
use Illuminate\Support\Facades\DB;

class CsvExportController extends Controller
{
    /**
     * Export the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCsv(Request $request)
    {
        try {
            $fileName = 'quotation.csv';
            $quotation = Quotation::all();

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $columns = array('Staff Note', 'Quotation Note', 'Paid', 'Total', 'Payment Status', 'Status', 'Reference Number', 'Date Time');

            $callback = function () use ($quotation, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($quotation as $item) {
                    $row['Staff Note']  = $item->staff_note;
                    $row['Quotation Note']   = $item->quotation_note;
                    $row['Paid']    = $item->paid;
                    $row['Total']  = $item->total;
                    $row['Payment Status']  = $item->payment_status;
                    $row['Status']  = $item->status;
                    $row['Reference Number']  = $item->reference_num;
                    $row['Date Time']  = $item->datetime;

                    fputcsv($file, array(
                        $row['Staff Note'], $row['Quotation Note'],
                        $row['Paid'], $row['Total'], $row['Payment Status'], $row['Status'],
                        $row['Reference Number'], $row['Date Time']
                    ));
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('quotation-list')
                ->with('error', 'Quotation can not export!');
        }
    }
}
