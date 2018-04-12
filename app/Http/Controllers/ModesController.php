<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Modes;
use App\Lights;

class ModesController extends Controller
{
    public function addMode(Request $request){
        $fields = $request->only('name','playlist_name','playlist_uri');
        $fields['user_id'] = \JWTAuth::parseToken()->authenticate()->id;
        if(!$fields['playlist_name']){
            $fields['playlist_name'] = 'default';
            $fields['playlist_uri'] = 'default';
        }
        $mode = Modes::create($fields);
        if(isset($request['lights'])){
            $lightsInfo = $request['lights'];
            foreach($lightsInfo as &$light){
                $light['mode_id'] = $mode->id;
                Lights::create($light);
            }
        }
        return new Response(['success' => true, 'Mode_id' => $mode->id], 200);
    }
    
    public function editMode(Request $request){
        $mode = Modes::find($request['mode_id']);

        if(!$mode){
            return new Response(['success' => false,'Message' => 'mode not found'], 404);
        }

        if(isset($request['lights'])){
            $lights = $request['lights'];
            foreach($lights as &$light){
                Lights::find($light['id'])->update($light);
            }
        }
        $fields = $request->only('name','playlist_name','playlist_uri');
        $mode->update($fields);

        return new Response(['success' => true, 'mode' => $mode], 200);
    }
    
    public function getMode($id){
        $mode = Modes::find($id);

        if(!$mode){
            return new Response(['success' => false,'Message' => 'mode not found'], 404);
        }

        $mode['Lights'] = Lights::where('mode_id',$mode->id)->get();

        return new Response(['success' => true, 'Mode' => $mode], 200);
    }

    public function getAllModes(){

        $modes = Modes::all();

        foreach($modes as &$mode){
            $mode['lights'] = Lights::where('mode_id',$mode->id)->get();
        }
        return new Response(['success' => true, 'Modes' => $modes], 200);
    }
    
    public function removeMode($id){
        $mode = Modes::find($id);
        $mode->delete();
        
        Lights::where('mode_id',$id)->delete();
        
        return new Response(['success' => true], 200);
    }
}