<?php

namespace App\Http\Controllers;

use App\Component\Card\Card;
use App\Component\Excel\Excel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;
use PhpOffice\PhpSpreadsheet\Writer\Exception;

class ExcelController extends Controller
{
    /**
     * @throws Exception
     * @throws GuzzleException
     */

    #[ArrayShape(['status' => "string"])]
    public function excelUpload(Request $request, Card $cardHelper): array
    {
        if ($fileUpload = $request->file('file_upload')) {
            $file = Storage::disk('local')->put('excel', $fileUpload);

            $excelHelper = new Excel(storage_path('app/'.$file));
            $excelHelper->addHeader();

            $data = $excelHelper->getDataArray();

            foreach ($data as $key => $value) {
                if ($key === 0) {
                    continue;
                }
                $cardHelper->setCard($value[2]);

                $data[$key] = Arr::collapse([
                        $value,
                        [
                                $cardHelper->getCardService(),
                                $cardHelper->getCardBank()
                        ]
                ]);
            }

            $excelHelper->saveData();

            if ($callbackUrl = $request->header('callback_url')) {
                $client = new Client();

                $res = $client->request(
                        'POST',
                        $callbackUrl,
                        ['file_upload' => $excelHelper->getFile()]);
                if ($res->getStatusCode() !== 200) {
                    throw new Exception("Fail");
                }
            }
        } else {
            throw new Exception("pls upload file");
        }

        return [
                'status' => 'success'
        ];
    }
}
