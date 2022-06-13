<?php
namespace App\http\Controllers;

use Illuminate\Http\Request;
use App\Libro;

use Carbon\Carbon;

class LibroController extends Controller{
    public function index(){
        // llamando al modulo libro para la conexion con bd 
        // que traiga todo
        $datosLibro=Libro::all();

        return response()->json($datosLibro);
    }

    // Guardando los datos mediante un metodo post
    public function guardar(Request $request){

        //pasar los datos a la bd
        $datosLibro = new Libro;


        // para validar si existe el nombre de la imagen 
        // nos creara una carpeta e iniciara todos los archivos dentro
        if($request->hasFile('imagen')){
            $nombreArchivoOriginal=$request->file('imagen')->getClientOriginalName();

            // obtendremos el tiempo en el que subimos el archivo
            $nuevoNombre=Carbon::now()->timestamp.'_'.$nombreArchivoOriginal;

            // Carpeta en donde se guardara los datos
            $carpetaDestino='./upload/';
            $request->file('imagen')->move($carpetaDestino, $nuevoNombre);

             // recepcionando la informacion a traves de la imagen
            $request->file('imagen');

            // colocando los datos en sus campos
            $datosLibro->titulo=$request->titulo;

            // Recepcionando la imagen dentro de la carpeta
            $datosLibro->imagen=ltrim($carpetaDestino,'.').$nuevoNombre;
            $datosLibro->save();

        }


       
    
        return response()->json($nuevoNombre);
    }

    // para visualizar la informacion por el ID
    public function ver($id){
        $datosLibro=new Libro;
        $datosEncontrados =$datosLibro->find($id);

        return response()->json($datosEncontrados);
    }

    public function eliminar($id){

        $datosLibro = Libro::find($id);

        if($datosLibro){
            $rutaArchivo=base_path('public').$datosLibro->imagen;

            if(file_exists($rutaArchivo)){
                unlink($rutaArchivo);
            }
            $datosLibro->delete();
        }
        return response()->json("Registro Borrado");
    }

    // Funcion actualizar datos
    public function actualizar(Request $request, $id){
        $datosLibro=Libro::find($id);

        if($request->hasFile('imagen')){

            if($datosLibro){
                $rutaArchivo=base_path('public').$datosLibro->imagen;
    
                if(file_exists($rutaArchivo)){
                    unlink($rutaArchivo);
                }
                $datosLibro->delete();
            }




            $nombreArchivoOriginal=$request->file('imagen')->getClientOriginalName();

            // obtendremos el tiempo en el que subimos el archivo
            $nuevoNombre=Carbon::now()->timestamp.'_'.$nombreArchivoOriginal;

            // Carpeta en donde se guardara los datos
            $carpetaDestino='./upload/';
            $request->file('imagen')->move($carpetaDestino, $nuevoNombre);

             // recepcionando la informacion a traves de la imagen
            $request->file('imagen');


            // Recepcionando la imagen dentro de la carpeta
            $datosLibro->imagen=ltrim($carpetaDestino,'.').$nuevoNombre;
            $datosLibro->save();

        }
        
        if($request->input('titulo')){

            $datosLibro->titulo=$request->input('titulo');

        }

        $datosLibro->save();

        return response()->json("datos Actualizados");
    }
}