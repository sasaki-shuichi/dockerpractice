<?php

namespace App\Http\Controllers\Disp;

use App\Business\Screen\Disp\DispBusiness;
use App\Business\Screen\Disp\DispViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\DispFormRequest;

/**
 * DispController
 */
class DispController extends Controller
{
    private $business;

    /**
     * construct
     */
    public function __construct(DispBusiness $b)
    {
        $this->business = $b;
    }

    /**
     * init
     */
    public function init(DispFormRequest $request)
    {
        return view('pages.disp', ['model' => new DispViewModel()]);
    }

    /**
     * search
     */
    public function search(DispFormRequest $request)
    {
        $model = $this->business->search($request);
        return view('pages.disp', ['model' => $model]);
    }

    /**
     * search
     */
    public function page(DispFormRequest $request)
    {
        $model = $this->business->page($request);
        return view('pages.disp', ['model' => $model]);
    }

    /**
     * edit
     */
    public function edit(DispFormRequest $request)
    {
        $userId = $request->input('userId');
        return redirect()->route('input.edit')->with('user_id', $userId);
    }

    /**
     * complete
     */
    public function complete(DispFormRequest $request)
    {
        $model = $this->business->complete($request);
        return view('pages.disp', ['model' => $model]);
    }
}
