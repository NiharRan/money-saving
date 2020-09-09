<?php

namespace App\Http\Controllers\Settings;

use App\Repositories\Settings\MoneyFormatRepository;
use App\Settings\MoneyFormat;
use App\Http\Controllers\Controller;

class MoneyFormatController extends Controller
{
  private $moneyFormatRepository;
  function __construct(MoneyFormatRepository $moneyFormatRepository)
  {
    $this->moneyFormatRepository = $moneyFormatRepository;
  }

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],['link'=>"",'name'=>"Money Formats"]
      ];
      return view('/pages/money-formats/index', [
        'breadcrumbs' => $breadcrumbs
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],
        ['link'=>"/money-formats",'name'=>"Money Formats"],
        ['link'=>"",'name'=>"Create New Money Format"],
      ];
      return view('/pages/money-formats/create', [
        'breadcrumbs' => $breadcrumbs
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings\MoneyFormat  $moneyFormat
     * @return \Illuminate\Http\Response
     */
    public function edit(MoneyFormat $moneyFormat)
    {
      $breadcrumbs = [
        ['link'=>"/",'name'=>"Home"],
        ['link'=>"/money-formats",'name'=>"Money Formats"], ['name'=>"Edit Money Format"]
      ];
      return view('/pages/money-formats/edit', [
        'breadcrumbs' => $breadcrumbs
      ])->withMoneyFormat($moneyFormat);
    }
}
