<?php

namespace App\Http\Controllers;

use App\Providers\CurrencyRateProvider;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\Request;

class CurrencyExchangeController extends Controller
{
    private CurrencyRateProvider $rateProvider;

    public function __construct(CurrencyRateProvider $rateProvider)
    {
        $this->rateProvider = $rateProvider;
    }

    /**
     * @param  Request  $request
     * @return array
     */
    public function exchange(Request $request): array
    {
        $source = $request->input('source');
        $target = $request->input('target');
        $amount = $request->input('amount');

//        validate input
        if (!is_string($source) || !is_string($target) || !is_numeric($amount)) {
            return [
                "msg" => "Invalid input",
                "error" => "Invalid input type. Please check your input."
            ];
        }
        try {
            $currencyExchangeService = new CurrencyExchangeService($source, $target, $amount, $this->rateProvider);
            $target_amount = $currencyExchangeService->convert();
        } catch (\Exception $e) {
            return [
                "msg" => "Exception",
                "error" => $e->getMessage()
            ];
        } catch (\TypeError $e) {
            return [
                "msg" => "TypeError",
                "error" => "Invalid input type. Please check your input."
            ];
        }

        return [
            "msg" => "success",
            "amount" => $target_amount
        ];
    }

}
