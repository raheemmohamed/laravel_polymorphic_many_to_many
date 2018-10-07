<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Post;
use App\Tag;
use App\Video;

Route::get('/', function () {
    return view('welcome');
});


//Insert some tag table values
Route::get('/inserttags', function(){

    Tag::create(['name'=>'PHP']);
    Tag::create(['name'=>'Laravel']);
    Tag::create(['name'=>'codeigniter']);
    Tag::create(['name'=>'Javascript']);
});


//insert data by polymorphic many to many relationship
Route::get('/insertmanytomanypolymorphic',function(){
    /*============== Insert post table record and insert to taggable table with tag table id=====================*/
    //Insert first post in Post table
    $post = Post::create(['name'=>'PHP first post']);
    //find the tag table where id 2
    $tag1 = Tag::find(1);
    //post model called method tags which is morphToMany-> save the $tag1 find tag table value
    $post->tags()->save($tag1);


    /*============== Insert Video table record and insert to taggable table with tag table id =====================*/
    $video = Video::create(['name'=>'larvelvideo.mov']);

    $tag1 = Tag::find(2);

    $video->vidoe_tags()->save($tag1);

});


//read polymorphic many to many relationship
Route::get('/readpolymorphicmanytomany',function(){

    $post = Post::find(2);

    foreach($post->tags as $p){
        echo $p->name."<br>";
    }

});

//update many to many polymorphic relationship
Route::get('/updatePolymorphicmanytomany',function(){
    $post = Post::findOrFail(2);

    foreach($post->tags as $tag_post){
        $tag_post->whereName('PHP')->update(['name'=>'updated PHP']);
    }

});


//update many to many polymorphic relationship Method:2
Route::get('/updatePolymorphicmanytomany2',function(){
   $post = Post::findOrFail(2);
   $post->tags()->where('id',1)->update(['name'=>'PHP programming']);
});

//delete Polymorphic many to many records
Route::get('/deletepolymorphicmanytomany',function(){
    $post = Post::findOrFail(1);

    foreach($post->tags as $tagas){
        $tagas->where('id',2)->delete();
    }
});