<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

use App\Post;
use App\Category;
use App\Tag;

use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts= Post::orderBy('id','DESC')
            ->where('user_id',auth()->user()->id)
            ->paginate();//dd($posts);
        return view('admin.posts.index',compact('posts'));//array   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::orderBy('name','ASC')->pluck('name','id');
        $tags=Tag::orderBy('name','ASC')->get();
        return view('admin.posts.create',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $post= Post::create($request->all());
        //Image
        if($request->file('file')){
            $path= Storage::disk('public')->put('image',$request->file('file'));

            $post->fill(['file'=>asset($path)])->save();//asse... crea la ruta completa donde se guarda laimage
        }
        //tags

        $post->tags()->attach($request->get('tags'));//syc: sincroniza la relacion que hay entre post y etiquetas //evalua para saber si la relacion esta 


        return redirect()->route('posts.edit',$post->id)//redireciona y envia el id de la etiqueta que recien se creo
            ->with('info','Entrada creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::find($id);
        return view('admin.posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories=Category::orderBy('name','ASC')->pluck('name','id');
        $tags=Tag::orderBy('name','ASC')->get();
        $post=Post::find($id);
        return view('admin.posts.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostStoreRequest $request, $id)
    {
        $post= Post::find($id);
        $post->fill($request->all())->save();

          //Image
        if($request->file('file')){
            $path= Storage::disk('public')->put('image',$request->file('file'));

            $post->fill(['file'=>asset($path)])->save();//asse... crea la ruta completa donde se guarda laimage
        }
        //tags

        $post->tags()->sync($request->get('tags'));//syc: sincroniza la relacion que hay entre post y etiquetas //evalua para saber si la relacion esta 

        return redirect()->route('posts.edit',$post->id)//redireciona y envia el id de la etiqueta que recien se creo
            ->with('info','Entrada actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $post=Post::find($id)->delete();
         return back()->with('info','Entrada eliminada correctamente');
        
    }
}
