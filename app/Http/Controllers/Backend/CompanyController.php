<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Base\Prefecture;
use App\Models\Postcode;
use Config;
use Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Storage;

class CompanyController extends Controller
{
    /**
     * Get named route
     *
     */
    private function getRoute()
    {
        return 'admin.company';
    }

    /**
     * Validator for company
     *
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data, $type)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'postcode' => 'required|string',
            'prefecture_id' => 'required|int',
            'city' => 'required|string',
            'local' => 'required|string',
            'street_adrress' => 'nullable|string',
            'business_hour' => 'nullable|string',
            'regular_holiday' => 'nullable|string',
            'phone' => 'nullable|string',
            'fax' => 'nullable|string',
            'url' => 'nullable|string',
            'license_number' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:3000',
        ]);
    }

    /**
     * Show the table which has the data of company.
     *
     * @return void
     */
    public function index()
    {
        $companies = Company::latest()->get();
        return view('/backend.companies.index', [
            'companies' => $companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return 
     */
    public function add(Request $request)
    {
        $company = new Company();
        $prefectures = Prefecture::all();
        $postcodes = Postcode::all();
        $search = Postcode::where('postcode', 'like', '%' . $request->postcode . '%')->get()->firstWhere('postcode', $request->postcode);

        $company->form_action = $this->getRoute() . '.create';
        $company->page_title = 'Company Add Page';
        $company->page_type = 'create';
        $prefecture_id = [];

        $prefecture_id[null] = '';
        foreach ($prefectures as $prefecture) {
            $prefecture_id[$prefecture->id] = $prefecture->display_name;
        }

        foreach ($postcodes as $postcode) {
            $postcode;
        }

        return view('/backend.companies.form', [
            'company' => $company,
            'prefecture_id' => $prefecture_id,
            'postcode' => $postcode,
            'search' => $search
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $newCompany = $request->all();

        $this->validator($newCompany, 'create')->validate();

        try {
            $company = Company::create($newCompany);
            if ($company) {
                $file = $request->file('image');
                $getMime = $file->getClientMimeType();
                $file_ext = explode('/', $getMime);
                // recreate image name
                $fileName = 'image_' . $company->id . '.' . $file_ext[1];
                $file->storeAs('public', $fileName);

                // Store image's name in database
                $company['image'] = $fileName;
                $company->save();

                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));
            } else {
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }
        } catch (Exception $e) {
            throw $e;
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $company = Company::find($id);
        $prefectures = Prefecture::all();
        $postcodes = Postcode::all();

        $company->form_action = $this->getRoute() . '.update';
        $company->page_title = 'Company Add Page';
        $company->page_type = 'edit';
        $prefecture_id = [];

        $prefecture_id[null] = '';
        foreach ($prefectures as $prefecture) {
            $prefecture_id[$prefecture->id] = $prefecture->display_name;
        }

        foreach ($postcodes as $postcode) {
            $postcode;
        }

        return view('/backend.companies.form', [
            'company' => $company,
            'prefecture_id' => $prefecture_id,
            'prefecture' => $prefecture,
            'postcode' => $postcode,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $newCompany = $request->all();
        $currentCompany = Company::find($request->get('id'));

        try {
            if ($currentCompany) {
                $this->validator($newCompany, 'update')->validate();

                $file = $request->file('image');
                $getMime = $file->getClientMimeType();
                $file_ext = explode('/', $getMime);
                $fileName = 'image_' . $currentCompany->id . '.' . $file_ext[1];
                $file->storeAs('public', $fileName);


                $newCompany['image'] = $fileName;

                $currentCompany->update($newCompany);

                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_UPDATE_MESSAGE'));
            } else {
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
            }
        } catch (Exception $e) {
            throw $e;
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
        }
    }

    /**
     * Delete the specified resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request)
    {
        $company = Company::find($request->get('id'));

        try {
            if ($company->image) {
                Storage::delete('/public' . $company->image);
            }

            $company->delete();

            return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_DELETE_MESSAGE'));
        } catch (Exception $e) {
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_DELETE_MESSAGE'));
        }
    }
}
