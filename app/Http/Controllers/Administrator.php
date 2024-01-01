<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PeterPetrus\Auth\PassportToken;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrator as Admin;
use DB;

class Administrator extends Controller
{
    public function register(Request $request)
    {
        $sendarray = array();
        $post_val =     $request->all();

        $email = $post_val['email'];
        $post_val['password'] = \Hash::make($post_val['password']);
        
        if(!empty($post_val['image']))
		{
			if($request->hasFile('image')) 
			{
				$image = $post_val['image'];
				$extension= $image->getClientOriginalExtension();
				$shtname=time(). rand (0,9 );
				$fileName = $shtname.'.'.$extension;
				$directory=date('Y').'/'.date('M').'/'.date('d');
				if(trim($fileName)!="")
				{
					$destinationPath = public_path('upload').'/'.$directory;
					$image->move($destinationPath, $fileName);
				}
				$post['image'] =  'upload/'.$directory.'/'.$fileName;
			}
			else
			{
				$post['image'] = $post['image'];
			}
		}
		else
		{
			$post['image'] =  "";
		}

        $is_exist = Admin::where('email',$email)->where('status',1)->first();

        if(!empty($is_exist->email))
		{
			$sendarray['status'] = 0;
			$sendarray['message'] = 'user already axist.';
			return json_encode($sendarray);
		}
        elseif(!empty($is_exist->mobile))
		{
			$sendarray['status'] = 0;
			$sendarray['message'] = 'user already axist.';
			return json_encode($sendarray);
		}
		

        $query = DB::table('administrator')->insert($post_val);
        if($query)
        {
            $sendarray['status'] = 1;
            $sendarray['message'] = "successfully register.";
        }
        else
        {
            $sendarray['status'] = 0;
            $sendarray['message'] = "something went wrong.";
        }
        echo json_encode($sendarray);
    }

    public function login(Request $request)
    {
        $sendarray = array();

        $email    = $request->email; 
        $password = $request->password; 
        $user     = Admin::where('email',$email)->where('status',1)->first();

        if(!empty($user))
        {
            if(Hash::check($password, $user->password))
            {
                $token = $user->createToken('Token')->accessToken;
                $sendarray['status']  = 1;
                $sendarray['message'] = 'successfully login.';
                $sendarray['token']   = $token; 
                $sendarray['data']   = $user; 
                
            }
            else
            {
                $sendarray['status']  = 0;
                $sendarray['message'] = 'wrong password.';
            }
        }
        else
        {
            $sendarray['status']  = 0;
            $sendarray['message'] = 'mail not register..';
        }
        echo json_encode($sendarray);
    }
}
