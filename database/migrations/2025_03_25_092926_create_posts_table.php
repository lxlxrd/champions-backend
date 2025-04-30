<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->text('content');
            // deux types de posts  
            //  annonce 1x par an  
            // gallery régulièrement 
            $table->enum('type', ['PUBLICATION', 'GALERY']); 
            // peut être null les posts de type annonce  mais obligatoires pour les post de type gallery
            $table->string('image_path')->nullable();  
            $table->timestamps();


            //  exemple de requête pour récupérer une annonce 
            // $annonces = Post::where('type', 'annoucement)->orderBy('created_at,  'desc')->get(); récupérer de la table post les annonces du plus récent aux anciens  

            // récupérer les 5 dernières gallery 
            // $photos = Post::where('type', 'gallery')->with('image')->latest()->take(5)->get() le with si il y a une relation avec image  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
