<?php
namespace Mock\RPC\Controller;

class Mock
{
    public function index(){

        $message = Message::where('user_id', $request->attributes->get('userid'))->get();
        $payload = [];

        foreach ($message as $msg){

                   $payload[$msg->id] =
                       [
                               'body' => $msg->body,
               'user_id' => $msg->user_id,
               'created_at' => $msg->created_at
       ];
}

         return json_encode($payload, JSON_UNESCAPED_SLASHES);
    }

    public function edit($id){
        // show edit form
    }

    public function show($id){
        // show the user #id
    }

    public function store(){
        // create a new user, using POST method
    }

    public function update($id){
        // update the user #id, using PUT method
    }

    public function destroy($id){
        // delete the user #id, using DELETE method
    }
}