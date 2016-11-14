<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Tenant;
use App\Http\Requests;
use App\User;
use Image;
use App\Tag;
use App\Mail\ConfirmationMailTenant;
use App\Address;
use App\Parents;
use Illuminate\Support\Facades\Redirect;

class TenantController extends Controller
{
    //Show Profile Page
    public function showProfile()
    {
        $city = City::all();
        $list_city = array();
        $tenant = Tenant::where("idPerson", "=", \Auth::user()->idPerson)->first();
        $parent = Parents::where("idTenant", "=", $tenant->idTenant)->first();
        $address_T = Address::where("idAddress", "=", $tenant->idAddress)->first();
        $address_P = Address::where("idAddress", "=", $parent->idAddress)->first();
        $user = User::find(\Auth::user()->idPerson);
        foreach ($city as $town) {
            $list_city[$town->idCity] = $town->libelle;
        }
        $all_Tag = Tag::all();
        $list_tag = $tenant->tag()->get();
        return view('tenant/profil_tenant', compact('list_city', 'tenant', 'user', 'parent', 'address_T', 'address_P', 'list_tag', 'all_Tag'));
    }

    //Delete all info about a tenant + Ne pas oublier de mettre anonyme les bookings
    public function delete()
    {
        $user = User::where('idPerson', '=', \Auth::user()->idPerson)->first();
        $tenant = Tenant::where("idPerson", "=", \Auth::user()->idPerson)->first();
        $parent = Parents::where("idTenant", "=", $tenant->idTenant)->first();
        if ($tenant->idAddress == $parent->idAddress) {
            $address = Address::where("idAddress", "=", $parent->idAddress)->first();
            $address->delete();
        } else {
            $address_P = Address::where("idAddress", "=", $parent->idAddress)->first();
            $address_T = Address::where("idAddress", "=", $tenant->idAddress)->first();
            $address_T->delete();
            $address_P->delete();
        }
        $parent->delete();
        $tenant->delete();
        $user->delete();
        return Redirect::to('index');
    }

    //Disable a Tenant Account
    public function disable()
    {
        $user = User::where('idPerson', '=', \Auth::user()->idPerson)->first();
        $user->status = 2;
        $user->confirmation_code = NULL;
        $user->save();
        return Redirect::to('logout');
    }

    public function changePassword()
    {
        $Data = \Input::get('data');
        parse_str($Data, $tenantData);

        $rules = array(
            'actual_password' => 'required|min:6',
            'new_password' => 'required|min:6|different:actual_password|confirmed',
            'new_password_confirmation' => 'required|min:6',
        );

        $validator = \Validator::make($tenantData, $rules);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            if (\Hash::check($tenantData['actual_password'], \Auth::user()->password)) {
                $user = User::where('idPerson', '=', \Auth::user()->idPerson)->first();
                $user->password = \Hash::make($tenantData['new_password']);
                $user->save();
                return \Redirect::to('tenant');
            } else {
                $error = 'Wrong password';
                return \Response::json(array(
                    'fail' => true,
                    'errors_auth' => $error
                ));
            }
        }
    }

    public function updateBookingSearch()
    {
        $tenant = Tenant::where('idPerson', '=', \Auth::user()->idPerson)->first();
        $user = User::find(\Auth::user()->idPerson);
        $Data = \Input::get('data');
        parse_str($Data, $tenantData);

        $rules = array(
            'expected_in' => 'required|date|after:today',
            'expected_out' => 'required|date|after:expected_in'
        );

        $validator = \Validator::make($tenantData, $rules);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            $tenant->expected_city = $tenantData['expected_city'];

            if ($tenantData['budget_min'] == "") {
                $tenant->budget_min = NULL;
            } else {
                $tenant->budget_min = $tenantData['budget_min'];
            }

            if ($tenantData['budget_max'] == "") {
                $tenant->budget_max = NULL;
            } else {
                $tenant->budget_max = $tenantData['budget_max'];
            }

            if ($tenantData['expected_in'] == "") {
                $tenant->expected_in = NULL;
            } else {
                $tenant->expected_in = $tenantData['expected_in'];
            }

            if ($tenantData['expected_out'] == "") {
                $tenant->expected_out = NULL;
            } else {
                $tenant->expected_out = $tenantData['expected_out'];
            }
            $tenant->expected_type = $tenantData['expected_type'];
            $tenant->couple = $tenantData['couple'];
            $tenant->save();

            if ($tenantData['First_step']) {
                $user->status = 1;
                $user->save();
            }
        }
    }

    public function updateAboutYou()
    {
        $tenant = Tenant::where('idPerson', '=', \Auth::user()->idPerson)->first();

        $Data = \Input::get('data');
        parse_str($Data, $tenantData);

        if ($tenantData['First_step']) {
            $rules = array(
                'nationality' => 'required',
                'school_company' => 'required',
                'gender' => 'required',
                'work_studies' => 'required',
                'spoken_languages' => 'required',
                'about' => 'required',
            );
        } else {
            $rules = array(
                'first_name' => 'required|alpha',
                'last_name' => 'required|alpha',
                'nationality' => 'required',
                'school_company' => 'required',
                'gender' => 'required',
                'work_studies' => 'required',
                'spoken_languages' => 'required',
                'about' => 'required',
            );
        }

        $validator = \Validator::make($tenantData, $rules);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            $tenant['about'] = $tenantData['about'];
            $tenant['spoken_languages'] = $tenantData['spoken_languages'];
            $tenant['nationality'] = $tenantData['nationality'];
            $tenant['contact_preference'] = $tenantData['contact_pref'];
            $tenant['student'] = $tenantData['student'];
            $tenant['work_studies'] = $tenantData['work_studies'];
            $tenant['school_company'] = $tenantData['school_company'];
            $tenant['gender'] = $tenantData['gender'];
            $tenant->save();

            if (!$tenantData['First_step']) {
                $user = User::where('idPerson', '=', \Auth::user()->idPerson)->first();
                $user['first_name'] = $tenantData['first_name'];
                $user['last_name'] = $tenantData['last_name'];
                $user->save();

                //Tag
                if ($tenantData['tag'] != Null) {
                    $All_tag = Tag::all();
                    $exists = false;
                    $Tenant_tag = array();
                    foreach ($All_tag as $tag) {
                        if ($tag->label == $tenantData['tag']) {
                            $old_tag = $tag;
                            $exists = true;
                        }
                    }
                    foreach ($tenant->tag()->get() as $t) {
                        array_push($Tenant_tag, $t->idTag);
                    }
                    if ($exists == false) {
                        $new_tag = Tag::create([
                            'label' => $tenantData['tag'],
                        ]);
                        array_push($Tenant_tag, ($new_tag->idTag));
                        $tenant->tag()->sync($Tenant_tag);
                    } else {
                        array_push($Tenant_tag, $old_tag->idTag);
                        $tenant->tag()->sync($Tenant_tag);
                    }
                    return \Response::json(array(
                        'list_tag' => $tenant->tag()->get(),
                    ));
                }
            }
        }
    }

    public function updateTrustCenter()
    {
        $tenant = Tenant::where('idPerson', '=', \Auth::user()->idPerson)->first();
        $user = User::where('idPerson', '=', \Auth::user()->idPerson)->first();
        $parent = Parents::where('idTenant', '=', $tenant->idTenant)->first();

        $Data = \Input::get('data');
        parse_str($Data, $tenantData);

        $rules = array(
            'email' => 'required|unique:person,email,' . \Auth::user()->idPerson . ',idPerson',
            'p_email' => 'unique:parent,email,',
            'phone' => 'required|regex:/[0-9]+/',
            'p_phone' => 'regex:/[0-9]+/',
        );

        $validator = \Validator::make($tenantData, $rules);

        if ($validator->fails()) {
            return \Response::json(array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {

            //Tenant Table save
            $tenant['birth_place'] = $tenantData['birth_place'];
            if ($tenantData['birth_date'] == "") {
                $tenant['birth_date'] = NULL;
            } else {
                $tenant['birth_date'] = $tenantData['birth_date'];
            }

            //Person Table save
            if ($user['email'] != $tenantData['email']) {
                $user['email'] = $tenantData['email'];
                //Confirmation Mail Send
                \Mail::to($tenantData['email'])->send(new ConfirmationMailTenant($user));

            }
            $user['phone'] = $tenantData['phone'];

            //Address Table save
            if ($tenant['idAddress'] != NULL) {
                if (!empty($address = Address::where('idAddress', '=', $tenant->idAddress)->first())) {
                    $address->street_number = $tenantData['street_number'];
                    $address->street = $tenantData['street_name'];
                    $address->complement = $tenantData['complement'];
                    $address->zip = $tenantData['zip'];
                    $address->city = $tenantData['city'];
                    $address->country = $tenantData['country'];
                    $address->save();
                } else {
                    $address = Address::create([
                        'street_number' => $tenantData['street_number'],
                        'street' => $tenantData['street_name'],
                        'complement' => $tenantData['complement'],
                        'zip' => $tenantData['zip'],
                        'city' => $tenantData['city'],
                        'country' => $tenantData['country'],
                    ]);
                    $tenant['idAddress'] = $address->idAddress;
                }
            } else {
                $address = Address::create([
                    'street_number' => $tenantData['street_number'],
                    'street' => $tenantData['street_name'],
                    'complement' => $tenantData['complement'],
                    'zip' => $tenantData['zip'],
                    'city' => $tenantData['city'],
                    'country' => $tenantData['country'],
                ]);
                $tenant['idAddress'] = $address->idAddress;
            }

            //Parent Table save
            $parent['first_name'] = $tenantData['p_first_name'];
            $parent['last_name'] = $tenantData['p_last_name'];
            $parent['email'] = $tenantData['p_email'];
            if ($tenantData['p_phone'] == "") {
                $parent['phone'] = NULL;
            } else {
                $parent['phone'] = $tenantData['p_phone'];
            }

            if ($tenantData['parent_address'] == 0) {
                if ($parent['idAddress'] != NULL && $parent['idAddress'] != $tenant['idAddress']) {
                    $address_delete = Address::where('idAddress', '=', $parent->idAddress);
                    $address_delete->delete();
                    $parent['idAddress'] = $tenant['idAddress'];
                } else {
                    $parent['idAddress'] = $tenant['idAddress'];
                }
            } else {
                $address = Address::create([
                    'street_number' => $tenantData['p_street_number'],
                    'street' => $tenantData['p_street_name'],
                    'complement' => $tenantData['p_complement'],
                    'zip' => $tenantData['p_zip'],
                    'city' => $tenantData['p_city'],
                    'country' => $tenantData['p_country'],
                ]);
                $parent['idAddress'] = $address->idAddress;
            }
            $parent->save();
            $tenant->save();
            $user->save();

            return [
                $tenantData,
                $parent,
                $tenant,
                $user,
            ];
        }
    }

    //Upload File ID/Passport
    public function updateIdentity()
    {
        $tenant = Tenant::where('idPerson', '=', \Auth::user()->idPerson)->first();
        if (\Input::file('picture')) {

            $image = \Input::file('picture');
            $filename = \Auth::user()->idPerson . '.' . $image->getClientOriginalExtension();
            $path = public_path("Identity/" . $filename);
            Image::make($image->getRealPath())->save($path);
            $tenant->identity = $filename;
            $tenant->save();
        }
        return \Redirect::to('tenant');
    }

    //Upload File Study Agreement
    public function updateStudyAgreement()
    {
        $tenant = Tenant::where('idPerson', '=', \Auth::user()->idPerson)->first();
        if (\Input::file('picture')) {

            $image = \Input::file('picture');
            $filename = \Auth::user()->idPerson . '.' . $image->getClientOriginalExtension();
            $path = public_path("StudyAgreement/" . $filename);
            Image::make($image->getRealPath())->save($path);
            $tenant->study_agreement = $filename;
            $tenant->save();
        }
        return \Redirect::to('tenant');
    }

    //Upload File Work Agreement
    public function updateWorkAgreement()
    {
        $tenant = Tenant::where('idPerson', '=', \Auth::user()->idPerson)->first();
        if (\Input::file('picture')) {

            $image = \Input::file('picture');
            $filename = \Auth::user()->idPerson . '.' . $image->getClientOriginalExtension();
            echo 'hey';
            $path = public_path("WorkAgreement/" . $filename);
            Image::make($image->getRealPath())->save($path);
            $tenant->work_Agreement = $filename;
            $tenant->save();
        }
        return \Redirect::to('tenant');
    }

    //Upload File Pay Slip
    public function updatePaySlip()
    {
        $tenant = Tenant::where('idPerson', '=', \Auth::user()->idPerson)->first();
        if (\Input::file('picture')) {

            $image = \Input::file('picture');
            $filename = \Auth::user()->idPerson . '.' . $image->getClientOriginalExtension();
            echo 'hey';
            $path = public_path("Pay/" . $filename);
            Image::make($image->getRealPath())->save($path);
            $tenant->pay_slip = $filename;
            $tenant->save();
        }
        return \Redirect::to('tenant');
    }

    //Upload Profil Picture Dropzone
    public function uploadFiles()
    {

        $tenant = Tenant::where('idPerson', '=', \Auth::user()->idPerson)->first();

        $input = \Input::all();

        $rules = array(
            'file' => 'image|max:3000',
        );

        $validation = \Validator::make($input, $rules);

        if ($validation->fails()) {
            return \Response::make($validation->errors->first(), 400);
        }
        $image = \Input::file('file');
        $destinationPath = 'profilepics'; // upload path
        $fileName = \Auth::user()->idPerson . '.' . $image->getClientOriginalExtension();
        $upload_success = $image->move($destinationPath, $fileName); // uploading file to given path
        $tenant->profile_picture = $fileName;
        $tenant->save();

        if ($upload_success) {
            return \Response::json('success', 200);
        } else {
            return \Response::json('error', 400);
        }

    }

    //Delete picture on dropzone (Profil Picture)
    public function deletePicture()
    {
        $tenant = Tenant::where('idPerson', '=', \Auth::user()->idPerson)->first();
        $tenant->profile_picture = NULL;
        $tenant->save();

    }

    //Confirm first connection after confirmation mail
    public function FirstStepTenant()
    {
        $user = User::find(\Auth::user()->idPerson);
        $user->status = 1;
        $user->save();
    }

    //Delete Tag
    public function DeleteTagTenant()
    {
        $tenant = $tenant = Tenant::where('idPerson', '=', \Auth::user()->idPerson)->first();
        $tag = $tenant->tag()->get();
        $Data = \Input::get('data');
        $newTag = array();
        foreach ($tag as $t){
            if($t->idTag != $Data){
                array_push($newTag,$t->idTag);
            }
        }
        $tenant->tag()->sync($newTag);
        return \Response::json(array(
            'list_tag' => $tenant->tag()->get(),
        ));
    }

}
