<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\MoneyFormatRequest;
use App\Repositories\Settings\MoneyFormatRepository;
use App\Settings\MoneyFormat;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function index()
    {
        $money_formats = $this->moneyFormatRepository->all()->get();
        return response()->json($money_formats);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function search()
    {
      $money_formats = $this->moneyFormatRepository->all()->get();
      return response()->json($money_formats);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
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
     * @return Response
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
     * @return Response
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
     * @return Response
     */
    public function destroy(MoneyFormat $moneyFormat)
    {
        $name = $moneyFormat->name;
        if ($moneyFormat->delete()) return response()
            ->json(['success' => "$name deleted successfully!"]);
    }
}
