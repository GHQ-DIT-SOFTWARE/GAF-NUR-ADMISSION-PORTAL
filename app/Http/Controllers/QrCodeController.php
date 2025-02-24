<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class QrCodeController extends Controller
{
    public function decript()
    {
        return view('admin.pages.decrypt.decript');
    }
    public function decryptQrCode(Request $request)
    {
        $defaultPassword = 'GAFp@$$Word@dIT';
        $encryptedData = $request->input('data');

        try {
            // Decrypt the data
            $decryptedData = Crypt::decryptString($encryptedData);

            // Decode the JSON data
            $applicantData = json_decode($decryptedData, true);

            // Check if decoding was successful and if the data is an array
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($applicantData)) {
                throw new \Exception('Invalid JSON data or not an array');
            }

            // Debugging: Log the decrypted data
            \Log::info('Decrypted Applicant Data: ', $applicantData);

            return view('show_applicant_data', compact('applicantData'));
        } catch (\Exception $e) {
            // Log the error and return a response
            \Log::error('Decryption failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid or corrupted data'], 400);
        }
    }

}
