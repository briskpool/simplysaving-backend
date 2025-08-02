<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Admin\Client;
use App\Models\Admin\Trade;
use App\Models\Admin\Transaction;
use App\Models\MembershipTypes;
use App\Models\UserMembershipBalances;
use App\Models\UserMemberships;
use App\Notifications\AddClientNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::with('trades')->where('users.is_admin', 0)
            ->orderBy('users.created_at', 'desc')->get();
        foreach ($clients as $client) {
            $client->client_balance = UserMembershipBalances::where('user_id', $client->id)->sum('balance');
        }
        return view('admin.clients.clients', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $membership_types = MembershipTypes::all();
        return view('admin.clients.add_client',compact('membership_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {

        if ($request->hasFile('profile_img')) {
            //getting the image name
            $image_full_name = $request->profile_img->getClientOriginalName();
            $image_name_arr = explode('.', $image_full_name);
            $image_name = $image_name_arr[0] . time() . '.' . $image_name_arr[1];

            //storing image at public/storage/products/$image_name
            $request->profile_img->storeAs('users', $image_name, 'public');
        } else {
            $image_name = 'placeholder.jpg';
        }



        $client = Client::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'profile_img' => $image_name,
            'password' => Crypt::encrypt($request->password),
            'currency_symbol' => $request->currency_symbol,
            'membership_type' => json_encode($request->membership_type),
            'is_admin' => 0,
        ]);

        //setting up success message
        if ($client) {

            $data = $client;

            if ($request['membership_type'] && is_array($request['membership_type'])) {
                foreach ($request['membership_type'] as $membership_type) {
                    $typeId = MembershipTypes::where('type', $membership_type)->value('id');
                    if ($typeId) {
                        $user_membership = new UserMemberships();
                        $user_membership->userid = $client->id;
                        $user_membership->membership_type_id = $typeId;
                        $user_membership->save();
                    }
                }
            }

            $client_data = [
                'first_name' => $client->first_name,
                'email' => $client->email,
                'password' => Crypt::decrypt($client->password),
            ];

            Notification::send($data, new AddClientNotification($client_data));
            $notification = array(
                'message' => 'Client added successfully!',
                'alert-type' => 'success'
            );
        }
        //setting up error message
        else {
            $notification = array(
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            );
        }

        return redirect()->route('clients.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $client = Client::where('users.id', $id)
            ->where('users.is_admin', 0)
            ->first();

        $client_membership_type = json_decode($client->membership_type);
        // Check if $client->membership_type is not JSON encoded
        if ($client_membership_type == null) {
            // Encode it to JSON
            $encoded_membership_type = json_encode([$client->membership_type]);
            // Update the $client object
            $client->membership_type = json_decode($encoded_membership_type);
        } else {
            $client->membership_type = $client_membership_type;
        }

        $client_membership_type_ids = UserMemberships::where('userid', $client->id)->pluck('membership_type_id');

        $client_statement_data = [];
        foreach ($client_membership_type_ids as $membership_type_id) {
            $membership_type = MembershipTypes::where('id', $membership_type_id)->pluck('type')->first();
            // Transactions data
            $client_statement_data[$membership_type] = $this->GetClientStatements($client->id, $membership_type_id);
            $client_statement_data[$membership_type]['balance'] = UserMembershipBalances::where('user_id', $client->id)
                                                                    ->where('membership_type_id',$membership_type_id)
                                                                    ->pluck('balance')->first();
            
            $trades = Trade::join('users', 'trades.user_id', 'users.id')
            ->where('trades.user_id', $id)
            ->where('trades.membership_type_id', $membership_type_id)
            ->orderBy('trades.created_at', 'desc')
            ->select('trades.*', 'users.first_name', 'users.last_name')
            ->with('membership')
            ->get();

            $client_statement_data[$membership_type]['trades'] = $trades;
        }

        return view('admin.clients.client_view', compact('client', 'client_statement_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $id = Crypt::decrypt($id);
        $client = Client::find($id);

        $membership_types = MembershipTypes::all();

        $client_membership_type = json_decode($client->membership_type);
        // Check if $client->membership_type is not JSON encoded
        if ($client_membership_type == null) {
            // Encode it to JSON
            $encoded_membership_type = json_encode([$client->membership_type]);
            // Update the $client object
            $client->membership_type = json_decode($encoded_membership_type);
        } else {
            $client->membership_type = $client_membership_type;
        }
        return view('admin.clients.edit_client', compact('client', 'membership_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, $id)
    {
        $id = Crypt::decrypt($id);

        $client = Client::find($id);
        if ($request->hasFile('profile_img')) {

            //deleting the previous Image
            Storage::disk('public')->delete('users/' . $client->profile_img);
            //getting the image name
            $image_full_name = $request->profile_img->getClientOriginalName();
            $image_name_arr = explode('.', $image_full_name);
            $image_name = $image_name_arr[0] . time() . '.' . $image_name_arr[1];

            //storing image at public/storage/products/$image_name
            $request->profile_img->storeAs('users', $image_name, 'public');
        } else {
            $image_name = 'placeholder.jpg';
        }



        // dd($request->is_secure);
        $client->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'profile_img' => $image_name,
            'password' => Crypt::encrypt($request->password),
            'is_admin' => 0,
            'email_verified_at' => $request->is_verified ? Carbon::now() : NULL,
            'status' => $request->status,
            'currency_symbol' => $request->currency_symbol,
            'membership_type' => $request->membership_type,
            'is_secure' => $request->is_secure ?? 0,
        ]);

        if ($request['membership_type'] && is_array($request['membership_type'])) {
            UserMemberships::where('userid', $id)->delete();
            foreach ($request['membership_type'] as $membership_type) {
                $typeId = MembershipTypes::where('type', $membership_type)->value('id');
                if ($typeId) {
                    $user_membership = new UserMemberships();
                    $user_membership->userid = $id;
                    $user_membership->membership_type_id = $typeId;
                    $user_membership->save();
                }
            }
        }

        //setting up success message
        if ($client) {
            $notification = array(
                'message' => 'Client Updated',
                'alert-type' => 'success'
            );
        }
        //setting up error message
        else {
            $notification = array(
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            );
        }

        return redirect()->route('clients.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $id = Crypt::decrypt($id);
        $client = Client::find($id);
        $transaction = Transaction::where('user_id', $id);
        $trade = Trade::where('user_id', $id);


        //deleting the image from the storage
        Storage::disk('public')->delete('users/' . $client->profile_img);

        if ($client->delete()) {
            if ($transaction) {
                $transaction->delete();
            }
            if ($trade) {
                $trade->delete();
            }
            //setting up success message
            $notification = array(
                'message' => 'Client Deleted',
                'alert-type' => 'success'
            );
        } else {
            //setting up error message
            $notification = array(
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            );
        }

        //redirecting to the page with notification message
        return redirect()->route('clients.index')->with($notification);
    }
}
