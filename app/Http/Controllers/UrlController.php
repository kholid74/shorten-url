<?php
namespace App\Http\Controllers;
 
use App\Url;
use Illuminate\Http\Request;
 
class UrlController extends Controller {
 
public function index()
{
    $url = Url::all();
    return response()->json($url);
}
 
public function create(Request $request)
    {
        $this->validate($request, [
            'url'=>'required|url',
        ]);
        $shortUrl = new Url();
        $shortUrl->long_url = $request->get('url');
        Url::create($request->all());
        $shortUrl->save();
        return response()->json(['success'=>true, 'long_url'=>$shortUrl->getShortUrl()]);
    }

public function redirect($code)
    {
        $shortUrl = Url::findByCode($code)[0];
        return redirect($shortUrl->long_url);
    }
 
public function show($id)
    {
        $url = Url::find($id);
        return response()->json($url);
    }
 
public function update(Request $request, $id)
{
    $url = Url::find($id);
    $url->update($request->all());
 
    return response()->json([
    'message' => 'Successfull update'
]);
}
 
public function delete($id)
{
    Url::destroy($id);
    return response()->json([
    'message' => 'Successfull delete'
]);
}
 
 
}