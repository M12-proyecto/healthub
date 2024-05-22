<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Mensaje;
use App\Models\User;
use GuzzleHttp\Psr7\Message;

class ChatController extends Controller
{
    public function show() {
        $usuario = auth()->user();
        $usuarios = User::where('id', '!=', $usuario->id)->get();
        return view('chat', compact('usuario', 'usuarios'));
    }

    // Método para iniciar un nuevo chat
    public function startChat(Request $request)
    {
        // Buscar un chat existente entre los dos usuarios
        $chat = Chat::where(function($query) use ($request) {
            $query->where('usuario1', $request->input('paciente_id'))
                  ->where('usuario2', $request->input('medico_id'));
        })->orWhere(function($query) use ($request) {
            $query->where('usuario1', $request->input('medico_id'))
                  ->where('usuario2', $request->input('paciente_id'));
        })->first();
    
        // Si no existe un chat, crear uno nuevo
        if (!$chat) {
            $chat = new Chat([
                'usuario1' => $request->input('paciente_id'),
                'usuario2' => $request->input('medico_id'),
                'fecha' => now()
            ]);
            $chat->save();
        }
    
        // Retornar el chat existente o creado
        return response()->json(['chat_id' => $chat->id]);
    }
    

    // Método para guardar un mensaje
    public function saveMessage(Request $request){
        // Crear un nuevo mensaje
        $mensaje = new Mensaje([
            'chat_id' => $request->input('chat_id'),
            'usuario1' => $request->input('usuario1'),
            'usuario2' => $request->input('usuario2'),
            'mensaje' => $request->input('mensaje'),
            'fecha' => Mensaje::formatDate($request->input('fecha')),
            'hora' => $request->input('hora'),
        ]);

        // Guardar el mensaje en la base de datos
        $mensaje->save();

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Mensaje guardado correctamente'], 200);
    }

    // Método para obtener todos los mensajes
    public function getMessages($chat_id)
    {
        // Obtener todos los mensajes del chat especificado
        $mensajes = Mensaje::where('chat_id', $chat_id)->get();

        // Retornar los mensajes en formato JSON
        return response()->json($mensajes);
    }

    // Método para eliminar un mensaje
    public function deleteMessage($id)
    {
        // Buscar el mensaje por su ID
        $mensaje = Mensaje::find($id);

        // Verificar si el mensaje existe
        if (!$mensaje) {
            // Retornar un mensaje de error si el mensaje no se encuentra
            return response()->json(['message' => 'Mensaje no encontrado'], 404);
        }

        // Eliminar el mensaje
        $mensaje->delete();

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Mensaje eliminado correctamente'], 200);
    }
}
