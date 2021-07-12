<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notes;

class NotesController extends Controller
{
    public function getAllNotes()
    {
        return Notes::all();
    }

    public function getNotes($userID)
    {
        $notes = DB::select('CALL spMostrarNotas(' . $userID . ')');

        if(sizeof($notes) > 0)
            return $notes;

        return response()->json([
            'error' => 'El usuario especificado no existe.'
        ]);
    }
        
    public function createNote(Request $request)
    {
        $note = new Notes();

        $note->id_usuario = $request->id_usuario;
        $note->titulo = $request->titulo;
        $note->contenido = $request->contenido;

        if(!empty($note->id_usuario) && !empty($note->titulo) && !empty($note->contenido))
        {
            DB::select('CALL spCrearNota(?, ?, ?)', [$note->id_usuario, $note->titulo, $note->contenido]);

            return response()->json([
                'message' => 'Note created successfully!',
                'data' => $note
            ]);
        }
        
        return response()->json([
            'error' => 'Favor de llenar todos los campos.'
        ]);
    }

    public function updateNote(Request $request)
    {
        $note = new Notes();

        $note->id = $request->id;
        $note->titulo = $request->titulo;
        $note->contenido = $request->contenido;

        if(!empty($note->id) || !empty($note->titulo) || !empty($note->contenido))
        {
            DB::select('CALL spActualizarNota(?, ?, ?)', [$note->id, $note->titulo, $note->contenido]);

            return response()->json([
                'message' => 'Note updated!',
                'data' => $note
            ]);
        }
       
        return response()->json([
            'message' => 'Favor de no dejar ningún campo vacío.'
        ]);
    }

    public function deleteNote($userID, Request $request)
    {

        $result = DB::select('CALL spEliminarNota(?)', [$userID]);

        return json_encode([
            'message' => 'Note deleted successfully!'
        ]);
    }
}