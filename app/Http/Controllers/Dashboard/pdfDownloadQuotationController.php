<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Quotation;
use Carbon\Carbon;

use Exception;
use Illuminate\Support\Facades\DB;

class pdfDownloadQuotationController extends Controller
{
    /**
     * Download the resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdfDownload()
    {
        try {
            $data = Quotation::get();
            $fileName = 'document.pdf';
            $mpdf = new \Mpdf\Mpdf([
                'margin-left' => 10,
            ]);
            $html = \View::make('dashboard/quotation/pdf/pdf_download')->with('data', $data);
            $html = $html->render();

            // get current date
            $current = Carbon::now()->format('l jS M Y');
            $mpdf->SetHeader($current . '- Netra Back-end -');
            $mpdf->SetFooter('&copy; Copyright -{PAGENO}-');
            $mpdf->WriteHTML($html);
            $mpdf->Output($fileName, 'I');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('quotation-list')
                ->with('error', 'Quotation can not download!');
        }
    }
}
