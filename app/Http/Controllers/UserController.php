<?php

namespace App\Http\Controllers;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\UserInformation;
use Auth;
use Mail;
class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       $data=User::select('email','contact','id','name','userType','role','status')
       ->where('status',1)
       ->get();
       return $data;
   }
   public function profile()
   {
       $data=Auth::user();
       return $data;
   }
   public function pending()
   {
       $data=User::select('email','contact','id','name','userType','role','status')
       ->whereIn('status',[2,3])
       ->get();
       return $data;
   }
   public function completeuser()
   {
       $data=User::select('email','contact','id','name','userType','role','status')
       ->whereIn('status',[1,4])
       ->with('info')
       ->get();
       return $data;
   }
   
   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       
   }
   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => false
           ],200);
        }
        $request->validate([

        ]);
        if( isset($request->name) && isset($request->password) && isset($request->email))
        {
            $user=new User;
            $user->name=$request->input('name');
            $user->email=$request->input('email');
            $user->password=bcrypt($request->input('password'));
            $user->save();
        }
        else 
        {
            return response()->json([
                'data' => 'Attributes are missing',
                'status' => false
           ],200);
        }
 
        return response()->json([
            'data' => $user,
            'status' => true
        ],200);
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
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       
   }
   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
   }
   public function updateUser(Request $request)
   {
       $update=User::where('id',$request->id)->update(
           [
               'name' => $request->name
           ]);
       return $update;
   }
   public function updatepassword(Request $request)
   {
        $update=User::where('id',$request->id)->update(
           [
               'password'=>bcrypt($request->password),
               'status' => 3
           ]
        );
        $data['password'] =$request->password;
        $data['email'] =$request->email;
        Mail::send('mailview', $data, function($message) use ($request) {
            $message->to( $request->email , $request->name )
            ->subject('Agent Password for Homeyfi');
        });
       return $update;
   }
   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $group = User::where('id','=',$id)
         ->first();
       $group->delete();
       return $group;
   }
   public function login(Request $request)
   {
    // $state = $request->session()->pull('state');

    // throw_unless(
    //     strlen($state) > 0 && $state === $request->state,
    //     InvalidArgumentException::class
    // );

    // dd($request->all());
    if( isset($request->email) && isset($request->password))
    {
        $http = new \GuzzleHttp\Client;
        try {
            $response = $http->post('http://e40c7067.ngrok.io/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => '6VKtYRuE0OklduPq0tBSznGxrEFAqhCrO5Bwnl9v',
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json('Something went wrong on the server.', $e->getCode());
        }

    }
    else {
        return response()->json([
            'data' => 'Attributes are missing',
            'status' => false
       ],200);
    }
        
    }
    function tokenRequest(Request $request){

        $request->request->add([
                      "grant_type" => "password",
                      "username" => $request->email,
                      "password" => $request->password,
                      'client_id' => 2,
                      'client_secret' => '6VKtYRuE0OklduPq0tBSznGxrEFAqhCrO5Bwnl9v',
              ]);
      
              $tokenRequest = $request->create(
                      env('APP_URL').'/oauth/token',
                      'post'
              );
      
              $instance = Route::dispatch($tokenRequest);
      
              return json_decode($instance->getContent());
      
      }
    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json('Logged out successfully', 200);
    }
    public function changePass(Request $request)
    {
        $a=$request['oldPassword'];
        $b=$request['newPassword'];
        $c=$request['confirmPassword'];
        
        //if($a != auth()->user()->password)
        //echo 'not same';
        //return redirect('/app/profile');
                        
          


        $request->validate([
            'oldPassword' => ['required', new MatchOldPassword],
            'newPassword' => ['required'],
            'confirmPassword' => ['same:newPassword'],
        ]);
   
        $update=User::find(auth()->user()->id)->update(['password'=> Hash::make($request->newPassword)]);
   
        return $update;
    }
}