<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'Surname' => ['required', 'string', 'max:255'],
            'Location' => ['required', 'string', 'max:255'],
            'Mobile' => ['required'],




            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

   

    public function Category( $user, $name){
        DB::table('categories')->insert([

            ['category'=>'Loan ABC Company','Nature'=>'Non-Current Liabilities','Added_by'=>$user],
            ['category'=>'Loan XXX Company','Nature'=>'Non-Current Liabilities','Added_by'=>$user],
            ['category'=>'Mortage bond','Nature'=>'Non-Current Liabilities','Added_by'=>$user],
            ['category'=>'Credit Card','Nature'=>'Current Liabilities','Added_by'=>$user],
            ['category'=>'Bank (Dr)','Nature'=>'Current Assets','Added_by'=>$user],
     
            ['category'=>'Accrued Expenses','Nature'=>'Current Liabilities','Added_by'=>$user],
            ['category'=>'Income Recived in-advance','Nature'=>'Current Liabilities','Added_by'=>$user],
            ['category'=>'Other Income','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Sales','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Rent Income','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Interest Income','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Profit on Asset Desposal','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Salary Earned','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Gift Income','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Allowance Income','Nature'=>'Income','Added_by'=>$user],
            ['category'=>'Rent Apartment','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Salary and Wages','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Stationery','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Fuel','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Groceries','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Repairs','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Telephone and Connection','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Water and Electricity','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Entertainment','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Sundry Expenses','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Transport','Nature'=>'Expenses','Added_by'=>$user],
            ['category'=>'Business: Cash drawings ','Nature'=>'Drawings','Added_by'=>$user],
            ['category'=>'Business: Stock drawings ','Nature'=>'Drawings','Added_by'=>$user],
            ['category'=>'Business: Cash Capital ','Nature'=>'Capital','Added_by'=>$user],
            ['category'=>'Equipment','Nature' =>'Current Assets','Added_by'=>$user],
            ['category'=>'Vehicle','Nature' =>'Current Assets','Added_by'=>$user],
            ['category'=>'Land and Buildings','Nature' =>'Current Assets','Added_by'=>$user],
            ['category'=>'Debtor Control','Nature' =>'Current Assets','Added_by'=>$user],
            ['category'=>'Prepared Expenses','Nature' =>'Current Assets','Added_by'=>$user],


            
        ]   );

$number=1234567890123000+$user;
        Db::table('cards')->insert([
       

            'CardNumber'=>$number,
            'Type'=>'Debit Card',
            'ExpiryDate'=>'08-28',
          'CVC'=>'123',
          'Cardholder'=>$name,
            'Status'=>'Active',
            'Added_by'=>$user



        ]);
    }


      /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'Surname' => $data['Surname'],
            'Mobile' => $data['Mobile'],
            'Location' => $data['Location'],
            'password' => Hash::make($data['password']),
              'last_seen'=>Now()
        ]);

        Mail::to($user->email)->send(new WelcomeMail);
    
        $this->Category($user->id, $user->name);

      
    
        return $user;


      



    }
}
