<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leaguestanding;
use App\Recordgames;

class FootballController extends Controller
{
    function leaguestanding(){
        $data = Leaguestanding::all()->sortByDesc('points')->values();

        if(count($data) > 0){ //mengecek apakah data kosong atau tidak
            return response($data);
        }
        else{
            $res['message'] = "Empty!";
            return response($res);
        }
    }
    function recordgame(Request $request){
        
        $score_explode = explode(":",$request->post('score'));
		$scorehome = $score_explode[0];
        $scoreaway = $score_explode[1];
        $clubhomename = $request->input('clubhomename');
        $clubawayname = $request->input('clubawayname');
        $data = new Recordgames();
        $data->clubhomename = $clubhomename;
        $data->clubawayname = $clubawayname;
        $data->score        = $request->input('score');
        $data->save();
    
    
    //menambahkan point ke league standing
    $checkclubhome = Leaguestanding::where('clubname',$clubhomename)->first();
    $checkclubaway = Leaguestanding::where('clubname',$clubawayname)->first();
    $home = $checkclubhome['clubname'];
    $away = $checkclubaway['clubname'];
   
        //ini home
            if($home == $clubhomename){
                if($scorehome > $scoreaway){
                    $data = Leaguestanding::where('clubname',$clubhomename)->first();
                    $data->clubname = $clubhomename;
                    $data->points = $data->points + 3;
                    $data->save();
                     
                }elseif ($scorehome < $scoreaway) {
                    if($away == $clubawayname){
                        $dataaway = Leaguestanding::where('clubname',$clubawayname)->first();
                        $dataaway->clubname = $clubawayname;
                        $dataaway->points = $dataaway->points + 3;
                        $dataaway->save();
                     }else{
                        $dataaway = new Leaguestanding();
                        $dataaway->clubname = $clubawayname;
                        $dataaway->points   = 3;
                        $dataaway->save();
                     }
                }elseif($scorehome == $scoreaway){
                    $data = Leaguestanding::where('clubname',$clubhomename)->first();
                    $data->clubname = $clubhomename;
                    $data->points = $data->points + 1;
                    $data->save();
                        if($away == $clubawayname){
                            $dataaway = Leaguestanding::where('clubname',$clubawayname)->first();
                            $dataaway->clubname = $clubawayname;
                            $dataaway->points = $dataaway->points + 1;
                            $dataaway->save();
                         }else{
                            $dataaway = new Leaguestanding();
                            $dataaway->clubname = $clubawayname;
                            $dataaway->points   = 1;
                            $dataaway->save();
                         }
                }
                return response('berhasil');
        } else{
            if($scorehome > $scoreaway){
                $data = new Leaguestanding();
                $data->clubname = $clubhomename;
                $data->points   = 3;
                $data->save();

                $data = new Leaguestanding();
                $data->clubname = $clubawayname;
                $data->points   = 0;
                $data->save();
                
            }elseif ($scorehome < $scoreaway) {
                $data = new Leaguestanding();
                $data->clubname = $clubawayname;
                $data->points   = 3;
                $data->save();

                $data = new Leaguestanding();
                $data->clubname = $clubhomename;
                $data->points   = 0;
                $data->save();

            }elseif($scorehome == $scoreaway){
                $data = new Leaguestanding();
                $data->clubname = $clubhomename;
                $data->points   = 1;
                $data->save();

                $dataaway = new Leaguestanding();
                $dataaway->clubname = $clubawayname;
                $dataaway->points   = 1;
                $dataaway->save();
            }
        }
        return response('Berhasil');
    }
    function rank(Request $request){
        $clubname = $request->input('clubname');
        $data = Leaguestanding::where('clubname',$clubname)->first();
        $datapoint = Leaguestanding::all()->sortByDesc('points')->values();
    
        for ($i = 0; $i < count($datapoint); $i++)
        {
             if ($datapoint[$i]->clubname == $clubname)
             {   
                 $i += 1;
                 $rankstanding = $i;
                
              }
         }
    $res['club'] = $clubname;
    $res['rank'] = $rankstanding;
    return response($res);
        }

   
}
