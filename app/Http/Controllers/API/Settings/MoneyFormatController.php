<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\MoneyFormatRequest;
use App\Repositories\Settings\MoneyFormatRepository;
use App\Settings\MoneyFormat;

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
        return $this->moneyFormatRepository->MoneyFormatDataInTable();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MoneyFormatRequest $request)
    {
        $moneyFormat = $this->moneyFormatRepository->store();
        if ($moneyFormat) return response()
          ->json(['success' => "$moneyFormat->name created successfully!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MoneyFormatRequest $request, MoneyFormat $moneyFormat)
    {
        $moneyFormat = $this->moneyFormatRepository->update($moneyFormat->id);
        if ($moneyFormat) {
            return response()
            ->json(['success' => 'Account type info updated successfully!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MoneyFormat $moneyFormat)
    {
        $name = $moneyFormat->name;
        if ($moneyFormat->delete()) return response()
            ->json(['success' => "$name deleted successfully!"]);
    }
}
